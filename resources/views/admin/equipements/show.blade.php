@extends('admin.layouts.app')

@push('page-header')
<div class="col">
	<h3 class="page-title">Gestion Equipement</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Equipement</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="profile-header">
			<div class="row align-items-center">
				<div class="col-auto profile-image">
					<a href="#">
						<img class="rounded-circle" alt="User Image" src="{{!empty(auth()->user()->avatar) ? asset('storage/users/'.auth()->user()->avatar): asset('assets/img/avatar.png')}}">
					</a>
				</div>
				<div class="col ml-md-n2 profile-user-info">
					<h1 class="user-name mb-0">{{$equipement->designation}}</h1>
					<h5 class="text-muted">{{$equipement->code}}</h5>
				</div>

			</div>
		</div>
		<div class="profile-menu">
			<ul class="nav nav-tabs nav-tabs-solid">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#per_details_tab">Aperçu</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#password_tab">Historique</a>
				</li>
				<li class="nav-item">
				    <a href="/equipements/{{ $equipement->id}}/sousequipements/create" class="btn btn-primary float-right mt-2">Ajouter Sous-equipement</a>
				</li>

			</ul>
		</div>

		<div class="tab-content profile-tab-cont">

			<!-- Aperçu equipement Tab -->
			<div class="tab-pane fade show active" id="per_details_tab">

				<!-- Aperçu equipement -->
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title d-flex justify-content-between">
									<span>Aperçu</span>
									<a class="edit-link" data-toggle="modal" href="#edit_equipement_details"><i class="fa fa-edit mr-1"></i>Modifier</a>
								</h5>


								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Client</p>
									<p class="col-sm-10">	{{$equipement->client->name}}</p>
								</div>

								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Modèle</p>
									<p class="col-sm-10">{{$equipement->modele}}</p>
								</div>

								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Numéro de Série</p>
									<p class="col-sm-10">{{$equipement->numserie}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Date Installation</p>
									<p class="col-sm-10">	{{$equipement->date_insatallation}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Type Contrat</p>
									<p class="col-sm-10">	{{$equipement->type_contrat}}</p>
								</div>

							</div>
                        <!-- Edit Details Modal -->
						<div class="modal fade" id="edit_equipement_details" aria-hidden="true" role="dialog">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Détails Equipement</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" enctype="multipart/form-data" action="{{route('equipements.update',$equipement)}}">
											@csrf
											@method("PUT")
											<div class="row form-row">
												<div class="col-12">
                                                    <div class="form-group">
                                                        <label>Client <span class="text-danger">*</span></label>
                                                        <select class="select2 form-select form-control" name="client_id">
                                                            @foreach ($clients as $client)
                                                                @if ($client->id == $equipement->client_id )

                                                                    <option selected value="{{$client->id}}">{{$client->name}}</option>
                                                                @else
                                                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
												</div>
												<div class="col-12">
                                                        <div class="form-group">
                                                            <label>Modèle<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" name="modele" value="{{$equipement->modele}}">
                                                        </div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Numéro Série</label>
														<input class="form-control select edit_role" name="numserie" value="{{$equipement->numserie}}">
													</div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Date insatallation</label>
														<input type="date" value="{{$equipement->date_installation}}" class="form-control" name="date_installation">
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
						</div>
                    </div>
                    <!-- /Personal Details -->

                </div>
                <!-- /Personal Details Tab -->


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Change Password</h5>
                            <div class="row">
                                <div class="col-md-10 col-lg-12">
                                    <form method="POST" action="{{route('update-password',auth()->user())}}">
                                        @csrf
                                        @method("PUT")
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <input type="password" name="current_password" class="form-control" placeholder="enter your current password">
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="enter your new password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="repeat your new password">
                                        </div>
                                        <button class="btn btn-primary" type="submit">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Change Password Tab -->

            </div>
        </div>
    </div>
    @endsection
