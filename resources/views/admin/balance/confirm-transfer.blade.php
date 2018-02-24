@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
<h1>Saldo</h1>

<ol class="breadcrumb">
	<li><a href="">Dashboard</a></li>
	<li><a href="">Saldo</a></li>
	<li><a href="">Confirmação</a></li>
</ol>
@stop

@section('content')

<div class="box">
	<div class="box-header">
		<h3>Confirmar Transferência</h3>
	</div>
	@include ('includes.alerts')
	<div class="box-body">

		<p><strong>Recebedor : </strong>{{ $sender->email  }}</p>

		<p><strong>Seu saldo atual : </strong>{{ number_format($balance->amount, '2', ',','.')  }}</p>

		<form method="POST" action="{{ route('transfer.store') }}">
			{!! csrf_field() !!}
			<input type="hidden" name="sender_id" value="{{ $sender->id }}">
			<div class="form-group">
				<input type="text" name="amount" placeholder="Quantidade à transferir" class="form-control">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Transferir</button>
			</div>
		</form>	
	</div>
</div>
@stop