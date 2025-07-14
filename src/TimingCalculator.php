<?php

namespace IlBronza\Timings;

use App\Processing;
use IlBronza\Timings\Helpers\TimingestimationProviderHelper;
use IlBronza\Timings\Helpers\TimingProviderHelper;
use IlBronza\Timings\Models\TimingBaseModel;

use Illuminate\Support\Collection;

use function class_basename;
use function is_numeric;

abstract class TimingCalculator extends BaseTimingHelper
{
	public Collection $processings;

	public array $data;
	static string $helperTypeName = 'timingCalculator';

	abstract function processProcessingsData(): void;

	public function provideTimingModel() : TimingBaseModel
	{
		return TimingProviderHelper::provide(
			$this->getModel()
		);
	}

	public function execute() : self
	{
		$this->setProcessings($this->getModel()->getProcessings());

		$data = $this->processProcessingsData();

		foreach($this->getModelChildren() as $child)
		{
			$childTimingHelper = static::calculate($child);

			foreach($childTimingHelper->getData() as $key => $value)
			{
				if(is_null($value))
					continue;

				if(is_numeric($value))
					$data[$key] = ($data[$key] ?? 0) + $value;

				else
				{
					dd(['pensa a cosa fare con sto $key', $key, $value]);
				}
			}

//			$this->baseHourTime += $childTimingHelper->getHours();
		}

//		$this->setParameters($coefficients);
//		$this->setHours(
//			$this->baseHourTime,
//			true
//		);
//
		return $this;
	}

	public function setProcessings(Collection $processings)
	{
		$this->processings = $processings;
	}

	public function getProcessings() : Collection
	{
		return $this->processings;
	}

	public function getData() : array
	{
		return $this->data;
	}

}
