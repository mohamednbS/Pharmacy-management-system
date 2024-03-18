@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Equipements</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Equipements</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('equipements.create')}}" class="btn btn-primary float-right mt-2">Ajouter</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive" >
					<table id="equipement-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Code</th>
								<th>Designation</th>
								<th>Modèle</th>
								<th>Numéro Série</th>
								<th>Client</th>
								<th>Date Installation</th>
                                <th>Software</th>

								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>

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
    $(document).ready(function() {
        var table = $('#equipement-table').DataTable({
            processing: false,
            serverside: false,
            ajax: "{{route('equipements.index')}}",
            columns: [
                {data: 'code', name: 'code'},
                {data: 'designation', name: 'designation'},
                {data: 'modele', name: 'modele'},
                {data: 'numserie', name: 'numserie'},
                {data: 'client', name: 'client'},
                {data: 'date_installation', name: 'date_installation'},
                {data: 'software', name: 'software'},

                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]

        });

    });
</script>
@endpush
