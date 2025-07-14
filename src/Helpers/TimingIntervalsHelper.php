<?php

namespace IlBronza\Timings\Helpers;

use Carbon\Carbon;
use IlBronza\Timings\Interfaces\TimeIntervalInterface;
use Illuminate\Support\Collection;

use function floor;
use function round;

class TimingIntervalsHelper
{
	public Collection $intervals;
	public $flattenedSeconds;
	public $seconds;

	public function __construct()
	{
		$this->intervals = collect();
	}

	static function getTimeIntervals(Collection $elements)
	{
		$timeIntervals = new static();

		$timeIntervals->setTimeIntervals($elements);

		$timeIntervals->calculateTotalTimes();

		return $timeIntervals;
	}

	public function setTimeIntervals(Collection $elements)
	{
		foreach ($elements as $element)
			$this->addElementToIntervals($element);

		return false;
	}

	public function findTimeIntervalToMergeByDates(Carbon $start, Carbon $end)
	{
		foreach ($this->intervals as $interval)
		{
			if ($interval->getStart() <= $start)
			{
				if ($interval->getEnd() >= $end)
					return $interval;

				if ($interval->getEnd() >= $start)
					return $interval;
			}
			else if ($interval->getStart() <= $end)
				return $interval;
		}

		return false;
	}

	public function addNewTimeInterval()
	{
		$timeInterval = new (TimingIntervalHelper::gpc());

		$this->intervals->push($timeInterval);

		return $timeInterval;
	}

	public function addFlattenedSeconds($element)
	{
		$this->flattenedSeconds += $element->getEnd()->timestamp - $element->getStart()->timestamp;
	}

	public function addElementToIntervals(TimeIntervalInterface $element)
	{
		if ($element->getStart() >= $element->getEnd())
			return;

		if (! $timeInterval = $this->findTimeIntervalToMergeByDates($element->getStart(), $element->getEnd()))
			$timeInterval = $this->addNewTimeInterval();

		$timeInterval->insertElementToInterval($element);

		$this->addFlattenedSeconds($element);
	}

	public function getSeconds()
	{
		return $this->seconds;
	}

	public function getFlattenedSeconds()
	{
		return $this->flattenedSeconds;
	}

	public function calculateTotalTimes()
	{
		foreach ($this->intervals as $interval)
			$this->seconds += $interval->getSeconds();
	}
}