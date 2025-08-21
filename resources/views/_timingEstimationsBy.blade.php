<tr>
	<th>
		<span class="uk-h4">
		@for($i = 0; $i < $depth; $i ++) - @endfor

		{{ $timingEstimation->getTimeable()->getName() }}

		</span>
	</th>
	<td>
		{{ $timingEstimation->getQuantity() }}
	</td>
	<td>
		{{ secondsToMinutes($timingEstimation->getSeconds()) }}
	</td>
</tr>

@php
	$depth ++;
@endphp

@foreach($timingEstimation->getChildren() as $child)
	@include('timings::_timingEstimationsBy', [
		'timingEstimation' => $child,
		])
@endforeach
