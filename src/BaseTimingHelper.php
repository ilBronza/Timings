<?php

namespace IlBronza\Timings;

use IlBronza\Timings\Helpers\TimingestimationProviderHelper;
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
abstract class BaseTimingHelper
{
	public TimingBaseModel $timingModel;

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

	abstract static function getHelperConfigTypeName() : string;

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

	public function __construct(HasTimingInterface $model)
	{
		$this->model = $model;

		$this->setModelChildren();

		$this->setTimingModel();
	}

	public function setTimingModel()
	{
		$this->timingModel = $this->provideTimingModel();

		$this->timingModel->setQuantityRequired(
			$this->getModel()->getQuantityRequired()
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

	public function setHours(float $hours, bool $save = false): void
	{
		$timing = $this->getTimingModel();

		$timing->setHours(
			$hours,
			$save
		);
	}

	public function getHours() : float
	{
		return $this->baseHourTime;
	}
}