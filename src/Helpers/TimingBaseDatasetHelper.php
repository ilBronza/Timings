<?php

namespace IlBronza\Timings\Helpers;

use Exception;
use IlBronza\ChartJs\Data;
use IlBronza\ChartJs\Dataset;
use IlBronza\Timings\BaseTimingHelper;
use IlBronza\Timings\Models\TimingBaseModel;

use function class_basename;
use function config;
use function dd;
use function lcfirst;
use function secondsToMinutes;
use function trans;

abstract class TimingBaseDatasetHelper
{
	protected TimingBaseModel $timingModelModel;

	abstract public function getTimingModelParameters() : array;
	abstract public function getLabel() : string;
	abstract public function getBackgroundColor() : string;

	static function getConfigString(string $modelClassName): string
	{
		return 'timings.helpers.models.' . $modelClassName. '.timingDatasetHelper';
	}

	static function getDataset(TimingBaseModel $timingModel)
	{
		//get studly model class basename
		$modelClassName = lcfirst(
			class_basename($timingModel)
		);

		$configString = self::getConfigString($modelClassName);

		if (! $helperClass = config($configString))
			throw new \Exception('Configuration for timing helper not found: ' . $configString);

		$helper = new $helperClass($timingModel);

		return $helper->execute();
	}

	public function __construct(TimingBaseModel $timingModel)
	{
		$this->timingModel = $timingModel;
	}

	public function getTimingModel() : TimingBaseModel
	{
		return $this->timingModel;
	}

	public function execute()
	{
		$dataset = new Dataset();

		foreach ($this->getTimingModelParameters() as $key)
		{
			try
			{
				$dataset->addData(
					Data::createFromArray([
						'x' => trans('timings.' . $key),
						'y' => secondsToMinutes(
							$this->getTimingModel()->parameters[$key] ?? 0
						)
					])
				);
			}
			catch (Exception $e)
			{
				dd([$e->getMessage(), $this->getTimingModel()->getAttributes()]);
			}
		}

		$dataset->setLabel(
			$this->getLabel()
		);

		$dataset->setBackgroundColor(
			$this->getBackgroundColor()
		);

		return $dataset;
	}
}