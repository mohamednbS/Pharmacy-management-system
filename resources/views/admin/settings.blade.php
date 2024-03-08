@extends('admin.layouts.app')
@php
    $title ='settings';
@endphp

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Paramètres Générales</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item"><a href="javascript:(0)">Paramètres</a></li>
		<li class="breadcrumb-item active">Paramètres Générales</li>
	</ul>
</div>
@endpush

@section('content')

<div class="row">
	<div class="col-12">
		@include('app_settings::_settings')
	</div>
</div>
@endsection

