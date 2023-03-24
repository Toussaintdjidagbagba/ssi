@extends('layouts.templaterefonteadmin')

@section('css')

    <!-- Bootstrap Select Css -->
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
                                Listes des utilisateurs
                            
                            <button type="button" style="margin-right: 30px; float: right; padding-right: 30px; padding-left: 30px;" class="btn bg-deep-orange waves-effect" data-color="deep-orange" data-toggle="modal" data-target="#add">Ajouter</button>
                       		</h2>
                        </div>
                        <div class="body">
                        	<div class="table-responsive" data-pattern="priority-columns">
								<table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
									<thead>
									<tr>
										<th>Identifiant</th>
										<th data-priority="1">Nom</th>
										<th data-priority="3">Prénom(s)</th>
										<th data-priority="1">Téléphone</th>
										<th data-priority="3">Profession</th>
										<th data-priority="3">Rôle</th> 
										<th data-priority="6">Actions</th>
									</tr>
									</thead>
									<tbody>
                                        @forelse($list as $user)
                                        <tr>
                                            <th><span class="co-name">{{$user->login}}</span></th>
                                            <td>{{$user->nom}}</td>
                                            <td>{{$user->prenom}}</td>
                                            <td>{{$user->tel}}</td>
                                            <td>{{$user->other}}</td>
                                            <td>{{App\Providers\InterfaceServiceProvider::LibelleRole($user->Role)}}</td>
                                            <td>
                                            @if(in_array("update_user", session("auto_action")))
                                            <button type="button" title="Modifier"  class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                                <a href="{{ url('modif-utilisateur-') }}{{$user->idUser}}" style="color:white;"> <i class="material-icons">system_update_alt</i></a> 
                                                
                                            </button>
                                            @endif

                                            @if(in_array("delete_user", session("auto_action")))
                                            <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ url('delete-utilisateur-') }}{{$user->idUser}}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>
                                            @endif

                                            @if(in_array("reset_user", session("auto_action")))
                                            <button type="button" title="Réinitialiser"  class="btn btn-warning btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ url('reinitialiser-utilisateur-') }}{{$user->idUser}}" style="color:white;"> <i class="material-icons">restore</i></a></button>
                                            @endif

                                            @if(in_array("status_user", session("auto_action")))
                                            @if($user->statut == "0")
                                            <button type="button" title="Désactivé ?"  class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href=" {{ url('desactivé-utilisateur-') }}{{$user->idUser}}" style="color:white;"> <i class="material-icons">toggle_on</i></a></button>
                                            @endif
                                            @if($user->statut == "1")
                                            <button type="button" title="Activé ?"  class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style="background-color:grey"><a href="{{ url('activé-utilisateur-') }}{{$user->idUser}}" style="color:white;"> <i class="material-icons">toggle_off</i></a></button>
                                            @endif
                                            @endif
                                            
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7"><center>Pas d'utilisateur enregistrer!!!</center> </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
								</table>
                                {{$list->links()}}
							</div> 
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
</section>
@endsection

@section("model")

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Enregistrer un utilisateur : </h4>
			</div>
            <form method="post" action="{{ route('setuser') }}">
			<div class="modal-body">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row clearfix">
                        <div class="col-md-6">
                             	<label for="identifiant">Identifiant</label>
                                <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="identifiant" name="login" class="form-control" placeholder="" required>
                                </div>
                                </div>
                        </div>

                        <div class="col-md-6">
                        	<label for="email">Email</label>
                           <div class="form-group">
                            <div class="form-line">
                                <input type="email" id="email" name="mail" class="form-control" placeholder="">
                            </div>
                           </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-6">
                             	<label for="nom">Nom</label>
                                <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="nom" name="nom" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                        	<label for="prenom">Prénom</label>
                           <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="prenom" name="prenom" class="form-control" placeholder="">
                            </div>
                           </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-6">
                             	<label for="tel">Téléphone</label>
                                <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="tel" name="tel" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                        	<label for="adr">Adresse</label>
                           <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="adr" name="adress" class="form-control" placeholder="">
                            </div>
                           </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-6">
                             	<label for="sexe">Sexe</label>
                                <div class="form-group">
                                <div class="form-line">
                                    <select type="text" id="sexe" name="sexe" class="form-control show-tick" placeholder="">
                                    	<option value="F">Féminin</option>
										<option value="M">Masculin</option>	
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                        	<label for="role">Rôle</label>
                           <div class="form-group">
                            <div class="form-line">
                                @php
                                    $roles = App\Providers\InterfaceServiceProvider::AllRole();
                                @endphp
                                <select type="text" id="role" name="role" class="form-control show-tick" placeholder="">
                                	@foreach($roles as $role)
                                        <option value="{{ $role->idRole }}">{{ $role->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                           </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                             	<label for="autres">Autres</label>
                                <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="autres" name="autres" class="form-control" placeholder="">
                                    	
                                </div>
                            </div>
                        </div>
                    </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">FERMER</button>
				<button type="submit" class="btn bg-deep-orange waves-effect">AJOUTER</button>
			</div>
            </form>
		</div>
	</div>
	</div>

@endsection