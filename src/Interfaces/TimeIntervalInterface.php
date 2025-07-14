<?php

namespace IlBronza\Timings\Interfaces;

use Carbon\Carbon;

interface TimeIntervalInterface
{
	public function getEnd() : ?Carbon;

	public function getStart() : ?Carbon;

}