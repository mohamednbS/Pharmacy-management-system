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
                    <h6 class="text-muted">Contrat Maintenance</a></h6>
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
                    <h6 class="text-muted">Clients</a></h6>
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
                    <h6 class="text-muted">Equipements</a></h6>
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
                    <h6 class="text-muted">Techniciens</a></h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="card card-table p-3">
            <div class="card-header">
                <h4 class="card-title ">Etats Interventions</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="intervention-table" class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Equipement</th>
                                <th>Interveant(s)</th>
                                <th>Panne</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-6">

        <!-- Pie Chart -->
        <div class="card card-chart">
            <div class="card-header">
                <h4 class="card-title text-center">Instances Interventions</h4>
            </div>
            <div class="card-body">
                <div style="">
                    {!! $pieChart->render() !!}
                </div>
            </div>
        </div>
        <!-- /Pie Chart -->

    </div>


</div>

@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#intervention-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('interventions.index')}}",
            columns: [
                {data: 'client', name: 'client',

                    render: function(data, type, full, meta) {
                        return '<a href="/interventions/' + full.id + '">' + data + '</a>';
                    }
                 } ,
                {data: 'equipement', name: 'equipement'},
                 {data: 'destinateur', name: 'destinateur'},
                {data: 'description_panne', name: 'description_panne'},

            ]
        });

    });
</script>
<script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
@endpush
