@extends('layouts.templaterefonte')

@section('content')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8">
  <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Automobile NSIA :</h5>
                                                        <div class="card-header-right">
                                                            
                                                            <button type="button" style="margin-right: 30px; float: right; padding-right: 30px; padding-left: 30px;" 
                                                            class="btn bg-deep-blue waves-effect" data-color="deep-blue" data-toggle="modal" data-target="#add">Ajouter</button>
                                                            <!--ul class="list-unstyled card-option">
                                                                <li><i class="fa fa-chevron-left"></i></li>
                                                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                                                <li><i class="fa fa-minus minimize-card"></i></li>
                                                                <li><i class="fa fa-refresh reload-card"></i></li>
                                                                <li><i class="fa fa-times close-card"></i></li>
                                                            </ul-->
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <!-- Tab panes -->
                                                        <div class="tab-content card-block">
                                                            <div class="tab-pane active" role="tabpanel">

                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <tr>
                                                                            
                                                                            <th>Nom & Prenom</th>
                                                                            <th>Moteur</th>
                                                                            <th>Puissance</th>
                                                                            <th>Nombre de place</th>
                                                                            <th>Durée du contrat</th>
                                                                            <th>Carte grise</th>
                                                                            <th>Montant à payer</th>
                                                                            <th>Valider l'opération</th>
                                                                            <th>Documents final</th>
                                                                            <th>Statut</th>
                                                                            <th>Inscrire le</th> 
                                                                        </tr>
                                                                        @forelse($data as $datas)
                
                                                                          <tr style="text-align: center;">
                                                                            <td>{{ $datas->nom }}</td>
                                                                            <td>{{ $datas->moteur }}</td>
                                                                            <td>{{ $datas->puissance }}</td>
                                                                            <td>{{ $datas->nombre }}</td>
                                                                            <td>{{ $datas->duree }}</td>
                                                                            <td> <a href="{{ $datas->doc }}">Télécharger Carte</a> </td>
                                                                            <td>{{ $datas->montant }} SSI</td>
                                                                            <?php 
                            												    $compte = array('id' =>$datas->id, 'montant' =>$datas->montant);
                            													$comptejson = json_encode($compte);
													                        ?>
                                                                            <td>
                                                                                @if($datas->montantV == 0)
                                                                                    <a class="identifyingeqp" href="#confir" data-target="#confir" data-toggle="modal" data-id="{{$comptejson}}edi"> <i class="fa fa-edit" style="font-size:30px;color:green;"></i> </a></td>
                                                                                @else
                                                                                    Validé
                                                                                @endif
                                                                            <td> <a href="{{ $datas->docfinal }}">Télécharger</a> </td>
                                                                            <td> @if($datas->Statut == null) <i class="fa fa-refresh fa-spin" style="font-size:30px;"></i> @else 
                                                                            <ul class="fa-ul"><li><i class="fa-li fa fa-check-square" style="font-size:30px;"></i> </li></ul>
                                                                            @endif </td>
                                                                            <td>{{ $datas->created_at}}</td>
                                                                          </tr>
                                                                        @empty
                                                                          <tr >
                                                                            <td colspan="8" style="text-align: center;">Pas de demande disponible!!!</td>
                                                                          </tr>
                                                                        @endforelse
                                                                    </table>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    
<script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    
    <script type="text/javascript">
	    $(function () {
	        $(".identifyingeqp").click(function () {
	            var id = $(this).data('id');
	            var div = document.getElementById('tst');
	            //console.log("jj");
	            if(id.substr(-3, 3) == "edi"){
	                identifiant = id.slice(0, id.length - 3);
	            	    var json = JSON.parse(identifiant);
	            	    
	            	    if(json.montant == 0){
	            	        div.innerHTML = '<div class="modal-header">' +
							'<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                            '<h4 class="modal-title" id="myModalLabel">Validation :</h4>' +
                            '</div><div class="modal-body">' +
                            '<form class="form-horizontal">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}" /> ' +
                            '<input type="hidden" name="id" value="'+json.id+'" /> ' +
                            
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12"> ' +
                            '       <label for="inp-type-2" class="col-sm-12">Veuillez patienter pendant que le traitement de la demande est en cours. </label>' +
                            '    </div> ' +
                            '</div>'+
                            '</div><div class="modal-footer">'+
                            '<button type="button" data-dismiss="modal" class="btn btn-primary btn-sm waves-effect waves-light" style="float:right; color:white;">FERMER</button></div>';
	            	    }else{
	            	        div.innerHTML = '<div class="modal-header">' +
							'<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                            '<h4 class="modal-title" id="myModalLabel">Validation : </h4>' +
                            '</div><div class="modal-body">' +
                            '<form class="form-horizontal" method="post" action="{{route("setnaval")}}">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}" /> ' +
                            '<input type="hidden" name="id" value="'+json.id+'" /> ' +
                            
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12"> ' +
                            '       <label for="inp-type-2" class="col-sm-12"> Vous voulez vraiment valider l\'opération NSIA Assurance Automobile d\'un montant de '+json.montant+' SSI ? </label>' +
                            '    <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light" style="float:left; color:white;">CONFIRMER</button>' +
                            '    </div> ' +
                            '</div>'+
                            '</div><div class="modal-footer">'+
                            '<button type="button" data-dismiss="modal" class="btn btn-primary btn-sm waves-effect waves-light" style="float:right; color:white;">FERMER</button></div>';
	            	    }
	            }
	            
	        })
	    });
	</script>
                    
<div class="modal fade" id="confir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">

		<div class="modal-content" id="tst">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Enregistrer : </h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">FERMER</button>
				<button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">AJOUTER</button>
			</div>
		</div>

	</div>
	</div>
	
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                          <div style="background-color: rgba(250,250,250,0.90);" class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="add">NSIA Assurances Automobile </h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              <form class="user" method="post" action="{{ route('setna') }}" enctype="multipart/form-data" accept=".png, .jpg, .jpeg, .pdf">
                                                                {{ csrf_field() }}
                                                              
                                                                <div class="form-group">
                                                                    <label>Nom et prénoms<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Z a-z]+" type="text" class="form-control" name="name" placeholder="Entrer votre nom" data-original-title="Entrer votre nom">
                                                                    
                                                                </div>

                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Moteur<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z 0-9]+" type="text" class="form-control " name="moteur" id="moteur" placeholder="Entrer la référence du moteur" data-original-title="Entrer la référence du moteur">
                                                                </div>
                                                                
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Puissance<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z 0-9]+" type="text" class="form-control " name="puissance" id="puissance" placeholder="Entrer la puissance" data-original-title="Entrer la puissance">
                                                                  </div>
                                                                </div>
                                         
                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Nombre de places<i style="color: red">*</i></label>
                                                                    <input required pattern="[0-9]+" type="number" class="form-control " name="nbre" id="nbre" placeholder="Entrer nombre de places" data-original-title="Entrer nombre de places">
                                                                   
                                                                  </div>
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Importer la carte grise<i style="color: red">*</i></label>
                                                                    <input required type="file" class="form-control " name="carte" id="carte" >
                                                                    
                                                                  </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Durée du contrat<i style="color: red"> (en jour) </i></label>
                                                                    <input required pattern="[0-9]+" type="number" class="form-control " name="duree" id="duree" placeholder="0 jours">
                                                                  </div>
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Numéro<i style="color: red"> * </i></label>
                                                                    <input required pattern="[0-9]+" type="number" class="form-control " name="tel" id="tel" placeholder="61000000">
                                                                  </div>
                                                                </div>
                                                                <input type="submit" name="Valider" value="Valider" class="btn btn-user btn-block" style="background-color: #000; color : yellow" />
                                                                
                                                              </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
@endsection
