@extends('app')

@section('content')


<div class="uk-card uk-card-default uk-card-small">
	<div class="uk-card-header">
		<h3 class="uk-card-title">Tempistiche per {{ $model->getName() }}</h3>
	</div>

	<div class="uk-card-body">

		<div class="uk-card uk-card-default uk-card-small">
			<div class="uk-card-header">
				<h3 class="uk-card-title">Totale</h3>
			</div>

			<div class="uk-card-body">

				<table class="uk-table">
					<tr>
						<th>
							Elemento
						</th>
						<th class="uk-text-center" colspan="2">
							Quantità
						</th>
						<th class="uk-text-center" colspan="2">
							Tempo
						</th>
					</tr>

					<tr>
						<th>
						</th>
						<th>
							Richiesta
						</th>
						<th>
							Prodotta
						</th>
						<th>
							Stimato
						</th>
						<th>
							Rilevato
						</th>
						<th>
							Delta Quantità
						</th>
						<th>
							Delta Tempo
						</th>
						<th>
							Delta assoluto
						</th>
					</tr>

					@include('timings::_model', ['depth' => 0])

				</table>

			</div>

		</div>

	</div>

</div>

@endsection