@if ($errors->any())
	<div class="alert alert-warning">
		@foreach ($errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	</div>
@endif


@if (Session('success'))
	<div class="alert alert-success">
		{{ Session('success') }}
	</div>
@endif

@if (Session('error'))
	<div class="alert alert-danger">
		{{ Session('error') }}
	</div>
@endif


