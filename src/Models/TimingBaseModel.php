<?php

namespace IlBronza\Timings\Models;

class TimingBaseModel extends TimingBasePackageModel
{
	protected $casts = [
		'parameters' => 'array'
	];

	public function setQuantityRequired(int $quantityRequired, bool $save = false) : self
	{
		$this->quantity_required = $quantityRequired;

		return $this->checkSaveAndRetur($save);
	}

	public function setParameters(array $parameters, bool $save = false) : self
	{
		$this->parameters = $parameters;

		return $this->checkSaveAndRetur($save);
	}

	public function setHours(float $hours, bool $save = false) : self
	{
		$this->seconds = round(
			$hours * 3600,
			2
		);

		return $this->checkSaveAndRetur($save);
	}

	public function getSeconds() : float
	{
		return $this->seconds;
	}

	public function checkSaveAndRetur(bool $save = true) : self
	{
		if($save)
			$this->save();

		return $this;
	}

}