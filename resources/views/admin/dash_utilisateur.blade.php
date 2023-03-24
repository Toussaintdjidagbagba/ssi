@extends('layouts._temp')

@section('css')

    <!-- Bootstrap Select Css -->
    <link href="cssdste/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

@endsection

@section('content')

	<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Paramètres
                    <small></small>
                </h2>
            </div>
            <div class="row clearfix">
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Liste des utilisateurs
                                <button type="button" style="margin-right: 30px; float: right; padding-right: 30px; padding-left: 30px;" 
                                class="btn bg-green waves-effect" data-toggle="modal" data-target="#add">Ajouter</button>
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
										<th data-priority="3">Email</th>
										<th data-priority="3">Rôle</th>
										<th data-priority="6">Actions</th>
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
        </div>

@endsection

@section("model")
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Enregistrer un utilisateur : </h4>
			</div>
			<div class="modal-body">

				<form method="post" action="">
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
                                <select type="text" id="role" name="role" class="form-control show-tick" placeholder="">
                                	<option></option>
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

                </form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">FERMER</button>
				<button type="submit" class="btn bg-green waves-effect">AJOUTER</button>
			</div>
		</div>
	</div>
	</div>
@endsection