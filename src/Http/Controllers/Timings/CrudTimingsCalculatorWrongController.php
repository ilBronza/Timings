<?php

namespace IlBronza\Timings\Http\Controllers\Timings;

use IlBronza\Timings\Models\Timing;
use IlBronza\Timings\Http\Controllers\CrudTimingsCalculatorController;

class CrudTimingsCalculatorWrongController extends CrudTimingsCalculatorMissingController
{
	public function getElements()
	{
		$wrong = Timing::gpc()::wrong()->with('timeable')->take($this->getLimit())->get();

		return $wrong->pluck('timeable');
	}
}