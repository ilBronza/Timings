<?php

use IlBronza\Timings\Models\Timing;
use IlBronza\Timings\Models\Timingestimation;

return [
    'success' => [
        'timeout_ms' => 2500
    ],
    'danger' => [
        'timeout_ms' => 25000
    ],
    'warning' => [
        'timeout_ms' => 7500
    ],


	'models' => [
		'timing' => [
			'table' => 'timings__timings',
			'class' => Timing::class
		],
		'timingestimation' => [
			'table' => 'timings__timings',
			'class' => Timingestimation::class
		],
	]
];