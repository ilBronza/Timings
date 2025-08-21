<?php

namespace IlBronza\Timings\Models;

use Illuminate\Support\Str;
use IlBronza\CRUD\Traits\Model\CRUDParentingTrait;
use IlBronza\Timings\Interfaces\HasTimingInterface;

use function round;

class TimingBaseModel extends TimingBasePackageModel
{
	use CRUDParentingTrait;

	static $deletingRelationships = [];

	protected $casts = [
		'parameters' => 'array'
	];

	public function setQuantity(int $quantity = null, bool $save = false) : self
	{
		$this->quantity = $quantity;

		return $this->checkSaveAndReturn($save);
	}

	public function getDeltaQuantity() : float
	{
		return $this->delta_quantity;
	}

	public function getDeltaSeconds() : float
	{
		return $this->delta_seconds;
	}

	public function getDelta() : float
	{
		return $this->delta;
	}

	public function setDeltaQuantity(float $deltaQuantity = null, bool $save = false) : self
	{
		$this->delta_quantity = round($deltaQuantity, 2);

		return $this->checkSaveAndReturn($save);
	}

	public function setDeltaSeconds(float $deltaSeconds = null, bool $save = false) : self
	{
		$this->delta_seconds = round($deltaSeconds, 2);

		return $this->checkSaveAndReturn($save);
	}

	public function setDelta(float $delta = null, bool $save = false) : self
	{
		$this->delta = round($delta, 2);

		return $this->checkSaveAndReturn($save);
	}

	public function getQuantity() : ? int
	{
		return $this->quantity;
	}

	public function setParameters(array $parameters, bool $save = false) : self
	{
		$this->parameters = $parameters;

		return $this->checkSaveAndReturn($save);
	}

	public function setHours(float $hours, bool $save = false) : self
	{
		$this->seconds = round(
			$hours * 3600,
			2
		);

		return $this->checkSaveAndReturn($save);
	}

	public function getSeconds() : ? float
	{
		return $this->seconds;
	}

	public function checkSaveAndReturn(bool $save = true) : self
	{
		if($save)
			$this->save();

		return $this;
	}

	public function setError(string $error, bool $save = true) : self
	{
		$this->error = Str::limit($error, 191);

		return $this->checkSaveAndReturn($save);
	}

	public function timeable()
	{
		return $this->morphTo('timeable');
	}

	public function getTimeable() : ? HasTimingInterface
	{
		return $this->timeable;
	}

	public function scopeWrong($query)
	{
		return $query->whereNotNull('error');
	}
}