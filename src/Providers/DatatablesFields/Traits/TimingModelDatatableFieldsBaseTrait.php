<?php

namespace IlBronza\Timings\Providers\DatatablesFields\Traits;

use IlBronza\Timings\Models\Timing;

trait TimingModelDatatableFieldsBaseTrait
{
	public function getTimingModel($value) : ? Timing
	{
		return $value->getTiming();
	}
}