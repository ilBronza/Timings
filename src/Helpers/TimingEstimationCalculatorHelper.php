<?php

namespace IlBronza\Timings\Helpers;

use App\Providers\Helpers\Timings\TimingEstimator;
use IlBronza\CRUD\Helpers\ModelHelpers\ModelFinderHelper;
use Illuminate\Support\Collection;
use IlBronza\Timings\Interfaces\HasTimingInterface;
use IlBronza\Timings\Models\TimingEstimation;

class TimingEstimationCalculatorHelper
{
	static int $limit = 200;

	static function calculateByClass(string $class)
	{
		$class = ModelFinderHelper::getFullQualifiedClassByClassName($class);

		$elements = $class::whereDoesntHave('timingEstimation')->orderByDesc('created_at')->take(static::$limit)->get();

		// $wrongElements = $class::whereHas('timingEstimation', function($query)
		// 	{
		// 		$query->wrong();
		// 	})->orderByDesc('created_at')->get();

		return static::calculateByCollection($elements);
	}

	static function calculateByCollection(Collection $elements)
	{
		foreach($elements as $element)
			static::calculateByModel($element);
	}

	static function calculateByModel(HasTimingInterface $model)
	{
		return TimingEstimator::calculate($model);
	}
}