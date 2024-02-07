
@extends('admin.layouts.app')

<x-assets.datatables />  

@push('page-css')
	
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Calendrier de Maintenance</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Calendrier</li>
	</ul>
</div>


@endpush

@section('content')
@livewireStyles

    <livewire:calendar />
    @livewireScripts
    @stack('scripts')

@endsection
