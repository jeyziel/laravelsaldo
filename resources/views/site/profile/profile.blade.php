@extends('site.layouts.app')

@section('title', 'meu perfil')

@section('content')
    <h1>Meu perfil</h1>
    @include('includes.alerts')
    <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">

        {!! csrf_field() !!}
        
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text"  value="{{ auth()->user()->name }}" name="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" class="form-control" value="{{ auth()->user()->email }}"  >
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" name="password" class="form-control" >
        </div>

        <div class="form-group">

            @if (auth()->user()->image != null) 
                <img src="{{ url("storage/users/" . auth()->user()->image) }}" alt="{{ auth()->user()->name }}">
            @endif


            <label for="image">Imagem</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Atualizar perfil</button>
        </div>

    </form>
@endsection