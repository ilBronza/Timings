<?php

namespace IlBronza\Timings\Helpers;

use IlBronza\Timings\Interfaces\HasTimingInterface;
use IlBronza\Timings\Models\Timing;
use IlBronza\Timings\Models\TimingBaseModel;

class TimingRemoverHelper
{
	static function _remove(TimingBaseModel $timingBaseModel): void
	{
		foreach($timingBaseModel->getChildren() as $childTiming)
			static::_remove($childTiming);

		$timingBaseModel->deleterForceDelete();
	}

	static function remove(HasTimingInterface $model) : void
	{
		if ($timing = $model->getTiming())
			static::_remove($timing);

		if ($timingEstimation = $model->getTimingEstimation())
			static::_remove($timingEstimation);
	}
}