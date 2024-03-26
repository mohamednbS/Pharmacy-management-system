@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Interventions</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Interventions Non Clôturées</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('interventions.create')}}" class="btn btn-primary float-right mt-2">Ajouter</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="intervention-unclosed-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
							    <th>Etat</th>
								<th>Client</th>
								<th>Equipement</th>
								<th>Panne Initial</th>
								<th>Intervenant(s)</th>
                                <th>Sous-traitant</th>
                                <th>Sous equipement</th>
								<th>Description Panne</th>
                                <th>Heure/Date d'appel client</th>
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
    $('#intervention-unclosed-table').on('processing.dt', function(e, settings, processing) {
    if (processing) {
        $('#spinner').show();
    } else {
    $('#spinner').hide();
    }
    });

    $(document).ready(function() {
        var table = $('#intervention-unclosed-table').DataTable({
            processing: false,
            serverSide: false,
            ajax: "{{route('interventions.unclosed')}}",
            columns: [
				{data: 'etat', name: 'etat'},
                {data: 'client', name: 'client'},
                {data: 'equipement', name: 'equipement'},
                {data: 'type_panne', name: 'type_panne'},
                {data: 'destinateur', name: 'destinateur'},
                {data: 'soustraitant', name: 'soustraitant'},
                {data: 'sousequipement', name: 'sousequipement'},
				{data: 'description_panne', name: 'description_panne'},
                {	data: 'appel_client',
                    name: 'appel_client',
                    render: function(data, type, row) {
                        if (data) {
                            // Parse the date string using moment.js and format it as 'd-m-y hh:mm'
                            var date = moment(data, 'YYYY-MM-DD HH:mm:ss');
                            return date.format('DD-MM-YYYY hh:mm');
                        }
                        return '';
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        // Load the moment.js library
          $.getScript('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js', function() {
            // Initialize the moment.js library with the desired locale (e.g., French)
            moment.locale('fr');
        });

    });
</script>
@endpush
