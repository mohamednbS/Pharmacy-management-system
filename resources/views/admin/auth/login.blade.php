@extends('admin.layouts.plain')

@section('content')
<h1>GMAO STIET</h1>
<p class="account-subtitle">Bonjour !</p>
@if (session('login_error'))
<x-alerts.danger :error="session('login_error')" />
@endif
<!-- Form -->
<form action="{{route('login')}}" method="post">
	@csrf
	<div class="form-group">
		<input class="form-control" name="email" type="text" placeholder="Email">
	</div>
	<div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="Password">
	</div>
	<div class="form-group">
		<button class="btn btn-primary btn-block" type="submit">Connecter</button>
	</div>
</form>
<!-- /Form -->

<div class="text-center forgotpass"><a href="{{route('password.request')}}">Mot de passe oublié?</a></div>
<!--
<div class="text-center dont-have"><a href="{{route('register')}}">Créer un compte</a></div> -->
@endsection
