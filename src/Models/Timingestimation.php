<?php

namespace IlBronza\Timings\Models;

use IlBronza\Timings\Scopes\TimingEstimationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([TimingEstimationScope::class])]
class Timingestimation extends TimingBaseModel
{
	static $modelConfigPrefix = 'timingestimation';

	protected $attributes = [
		'type' => 'estimation',
	];
}