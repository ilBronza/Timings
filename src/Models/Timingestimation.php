<?php

namespace IlBronza\Timings\Models;

use IlBronza\Timings\Scopes\TimingEstimationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([TimingEstimationScope::class])]
class TimingEstimation extends TimingBaseModel
{
	static $modelConfigPrefix = 'timingEstimation';

	protected $attributes = [
		'type' => 'estimation',
	];
}