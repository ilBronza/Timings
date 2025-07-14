<?php

namespace IlBronza\Timings\Helpers;

use IlBronza\Timings\Interfaces\HasTimingInterface;
use IlBronza\Timings\Models\Timing;

class TimingProviderHelper
{
	static function provide(HasTimingInterface $model) : Timing
	{
		if ($timing = $model->getTiming())
			return $timing;

		return $model->timing()->save(
			Timing::gpc()::make()
		);
	}
}