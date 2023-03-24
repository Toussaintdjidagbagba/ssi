@extends('layouts.templaterefonteadmin')
@section('css')

<link href="cssdste/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

@endsection

@section('content')
<section class="content">
<div class="container-fluid">
	<div class="block-header">
		@include('flash::message')
		<h2>
			Tableau de bord
			<small></small>
		</h2>
	</div>
	<div class="row clearfix">
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Modifier un utilisateur de {{config('app.name')}} 
					</h2>
				</div>
				<div class="body">
					<div class="row">
						
						<form style="padding : 20px" method="post" action="{{ route('MTUS') }}" >
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							
							<div class="row clearfix">
								<div class="col-sm-6">
									<label for="identifiant">Identifiant</label>
									<input type="hidden" name="id" value="{{ $info->idUser }}" />
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="identifiant" name="login" class="form-control" value="{{ $info->login }}"required>
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<label for="nom">Nom </label>
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="nom" class="form-control" value="{{ $info->nom }}" name="nom" >
										</div>
									</div>			
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-md-6">
									<label for="prenom">Prénom</label>
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="prenom" name="prenom" class="form-control" value="{{ $info->prenom }}">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<label for="sexe">Sexe</label>
									<div class="form-group">
										<div class="form-line">
											<select type="text" id="sexe" name="sexe" class="form-control show-tick" placeholder="">
												<option value="{{ $info->sexe }}">{{ App\Providers\InterfaceServiceProvider::sexe($info->sexe) }}</option>
												@if( $info->sexe == 'M')
												<option value="F">Féminin</option>
												@else
												<option value="M">Masculin</option>
												@endif
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-md-6">
									<label for="tel">Téléphone</label>
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="tel" name="tel" class="form-control" value="{{ $info->tel }}">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<label for="adr">Adresse</label>
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="adr" name="adress" class="form-control" value="{{ $info->adresse }}">
										</div>
									</div>
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-md-6">
									<label for="email">Email</label>
									<div class="form-group">
										<div class="form-line">
											<input type="email" id="email" name="mail" class="form-control" value="{{ $info->mail }}">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<label for="autr">Autres</label>
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="autr" name="autres" class="form-control" value="{{ $info->other }}">
										</div>
									</div>
								</div>
							</div>

							<div class="row clearfix">
								<div class="col-md-12">
									<label for="role">Rôle</label>
									<div class="form-group">
										<div class="form-line">
											<select type="text" id="role" name="role" class="form-control show-tick" placeholder="">
												<option value="{{ $info->Role }}">{{App\Providers\InterfaceServiceProvider::LibelleRole($info->Role)}}</option>
												@foreach($allRole as $role)
												@if($role->idRole != $info->Role)
												<option value="{{ $role->idRole }}">{{ $role->libelle }}</option>
												@endif
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>

							

							<div class="form-group" style="display: block;" >
								<div class="col-sm-12">
									<button type="submit" class="btn bg-deep-orange waves-effect" style="float:right; margin-top: 20px; margin-left: 15px; width: 25%;">Mettre à jour
									</button>
								</div>
							</div>
						</form>	
					</div>

				</div>
			</div>
		</div>
		
	</div>
</div>
</section>
@endsection

@section("js")
<script>
	$('#flash-overlay-modal').modal();
	$('div.alert').not('.alert-important').delay(6000).fadeOut(350);
</script>
@endsection