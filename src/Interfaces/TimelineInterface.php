<?php

namespace IlBronza\Timings\Interfaces;

interface TimelineInterface
{
	public function getTimelineHtmlClassesString() : ? string;

	public function getCompletionPercentage() : float;
}