@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Contrats de Maintenances</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">contrats</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('contrats.create')}}" class="btn btn-primary float-right mt-2">Ajouter</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="contrat-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Client</th>
                                <th>Equipement</th>
								<th>date début</th>
								<th>date fin</th>
								<th>Type contrat</th>
								<th>Etat</th>
								<th>Notes</th>
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>
                            <!-- Add a spinner/loader-->
                            <div id="spinner" class="spinner-border text-primary" role="status"
                                style="display: none;
                                position: absolute;
                                inset-block-start: 50%;
                                inset-inline-start: 50%;">
                                <span class="sr-only">en cours...</span>
                            </div>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Recent Orders -->

	</div>
</div>
@endsection

@push('page-js')
<script>
    // Show spinner when DataTable is processing
    $('#contrat-table').on('processing.dt', function(e, settings, processing) {
      if (processing) {
        $('#spinner').show();
        } else {
        $('#spinner').hide();
        }
    });

    $(document).ready(function() {
        var table = $('#contrat-table').DataTable({
            processing: false,
            serverSide: false,
            ajax: "{{route('contrats.index')}}",
            columns: [
                {data: 'client', name: 'client'},
                {data: 'equipement', name: 'equipement'},
                {
                    data: 'date_debut',
                    name: 'date_debut',

                    render: function(data, type, row)
                    { if (data)

                    { const date = new Date(data);

                    return date.toLocaleString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
                    }

                    return '';

                    }
                },
                {   data: 'date_fin',
                    name: 'date_fin',

                    render: function(data, type, row)
                    { if (data)

                        { const date = new Date(data);

                        return date.toLocaleString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
                        }

                    return '';

                    }
                },
                {data: 'type_contrat', name: 'type_contrat'},
                {data: 'status', name: 'status'},
				{data: 'note', name: 'note'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });
</script>
@endpush
