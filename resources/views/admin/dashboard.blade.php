@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
    <link rel="stylesheet" href="{{asset('assets/plugins/chart.js/Chart.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Bonjour {{auth()->user()->name}}!</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item active">Tableau de Bord</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-primary border-primary">
                        <i class="fe fe-money"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{$all_contrats}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <a href= "/contrats">
                        <h6 class="text-muted">Contrat Maintenance</h6>
                    </a>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-primary w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-success">
                        <i class="fe fe-credit-card"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{$all_clients}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <a href= "/clients">
                        <h6 class="text-muted">Clients</h6>
                    </a>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-danger border-danger">
                        <i class="fe fe-folder"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{$all_equipements}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <a href= "/equipements">
                        <h6 class="text-muted">Equipements</h6>
                    </a>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-warning border-warning">
                        <i class="fe fe-users"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{\DB::table('users')->count()}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <a href= "/users">
                        <h6 class="text-muted">Personnel</h6>
                    </a>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Premier Pie Chart -->
                <div class="card card-chart">
                    <div class="card-header">
                        <h4 class="card-title text-center">Répartition des Interventions</h4>
                    </div>
                    <div class="card-body">
                        <div style="" onclick="window.location.href='/interventions';" style="cursor:pointer;">
                            {!! $pieChart_interventions->render() !!}
                        </div>
                    </div>
                </div>
                <!-- /Premier Pie Chart -->
            </div>
            <div class="col-md-6">
                <!-- Deuxième Pie Chart -->
                <div class="card card-chart">
                    <div class="card-header">
                        <h4 class="card-title text-center">Etat Contrats de Maintenance</h4>
                    </div>
                    <div class="card-body">
                        <div style="" onclick="window.location.href='/contrats';" style="cursor:pointer;">
                          {!! $pieChart_contrats->render() !!}
                        </div>
                    </div>
                </div>
                <!-- /Deuxième Pie Chart -->
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <!-- Tableau -->
        <div class="card card-table p-3">
            <div class="card-header">
                <h4 class="card-title ">En Instances - Interventions en Attente</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="intervention-table" class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Etat</th>
                                <th>Client</th>
                                <th>Equipement</th>
                                <th>Interveant(s)</th>
                                <th>Panne</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contenu du tableau -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Tableau -->
    </div>
</div>

@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#intervention-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{route('interventions.unclosed')}}",
            columns: [
                {data: 'etat', name: 'etat',

                render: function(data, type, full, meta) {
                    return '<a href="/interventions/' + full.id + '">' + data + '</a>';
                }
                } ,
                {data: 'client', name: 'client'},
                {data: 'equipement', name: 'equipement'},
                {data: 'destinateur', name: 'destinateur'},
                {data: 'description_panne', name: 'description_panne'},

            ]
        });

    });
</script>
<script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
@endpush
