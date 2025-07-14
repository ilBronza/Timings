<?php

namespace IlBronza\Timings;

use IlBronza\Timings\Helpers\TimingestimationProviderHelper;
use IlBronza\Timings\Interfaces\HasTimingInterface;
use IlBronza\Timings\Models\TimingBaseModel;
use IlBronza\Timings\Models\Timingestimation;
use ReflectionClass;

use function class_basename;
use function dd;

abstract class TimingEstimator extends BaseTimingHelper
{
	static string $helperTypeName = 'timingEstimator';

	abstract function getBaseTime() : float;
	abstract function getCoefficients() : array;

	public function provideTimingModel() : TimingBaseModel
	{
		return TimingestimationProviderHelper::provide(
			$this->getModel()
		);
	}

	public function execute() : self
	{
		$this->baseHourTime = $this->getBaseTime();

		$coefficients = $this->getCoefficients();

		foreach($coefficients as $coefficient)
			$this->baseHourTime *= $coefficient;
		
		foreach($this->getModelChildren() as $child)
		{
			$childTime = static::calculate($child);

			$this->baseHourTime += $childTime->getHours();
		}

		$this->setParameters($coefficients);
		$this->setHours(
			$this->baseHourTime,
			true
		);

		return $this;
	}
}