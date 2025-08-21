<tr>
	<th>
		<span class="uk-h4">
		@for($i = 0; $i < $depth; $i ++) - @endfor

		{{ $timing->getTimeable()->getName() }}

		</span>
	</th>
	<td>
		{{ $timing->getQuantity() }}
	</td>
	<td>
		{{ secondsToMinutes($timing->getSeconds()) }}
	</td>
</tr>

@php
	$depth ++;
@endphp

@foreach($timing->getChildren() as $child)
	@include('timings::_timingsBy', [
		'timing' => $child,
		])
@endforeach
