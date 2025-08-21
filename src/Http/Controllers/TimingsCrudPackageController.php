<?php

namespace IlBronza\Timings\Http\Controllers;

use IlBronza\CRUD\Http\Controllers\BasePackageController;
class TimingsCrudPackageController extends BasePackageController
{
	static $packageConfigPrefix = 'timings';

	public function getRouteBaseNamePrefix() : ? string
	{
		return config('timings.routePrefix');
	}

	public function setModelClass()
	{
		$this->modelClass = config("timings.models.{$this->configModelClassName}.class");
	}
}
