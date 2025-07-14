<?php

namespace IlBronza\Timings\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TimingBaseScope implements Scope
{
	protected string $type;

	public function apply(Builder $builder, Model $model)
	{
		$builder->where($model->getTable() . '.type', $this->type);
	}
}