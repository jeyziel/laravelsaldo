@extends('adminlte::page')

@section('title', 'Histórico')

@section('content_header')
    <h1>Historico de movimentação</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Historico de movimentação</a></li>
    </ol>
@stop

@section('content')

    <div class="box">

        <div class="box-header">
            <form action="{{ route('historic.search')  }}" class="form form-inline" method="POST">
                {!! csrf_field() !!}
                <input type="text" name="id" class="form-control" placeholder="informe seu id">
                <input type="date" name="date" class="form-control">

                <select name="type" class="form-control">
                    <option value="">---Selecione o Tipo---</option>
                        @foreach($types as $key => $type)
                        <option value="{{ $key  }}">{{ $type  }}</option>
                        @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>

        </div>

        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>? Sender ?</th>
                    </tr>     
                </thead>
                <tbody>
                @forelse($historics as $historic)
                    <tr>
                        <th>{{ $historic->id  }}</th>
                        <th>{{ number_format($historic->amount, 2,',','.')  }}</th>
                        <th>{{ $historic->type  }}</th>
                        <th>{{ $historic->date  }}</th>
                        @if (isset($historic->userSender->name))
                            <th>{{ $historic->userSender->name  }}</th>
                        @endif

                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
            @if ( isset($dataForm)) 
                {!! $historics->appends($dataForm)->links() !!}
            @else
                {!! $historics->links() !!}
            @endif
        </div>
    </div>
@stop