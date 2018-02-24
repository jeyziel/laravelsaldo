@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
<h1>Saldo</h1>

<ol class="breadcrumb">
	<li><a href="">Dashboard</a></li>
	<li><a href="">Saldo</a></li>
	<li><a href="">Sacar</a></li>
</ol>
@stop

@section('content')

<div class="box">
	<div class="box-header">
		<h3>Fazer Saque</h3>
	</div>
	@include ('includes.alerts')
	<div class="box-body">	
		<form method="POST" action="{{ route('withdraw.store') }}">
			{!! csrf_field() !!}
			<div class="form-group">
				<input type="text" name="amount" placeholder="Valor do saque" class="form-control">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Sacar</button>
			</div>
		</form>	
	</div>
</div>
@stop