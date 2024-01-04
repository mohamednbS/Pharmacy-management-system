@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
    
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Client</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">client</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('clients.create')}}" class="btn btn-primary float-right mt-2">Ajouter Client</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
	
		<!-- clients -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="client-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Nom Client/Raison Sociale</th>
								<th>Email</th>
								<th>Mobile</th>
								<th>Fax</th>
								<th>Adresse</th>
							
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>
							{{-- @foreach ($clients as $client)
							<tr>
								<td>										
									{{$client->product}}
								</td>
								<td>{{$client->name}}</td>
								<td>{{$client->phone}}</td>
								<td>{{$client->email}}</td>
								<td>{{$client->address}}</td>
								<td>{{$client->company}}</td>
								<td>
									<div class="actions">
										<a class="btn btn-sm bg-success-light" href="{{route('edit-client',$client)}}">
											<i class="fe fe-pencil"></i> Edit
										</a>
										<a data-id="{{$client->id}}" href="javascript:void(0);" class="btn btn-sm bg-danger-light deletebtn" data-toggle="modal">
											<i class="fe fe-trash"></i> Delete
										</a>
									</div>
								</td>
							</tr>
							@endforeach							 --}}
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /clients-->
		
	</div>
</div>

@endsection	

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#client-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('clients.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'fax', name: 'fax'},
                {data: 'address', name: 'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
</script> 
@endpush