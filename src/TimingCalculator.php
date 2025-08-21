<?php

namespace IlBronza\Timings;

use App\Processing;
use IlBronza\Timings\Helpers\TimingEstimationProviderHelper;
use IlBronza\Timings\Helpers\TimingProviderHelper;
use IlBronza\Timings\Models\Timing;
use IlBronza\Timings\Models\TimingBaseModel;
use IlBronza\Timings\Models\TimingEstimation;
use Illuminate\Support\Collection;

use function class_basename;
use function dd;
use function is_numeric;

abstract class TimingCalculator extends BaseTimingHelper
{
	public TimingEstimation $timingEstimation;

	public Collection $processings;

	static string $helperTypeName = 'timingCalculator';

	abstract function processData(): void;

	public function provideTimingModel() : TimingBaseModel
	{
		return TimingProviderHelper::provide(
			$this->getModel()
		);
	}

	public function getQuantity()
	{
		return $this->getModel()->getQuantityDone();
	}

	protected function provideTimingEstimation() : ? TimingEstimation
	{
		if(isset($this->timingEstimation))
			return $this->timingEstimation;

		if($timingEstimation = $this->getModel()->getTimingEstimation())
		{
			$this->timingEstimation = $timingEstimation;

			return $this->timingEstimation;
		}

		if($timingEstimation = $this->getModel()->timingEstimation()->first())
		{
			$this->timingEstimation = $timingEstimation;

			return $this->timingEstimation;
		}

		$timingEstimator = TimingEstimator::calculate($this->getModel());

		$this->timingEstimation = $timingEstimator->provideTimingModel();

		return $this->timingEstimation;
	}

	public function getTimingEstimation() : TimingEstimation
	{
		return $this->timingEstimation;
	}

	public function setDiscrepancies($estimation)
	{
		$timing = $this->getTimingModel();

		$estimatedQuantity = $estimation->getQuantity();
		$estimatedSeconds = $estimation->getSeconds();

		$quantityDone = $timing->getQuantity();
		$secondsDone = $timing->getSeconds();

		$deltaQuantityEstimation = $estimatedQuantity
			? (($quantityDone - $estimatedQuantity) / $estimatedQuantity) * 100
			: null;

		$deltaQuantityTiming = $quantityDone
			? (($estimatedQuantity - $quantityDone) / $quantityDone) * 100
			: null;

		$deltaSecondsEstimation = $estimatedSeconds
			? (($secondsDone - $estimatedSeconds) / $estimatedSeconds) * 100
			: null;

		$deltaSecondsTiming = $secondsDone
			? (($estimatedSeconds - $secondsDone) / $secondsDone) * 100
			: null;

		$timing->setDeltaQuantity($deltaQuantityEstimation);
		$timing->setDeltaSeconds($deltaSecondsEstimation);
		$timing->setDelta($deltaQuantityEstimation - $deltaSecondsEstimation);
		$timing->save();

		$estimation->setDeltaSeconds($deltaSecondsTiming);
		$estimation->setDeltaQuantity($deltaQuantityTiming);
		$estimation->setDelta($deltaQuantityTiming - $deltaSecondsTiming);
		$estimation->save();
	}

	public function execute() : self
	{
		try
		{
			$this->setProcessings($this->getModel()->getProcessings());

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

			if($timingEstimation = $this->provideTimingEstimation())
				$this->setDiscrepancies($timingEstimation);

		}
		catch(\Throwable $e)
		{
			$this->setError($e->getMessage());
		}

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

}
