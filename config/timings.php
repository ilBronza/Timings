<?php

use IlBronza\Timings\Http\Parameters\TablesFields\TimingEstimationIndexFieldsGroupParameters;
use IlBronza\Timings\Http\Parameters\TablesFields\TimingIndexFieldsGroupParameters;
use IlBronza\Timings\Models\Timing;
use IlBronza\Timings\Models\TimingEstimation;

return [


	'datatableFieldWidths' => [
		'timingEstimator' => [
			'datatableFieldMinutes' => '4em'
		]
	],


	'routePrefix' => 'timings.',

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
			'class' => Timing::class,
			'fieldsGroupsFiles' => [
				'index' => TimingIndexFieldsGroupParameters::class
			]
		],
		'timingEstimation' => [
			'table' => 'timings__timings',
			'class' => TimingEstimation::class,
			'fieldsGroupsFiles' => [
				'index' => TimingEstimationIndexFieldsGroupParameters::class
			]
		],
	]
];