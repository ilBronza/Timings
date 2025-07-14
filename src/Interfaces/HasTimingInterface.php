<?php

namespace IlBronza\Timings\Interfaces;

use Illuminate\Support\Collection;

interface HasTimingInterface
{
	public function getTimingChildren() : Collection;

	public function getQuantityRequired() : ?float;
}