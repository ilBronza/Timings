<?php

namespace IlBronza\Timings\Http\Parameters\TablesFields;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class TimingIndexFieldsGroupParameters extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
			'translationPrefix' => 'timings::fields',
			'fields' => [
				'created_at' => [
					'type' => 'dates.date',
					'filterRange' => true
				],
				'timeable' => [
					'type' => 'links.seeName',
					'width' => '10em'
				],
				'timeable_type' => [
					'type' => 'flat',
					'width' => '10em'
				],
				'seconds' => 'dates.secondsToMinutes',
				'quantity' => 'flat',

				'delta_quantity' => 'flat',
				'delta_seconds' => 'flat',
				'delta' => 'flat',

				'mySelfDelete' => 'links.delete'
			]
		];
	}
}