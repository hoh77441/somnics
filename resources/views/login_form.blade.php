@extends('layouts.blank')

@section('title', 'iNap Manager')

@section('content')
    <div class="wrapper">
        {!! Form::open(['url'=>'/login', 'method'=>'post', 'class'=>'form-signin']) !!}
            <h2 class="form-signin-heading">Please login</h2>
            {!! Form::text('email', '', ['class'=>'form-control', 'placeholder'=>'Email Address or Patient ID', 'required'=>'', 'autofocus'=>'']) !!}
            {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password', 'required'=>'']) !!} 
            <label class="checkbox">
                {!! Form::checkbox('remember', 'remember-me') !!}{{ 'Remember me' }}
            </label>
            {!! Form::submit('Login', ['class'=>'btn btn-lg btn-primary btn-block']) !!}
            
            <p></p>
            
            @if( isset($error) )  {{-- display error message if necessary --}}
            {!! Form::label('error', 'Warning: '.'', ['class'=>'form-signin-warning']) !!} {{ $error }}
            @endif
            <h3 class="form-signin-version">Version: {{ env('SOMNICS_VER') }}</h3>
        {!! Form::close() !!}
    </div>
@endsection
