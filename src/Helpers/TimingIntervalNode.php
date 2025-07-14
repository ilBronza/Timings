<?php

namespace IlBronza\Timings\Helpers;

use Carbon\Carbon;

class TimingIntervalNode
{
	public $items = [];
	public $date;

	public function __construct(Carbon $date = null)
	{
		$this->date = $date;
	}

	public function isBetween(Carbon $start, Carbon $end)
	{
		if ($this->date > $end)
			return false;

		if ($this->date < $start)
			return false;

		return true;
	}

	public function addNodeItem($element)
	{
		$this->items[] = $element->getNodeItemData();
	}
}