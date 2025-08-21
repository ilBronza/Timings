<?php

use IlBronza\Timings\Http\Controllers\Bulk\TimingEstimationIndexController;
use IlBronza\Timings\Http\Controllers\CrudTimingsByModelController;
use IlBronza\Timings\Http\Controllers\CrudTimingsCalculatorController;
use IlBronza\Timings\Http\Controllers\Timings\CrudTimingsCalculatorMissingController;
use IlBronza\Timings\Http\Controllers\Timings\CrudTimingsCalculatorWrongController;
use IlBronza\Timings\Http\Controllers\Timings\TimingIndexController;

Route::group([
	'middleware' => ['web', 'auth', 'role:superadmin|administrator|timings'],
	'prefix' => 'timings-management',
	'as' => config('timings.routePrefix')
], function ()
{
	Route::get('timings-summary-by/class/{class}/key/{key}', [CrudTimingsByModelController::class, 'timingsBy'])->name('model.popup.byClassKey');

	Route::get('calculate-timings-by/class/{class}/key/{key}', [CrudTimingsCalculatorController::class, 'calculateTimingsBy'])->name('model.calculate.byClassKey');
	Route::get('calculate-root-timings-by/class/{class}/key/{key}', [CrudTimingsCalculatorController::class, 'calculateRootTimingsBy'])->name('model.calculateRoot.byClassKey');


	Route::group([
		'prefix' => 'timing-estimations',
		'as' => 'timingEstimations.'
	], function ()
	{
		Route::get('', [TimingEstimationIndexController::class, 'index'])->name('index');
	});

	Route::group([
		'prefix' => 'timings',
		'as' => 'timings.'
	], function ()
	{
		Route::get('re-calculate-wrong', [CrudTimingsCalculatorWrongController::class, 'execute'])->name('calculateWrong');
		Route::get('calculate-missing', [CrudTimingsCalculatorMissingController::class, 'execute'])->name('calculateMissing');
		Route::get('', [TimingIndexController::class, 'index'])->name('index');
	});
});