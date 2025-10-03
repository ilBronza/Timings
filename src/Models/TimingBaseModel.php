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

	public function isClosed() : bool
	{
		return ! $this->getError();
	}

	public function getError() : ? string
	{
		return $this->error;
	}

    public function getCalculatedAt() : ? string
    {
        if($this->updated_at)
            return $this->updated_at->diffForHumans(null, null, true);

        return null;
    }

    static public function getFormattedSeconds(int $seconds = null, bool $showSeconds = true)
    {
        if(! $seconds)
            return '-';

        $pieces = [];

        if($hours = floor($seconds / 3600))
            $pieces[] = $hours . 'h';

        $residualSeconds = $seconds % 3600;

        $minutes = floor($residualSeconds / 60);

        if($hours || $minutes)
            $pieces[] = $minutes . '\'';

        if($showSeconds)
            $pieces[] = $residualSeconds % 60 . '"';            

        return implode(' ', $pieces);
    }

	public function getMachineInitializationString(bool $showSeconds = true)
	{
		return $this->getFormattedSeconds(
			$this->getMachineInitialization(),
			$showSeconds
		);
	}

    public function getHumanInitializationString(bool $showSeconds = true)
    {
        return $this->getFormattedSeconds(
            $this->getHumanInitialization(),
			$showSeconds
        );
    }

    public function getMachineProductionString(bool $showSeconds = true)
    {
        return $this->getFormattedSeconds(
            $this->getMachineProduction(),
            $showSeconds
        );
    }

    public function getHumanProductionString(bool $showSeconds = true)
    {
        return $this->getFormattedSeconds(
            $this->getHumanProduction(),
            $showSeconds
        );
    }

    public function getMachinePerProductString(bool $showSeconds = true)
    {
        return $this->getFormattedSeconds(
            ceil($this->getMachinePerProduct()),
            $showSeconds
        );        
    }

    public function getHumanPerProductString(bool $showSeconds = true)
    {
        $value = $this->getHumanPerProduct();

        if($value > 0)
            $value = ceil($value);

        return $this->getFormattedSeconds(
        	$value,
            $showSeconds
        );
    }

    public function getMachinePerProduct()
    {
		return null;
    }

    public function getHumanPerProduct()
    {
		return null;
    }

	public function getMachineTotalSeconds()
	{
		if(isset($this->parameters['machine_total_seconds']))
			return $this->parameters['machine_total_seconds'];

		return null;
	}


	public function getHumanProduction()
	{
		if(isset($this->parameters['human_production_seconds']))
			return $this->parameters['human_production_seconds'];

		return null;
	}

    public function getMachineProduction()
    {
		if(isset($this->parameters['machine_production_seconds']))
			return $this->parameters['machine_production_seconds'];

		return null;    	
    }

	public function getMachineInitialization()
	{
		if(isset($this->parameters['machine_initialization_seconds']))
			return $this->parameters['machine_initialization_seconds'];

		return null;
	}

	public function getHumanInitialization()
	{
		if(isset($this->parameters['human_initialization_seconds']))
			return $this->parameters['human_initialization_seconds'];

		return null;
	}

	public function getHumanTotal()
	{
		if(isset($this->parameters['human_total_seconds']))
			return $this->parameters['human_total_seconds'];

		return null;
	}



    public function getMachineTotalString(bool $showSeconds = true)
    {
        return $this->getFormattedSeconds(
            $this->getMachineTotalSeconds(),
            $showSeconds
        );
    }

	public function getHumanTotalString(bool $showSeconds = true)
	{
		return $this->getFormattedSeconds(
			$this->getHumanTotal(),
			$showSeconds
		);
	}

}