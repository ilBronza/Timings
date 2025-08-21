<?php

namespace IlBronza\Timings\Http\Controllers\Timings;

use IlBronza\CRUD\Http\Controllers\Traits\StandardTraits\PackageStandardIndexTrait;
use IlBronza\Timings\Http\Controllers\TimingsCrudPackageController;

class TimingIndexController extends TimingsCrudPackageController
{
	use PackageStandardIndexTrait;

	public $avoidCreateButton = true;

	public $configModelClassName = 'timing';

	public $scopes = [];
}