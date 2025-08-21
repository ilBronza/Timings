<?php

namespace IlBronza\Timings\Providers\DatatablesFields\TimingEstimator;

use IlBronza\Datatables\DatatablesFields\Dates\SecondsToMinutesTrait;
use IlBronza\Datatables\DatatablesFields\Links\DatatableFieldFetcher;

class DatatableFieldMinutes extends DatatableFieldFetcher
{
//	use SecondsToMinutesTrait;

	public $textParameter = 'estimated_seconds';

	public $fetcherData = [
		'urlMethod' => 'getAllTimingPopupUrl',
	];
}