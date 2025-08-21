<?php

namespace IlBronza\Timings\Helpers;

use IlBronza\Timings\Interfaces\HasTimingInterface;
use IlBronza\Timings\Models\TimingEstimation;

class TimingEstimationProviderHelper
{
	static function provide(HasTimingInterface $model) : TimingEstimation
	{
		if ($timingEstimation = $model->getTimingEstimation())
			return $timingEstimation;

		return $model->timingEstimation()->save(
			TimingEstimation::gpc()::make()
		);
	}
}