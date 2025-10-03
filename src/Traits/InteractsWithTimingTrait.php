<?php

namespace IlBronza\Timings\Traits;

use IlBronza\CRUD\Helpers\CrudRoutingHelper;
use IlBronza\Timings\Models\Timing;
use IlBronza\Timings\Models\TimingEstimation;

use function config;
use function dd;
use function route;

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

	public function timingEstimation()
	{
		return $this->morphOne(TimingEstimation::gpc(), 'timeable');
	}

	public function getTimingEstimation() : ?TimingEstimation
	{
		return $this->timingEstimation;
	}

	public function getEstimatedTimeSecondsAttribute($value) : ? float
	{
		return $this->getTimingEstimation()?->getSeconds();
	}

	public function getAllTimingPopupUrl()
	{
		return app('timings')->getRoutedModel($this, 'model.popup.byClassKey');
	}

	public function getCalculateTimingUrl()
	{
		return app('timings')->getRoutedModel($this, 'model.calculate.byClassKey');
	}

	public function getEstimatedSecondsAttribute()
	{
		return $this->getTimingEstimation()?->getSeconds();
	}

	public function scopeWithEstimationMachineSeconds($query)
	{
		$table = TimingEstimation::gpc()::make()->getTable();

		$query->addSelect([
			'live_timingEstimation_machine_total_seconds' => TimingEstimation::gpc()::select('seconds')->whereColumn($table . '.timeable_id', $this->getTable() . '.id')->where(
				$table . '.timeable_type', $this->getMorphClass()
			)->take(1)
		]);
	}

}