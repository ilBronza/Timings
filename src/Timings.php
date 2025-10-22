<?php

namespace IlBronza\Timings;

use IlBronza\CRUD\Providers\RouterProvider\RoutedObjectInterface;
use IlBronza\CRUD\Traits\IlBronzaPackages\IlBronzaPackagesTrait;

class Timings implements RoutedObjectInterface
{
	use IlBronzaPackagesTrait;

	static $packageConfigPrefix = 'timings';

	public function manageMenuButtons()
	{
		if (! $menu = app('menu'))
			return;

		$button = $menu->provideButton([
			'text' => 'menu::menu.settings',
			'name' => 'settings',
			'icon' => 'gear',
			'roles' => ['administrator']
		]);

		$timingsManagerButton = $menu->createButton([
			'name' => 'timingsManager',
			'icon' => 'clock',
			'text' => 'timings::timings.manage',
			'children' => [
				[
					'icon' => 'list',
					'href' => $this->route('timings.index'),
					'text' => 'timings::timings.index'
				],
				[
					'icon' => 'list',
					'href' => $this->route('timingEstimations.index'),
					'text' => 'timings::timingEstimations.index'
				],
				[
					'icon' => 'list',
					'href' => $this->route('timingEstimations.calculate.byClass', ['class' => 'OrderProduct']),
					'text' => 'timings::timingEstimations.calculateOrders'
				],
				[
					'icon' => 'list',
					'href' => $this->route('timings.calculate.byClass', ['class' => 'OrderProduct']),
					'text' => 'timings::timings.calculateOrders'
				],


			]
		]);

		$button->addChild($timingsManagerButton);
	}
}