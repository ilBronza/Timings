<?php

namespace IlBronza\Timings;

use IlBronza\Timings\Helpers\TimingEstimationProviderHelper;
use IlBronza\Timings\Interfaces\HasTimingInterface;
use IlBronza\Timings\Models\TimingBaseModel;
use Illuminate\Support\Collection;
use function class_basename;
use function config;
use function lcfirst;

/**
 * Abstract base class for timing helpers.
 *
 * Provides shared logic for retrieving configuration and calculating timings.
 */
class BaseTimingHelper
{
	public TimingBaseModel $timingModel;

	public float $baseHourTime;

	public ? self $parent = null;
	public array $data;

    /**
     * Static name to identify the helper in configuration.
     *
     * @var string
     */
	static string $helperTypeName;

    /**
     * The model that implements HasTimingInterface used for timing calculation.
     *
     * @var HasTimingInterface
     */
	public HasTimingInterface $model;

	public Collection $modelChildren;


    /**
     * Build the configuration key path for the current helper and model class.
     *
     * @param string $modelClassName
     * @return string
     */
	static function getConfigString(string $modelClassName): string
	{
		return 'timings.helpers.models.' . $modelClassName. '.' . static::getHelperConfigTypeName();
	}

	static function _execute(HasTimingInterface $model) : self
	{
		//get studly model class basename
		$modelClassName = lcfirst(
			class_basename($model)
		);

		$configString = static::getConfigString($modelClassName);

		if (! $helperClass = config($configString))
			throw new \Exception('Configuration for timing helper not found: ' . $configString);

		$helper = new $helperClass($model);

		return $helper->execute();
	}

	public function setParent(self $parent): void
	{
		$this->parent = $parent;

		$this->getTimingModel()->associateParent(
			$parent->getTimingModel()
		);
	}

    /**
     * Calculate timing values using the configuration and model class.
     *
     * @param HasTimingInterface $model
     * @return void
     */
	static function calculate(HasTimingInterface $model) : self
	{
		return static::_execute($model);
	}

	static function calculateAll(HasTimingInterface $model)
	{
		TimingEstimator::calculate($model);
		TimingCalculator::calculate($model);
	}

	public function __construct(HasTimingInterface $model)
	{
		$this->model = $model;

		$this->setModelChildren();

		$this->setTimingModel();
	}

	public function setTimingModel()
	{
		$this->timingModel = $this->provideTimingModel();

		$this->timingModel->setQuantity(
			$this->getQuantity()
		);
	}

	//set model
	protected function setModel(HasTimingInterface $model): void
	{
		$this->model = $model;
	}

	//get model
	protected function getModel(): HasTimingInterface
	{
		return $this->model;
	}

	public function setModelChildren(): void
	{
		$this->modelChildren = $this->getModel()->getTimingChildren();
	}

	public function getModelChildren(): Collection
	{
		return $this->modelChildren;
	}

	public function getTimingModel() : TimingBaseModel
	{
		return $this->timingModel;
	}

	public function setParameters(array $parameters, bool $save = false): void
	{
		$timing = $this->getTimingModel();

		$timing->setParameters(
			$parameters,
			$save
		);
	}

	public function setError(string $errorMessage)
	{
		$timing = $this->getTimingModel();

		$timing->setError(
			$errorMessage,
			true
		);
	}

	public function setHours(float $hours, bool $save = false): void
	{
		$timing = $this->getTimingModel();

		$timing->setHours(
			$hours,
			$save
		);
	}

//	public function getHours() : float
//	{
//		return $this->baseHourTime;
//	}

	public function getBaseHourTime() : ? float
	{
		if(isset($this->baseHourTime))
			return $this->baseHourTime;

		return null;
	}

	static function getHelperConfigTypeName() : string
	{
		return static::$helperTypeName;
	}

	public function getData() : array
	{
		if(isset($this->data))
			return $this->data;

		return [];
	}

}