<?php

namespace IlBronza\Timings\Helpers;

use Carbon\Carbon;

use function floor;
use function round;

class TimingIntervalHelper
{
	public $start;
	public $end;
	public $seconds;
	public $minutes;
	public $hours;

	public $absoluteSeconds;
	public $absoluteMinutes;
	public $absoluteHours;

	public $nodes = [];

	public function __construct(Carbon $start = null, Carbon $end = null)
	{
		$this->start = $this->setStart($start);
		$this->end = $this->setEnd($end);
	}

	public function calculateDuration()
	{
		if (! $this->getStart())
			return;

		if (! $this->getEnd())
			return;

		$this->seconds = $this->getEnd()->timestamp - $this->getStart()->timestamp;
		$this->minutes = round($this->seconds / 60, 2);
		$this->hours = round($this->seconds / 3600, 2);

		$this->absoluteSeconds = $this->seconds % 60;
		$this->absoluteMinutes = $this->minutes % 60;
		$this->absoluteHours = floor($this->hours);
	}

	public function addTimingIntervalNode(Carbon $date = null) : ?TimingIntervalNode
	{
		if (! $date)
			return null;

		$this->nodes[$date->timestamp] = new TimingIntervalNode($date);

		return $this->nodes[$date->timestamp];
	}

	public function setStart(Carbon $start = null)
	{
		$this->start = $start;

		$this->addTimingIntervalNode($start);

		$this->calculateDuration();
	}

	public function setEnd(Carbon $end = null)
	{
		$this->end = $end;

		$this->addTimingIntervalNode($end);

		$this->calculateDuration();
	}

	public function getEnd() : ?Carbon
	{
		return $this->end;
	}

	public function getStart() : ?Carbon
	{
		return $this->start;
	}

	public function containsStart(Carbon $start) : bool
	{
		if (! $this->start)
			true;

		if (($this->start <= $start) && ($this->end >= $start))
			return true;

		return false;
	}

	public function containsEnd(Carbon $end) : bool
	{
		if (! $this->end)
			true;

		if (($this->end >= $end) && ($this->start <= $end))
			return true;

		return false;
	}

	public function insertElementToInterval($element)
	{
		$start = $element->getStart();
		$end = $element->getEnd();

		if ($start < $this->getStart() || ($this->getStart() === null))
			$this->setStart($start);

		if ($end > $this->getEnd() || ($this->getEnd() === null))
			$this->setEnd($end);

		$this->incrementNodes($element);
	}

	public function incrementNodes($element)
	{
		foreach ($this->nodes as $node)
			if ($node->isBetween($element->getStart(), $element->getEnd()))
				$node->addNodeItem($element);
	}

	public function getSeconds()
	{
		return $this->seconds;
	}

	static function gpc()
	{
		return self::class;
	}
}