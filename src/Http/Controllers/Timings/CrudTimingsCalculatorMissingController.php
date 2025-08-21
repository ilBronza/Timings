<?php

namespace IlBronza\Timings\Http\Controllers\Timings;

use IlBronza\Timings\BaseTimingHelper;
use IlBronza\Timings\Http\Controllers\CrudTimingsCalculatorController;
use Illuminate\Database\Eloquent\Relations\Relation;

use function dd;
use function ucfirst;

class CrudTimingsCalculatorMissingController extends CrudTimingsCalculatorController
{
	public $allowedMethods = [
		'execute',
	];

	public $limit = 10000;

	public function getLimit()
	{
		return $this->limit;
	}

	public function getElements()
	{
		$models = config('timings.cron.models');

		$collection = collect();
		
		foreach($models as $classname)
			$collection = $collection->merge(
					$classname::doesntHave('timing')->take($this->getLimit())->get()
				);

		return $collection;
	}

	public function execute()
	{
		$elements = $this->getElements();

		foreach($elements as $element)
			BaseTimingHelper::calculateAll($element);
	}
}