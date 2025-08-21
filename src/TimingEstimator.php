<?php

namespace IlBronza\Timings;

use IlBronza\Timings\Helpers\TimingEstimationProviderHelper;
use IlBronza\Timings\Interfaces\HasTimingInterface;
use IlBronza\Timings\Models\TimingBaseModel;
use IlBronza\Timings\Models\TimingEstimation;
use ReflectionClass;

use function class_basename;
use function dd;
use function is_null;
use function is_numeric;

abstract class TimingEstimator extends BaseTimingHelper
{
	static string $helperTypeName = 'timingEstimator';

	abstract function getBaseTime() : float;
	abstract function getCoefficients() : array;

	public function provideTimingModel() : TimingBaseModel
	{
		return TimingEstimationProviderHelper::provide(
			$this->getModel()
		);
	}

	public function getQuantity()
	{
		return $this->getModel()->getQuantityRequired();
	}

	public function execute() : self
	{
		try
		{
			$this->processData();

			foreach($this->getModelChildren() as $child)
			{
				$childTimingHelper = static::calculate($child);

				$childTimingHelper->setParent($this);

				foreach($childTimingHelper->getData() as $key => $value)
				{
					if(is_null($value))
						continue;

					if(is_numeric($value))
						$this->data[$key] = ($this->data[$key] ?? 0) + $value;

					else
					{
						dd(['pensa a cosa fare con sto $key', $key, $value]);
					}
				}

				$this->baseHourTime += $childTimingHelper->getBaseHourTime();
			}

			$this->setParameters($this->data);

			$this->setHours(
				$this->getBaseHourTime(),
				true
			);
		}
		catch(\Throwable $e)
		{
			$this->setError($e->getMessage());
		}

		return $this;
	}
}