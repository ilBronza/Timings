<?php

namespace IlBronza\Timings\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TimingEstimationScope extends TimingBaseScope
{
	protected string $type = 'estimation';
}