@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Utilisateurs</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Utilisateurs</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('users.create')}}" class="btn btn-primary float-right mt-2">Ajouter</a>
</div>

@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="user-table" class="datatable table table-striped table-bordered table-hover table-center mb-0">
						<thead>
							<tr style="boder:1px solid black;">
							    <th>Avatar</th>
								<th>Name</th>
								<th>Matricule</th>
								<th>Email</th>
								<th>Rôle</th>
								<th>Modalité</th>
								<th>Département</th>
								<th>Mobile</th>
								<th class="text-center action-btn">Actions</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('page-js')
<script>
$(document).ready(function() {
    var table = $('#user-table').DataTable({
        processing: true,
        serverSide: false,
        ajax: "{{route('users.index')}}",
        columns: [
			{data: 'avatar', name: 'avatar', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
			{data: 'matricule', name: 'matricule'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
			{data: 'modalite', name: 'modalite'},
			{data: 'departement', name: 'departement'},
			{data: 'phone', name: 'phone'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

});
</script>
@endpush
