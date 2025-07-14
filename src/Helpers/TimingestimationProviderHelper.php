<?php

namespace IlBronza\Timings\Helpers;

use IlBronza\Timings\Interfaces\HasTimingInterface;
use IlBronza\Timings\Models\Timingestimation;

class TimingestimationProviderHelper
{
	static function provide(HasTimingInterface $model) : Timingestimation
	{
		if ($timingEstimation = $model->getTimingEstimation())
			return $timingEstimation;

		return $model->timingestimation()->save(
			Timingestimation::gpc()::make()
		);
	}
}