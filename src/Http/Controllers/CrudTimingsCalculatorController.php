<?php

namespace IlBronza\Timings\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Helpers\ModelHelpers\ModelFinderHelper;
use IlBronza\Timings\BaseTimingHelper;
use IlBronza\Timings\TimingCalculator;
use IlBronza\Timings\TimingEstimator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use function back;

class CrudTimingsCalculatorController extends CRUD
{
	public $allowedMethods = [
		'calculateTimingsBy',
		'calculateRootTimingsBy'
	];

	public function calculateModelTimingsAndReturnBack($model)
	{
		$this->calculateModelTimings($model);

		return back();
	}

	public function calculateModelTimings($model)
	{
		TimingEstimator::calculate($model);
		TimingCalculator::calculate($model);
	}

	public function calculateTimingsBy(Request $request, string $class, string $key)
	{
		$model = ModelFinderHelper::getByClassKey($class, $key);

		return $this->calculateModelTimingsAndReturnBack($model);
	}

	public function calculateRootTimingsBy(Request $request, string $class, string $key)
	{
		$model = ModelFinderHelper::getByClassKey($class, $key);

		while($result = $model->getTimingFather())
			$model = $result;

		return $this->calculateModelTimingsAndReturnBack($model);
	}
}

