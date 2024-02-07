@extends('admin.layouts.app')

<x-assets.datatables />


@push('page-css')
    
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Rapport Equipements</h3>  
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Générer rapport equipements</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="#generate_report" data-toggle="modal" class="btn btn-primary float-right mt-2">Générer Rapport</a>
</div>
@endpush

@section('content')
    @isset($equipements)
    <div class="row">
        <div class="col-md-12">
            <!-- equipements reports-->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="equipement-table" class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Designation</th>
                                    <th>Modèle</th>
                                    <th>Numéro Série</th>
                                    <th>Client</th>
                                    <th>Date Installation</th>
                                    <th>Software</th>                              
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; ?>
                            @foreach ($equipements as $equipement)
                                @if(!empty($equipement->client))
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{$equipement->designation}}</td>
                                    <td>{{$equipement->modele}}</td>
                                    <td>{{$equipement->numserie}}</td>
                                    <td>{{$equipement->client->name}}</td>
                                    <td>{{$equipement->date_installation}}</td>
                                    <td>{{$equipement->software}}</td>
                  
                                </tr>
                                @endif
                            @endforeach                         
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /equipements Report -->
        </div>
    </div>
    @endisset


    <!-- Generate Modal -->
    <div class="modal fade" id="generate_report" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Générer Rapport</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('equipements.report.search') }}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Rechercher</label>
                                    <input type="text" name="search_keyword" class="form-control" placeholder="Entrez la désignation">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Valider</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /Generate Modal -->
@endsection


@push('page-js')
<script>
    $(document).ready(function(){
        $('#equipement-table').DataTable({
            dom: 'Bfrtip',		
            buttons: [
                {
                extend: 'collection',
                text: 'Export Data',
                buttons: [
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: "thead th:not(.action-btn)"
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: "thead th:not(.action-btn)"
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: "thead th:not(.action-btn)"
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: "thead th:not(.action-btn)"
                        }
                    }
                ]
                }
            ]
        });
    });
</script>
@endpush