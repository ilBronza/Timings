<?php

namespace IlBronza\Timings\Http\Controllers;

use IlBronza\CRUD\CRUD;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class CrudTimingsByModelController extends CRUD
{
	public $allowedMethods = [
		'timingsBy',
	];

	public function timingsBy(Request $request, string $class, string $key)
	{
		if(! $morphedClass = Relation::getMorphedModel($class))
			$morphedClass = $class;

		$model = $morphedClass::find($key);

		$timing = $model->getTiming()->getTree(['timeable']);
		$timingEstimation = $model->getTimingEstimation()->getTree(['timeable']);

		return view('timings::_allTimingsBy', compact('timing', 'timingEstimation', 'model'));
	}
}

