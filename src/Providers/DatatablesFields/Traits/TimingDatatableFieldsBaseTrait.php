<?php

namespace IlBronza\Timings\Providers\DatatablesFields\Traits;

use function dd;

trait TimingDatatableFieldsBaseTrait
{
	public function transformValue($value)
	{
		$timingModel = $this->getTimingModel($value);

		return floor(
			$timingModel?->{$this->parameter}
		);
	}
}