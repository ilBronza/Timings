<?php

namespace IlBronza\Timings\Models;

use IlBronza\Timings\Scopes\TimingScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([TimingScope::class])]
class Timing extends TimingBaseModel
{
	static $modelConfigPrefix = 'timing';

	protected $attributes = [
		'type' => 'timing',
	];

}