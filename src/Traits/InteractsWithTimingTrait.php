<?php

namespace IlBronza\Timings\Traits;

use IlBronza\Timings\Models\Timing;
use IlBronza\Timings\Models\Timingestimation;

trait InteractsWithTimingTrait
{
	public function timing()
	{
		return $this->morphOne(Timing::gpc(), 'timeable');
	}

	public function getTiming() : ? Timing
	{
		return $this->timing;
	}

	public function timingestimation()
	{
		return $this->morphOne(Timingestimation::gpc(), 'timeable');
	}

	public function getTimingestimation() : ?Timingestimation
	{
		return $this->timingestimation;
	}


}