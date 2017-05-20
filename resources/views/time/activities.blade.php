@extends('layouts.app')

@section('content')
<div class="container" id='app'>
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
	<div class="panel-heading text-center">
		<datepicker v-model="date"
				input-class="form-control"
				@selected="loadActivities"></datepicker>
	</div>
	<div class="panel-body">
		<activities ref="activities"></activities>
		{{-- @if(count($activities) > 0)
		<div class="list-group">
			@foreach($activities as $activity)
				<a href="#" class="list-group-item">{{ $activity->name }}</a>
			@endforeach
		</div>
		@endif --}}
	</div>
</div>
</div>
</div>
</div>
@endsection

@section('before-scripts')
<script>
	var api_token = '{!! $api_token !!}';
	var today_str = '{!! $today !!}';
	var today = new Date('{!! $today !!}');
</script>
@endsection