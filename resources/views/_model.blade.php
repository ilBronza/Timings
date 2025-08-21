<tr>
	<th>
		<span class="uk-h4">
		@for($i = 0; $i < $depth; $i ++) - @endfor

		{{ $model->getName() }}

		</span>
	</th>
	<td>
		{{ $model->getTimingEstimation()?->getQuantity() }}
	</td>
	<td>
		{{ $model->getTiming()?->getQuantity() }}
	</td>
	<td>
		{{ secondsToMinutes($model->getTimingEstimation()?->getSeconds()) }}
	</td>
	<td>
		{{ secondsToMinutes($model->getTiming()?->getSeconds()) }}
	</td>
	<td>
		{{ $model->getTiming()?->getDeltaQuantity() }}
	</td>
	<td>
		{{ $model->getTiming()?->getDeltaSeconds() }}
	</td>
	<td>
		{{ $model->getTiming()?->getDelta() }}
	</td>
</tr>

@php
	$depth ++;
@endphp

@foreach($model->getTimingChildren() as $child)
	@include('timings::_model', [
		'model' => $child,
		])
@endforeach
