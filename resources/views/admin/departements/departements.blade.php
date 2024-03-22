@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Départements</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Départements</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="#add_departements" data-toggle="modal" class="btn btn-primary float-right mt-2">Ajouter Département</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="departement-table" class="table table-bordered table-hover">
						<thead>
							<tr style="boder:1px solid black;">
								<th>Nom</th>

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

<!-- Add Modal -->
<div class="modal fade" id="add_departements" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Ajouter departement</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('departements.store')}}">
					@csrf
					<div class="row form-row">
						<div class="col-12">
							<div class="form-group">
								<label>departement</label>
								<input type="text" name="name" class="form-control">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-block">Ajouter</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /ADD Modal -->

<!-- Edit Details Modal -->
<div class="modal fade" id="edit_departement" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modifier departement</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('departements.update')}}">
					@csrf
					@method("PUT")
					<div class="row form-row">
						<div class="col-12">
							<input type="hidden" name="id" id="edit_id">
							<div class="form-group">
								<label>département</label>
								<input type="text" class="form-control edit_name" name="name">
							</div>
						</div>

					</div>
					<button type="submit" class="btn btn-primary btn-block">Modifier</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Edit Details Modal -->
@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#departement-table').DataTable({
            processing: false,
            serverSide: false,
            ajax: "{{route('departements.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        $('#departement-table').on('click','.editbtn',function (){
            $('#edit_departement').modal('show');
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#edit_id').val(id);
            $('.edit_name').val(name);
        });
        //
    });
</script>
@endpush
