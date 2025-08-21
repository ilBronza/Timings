<?php

namespace IlBronza\Timings\Http\Controllers\Bulk;

use IlBronza\CRUD\Http\Controllers\Traits\StandardTraits\PackageStandardIndexTrait;
use IlBronza\Timings\Http\Controllers\TimingsCrudPackageController;

class TimingEstimationIndexController extends TimingsCrudPackageController
{
	use PackageStandardIndexTrait;

	public $avoidCreateButton = true;

	public $configModelClassName = 'timingEstimation';

	public $scopes = [];
}