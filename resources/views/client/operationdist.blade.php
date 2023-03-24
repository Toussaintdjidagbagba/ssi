@extends('layouts.templaterefonte')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('content')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8">
<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-body">
                                      <div class="row"> 
                                        <div class="col-lg-12">
                                          <div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Validation</h5>
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="fa fa-chevron-left"></i></li>
                                                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                                                <li><i class="fa fa-minus minimize-card"></i></li>
                                                                <li><i class="fa fa-refresh reload-card"></i></li>
                                                                <li><i class="fa fa-times close-card"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <!-- Tab panes -->
                                                        <div class="tab-content card-block">
                                                            <div class="tab-pane active" role="tabpanel">

                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <th>Numéro d'Identité</th>
                                                                            <th>Service</th>
                                                                            <th>Montant</th>
                                                                            <th>Client</th>
                                                                            <th>Compte</th>
                                                                            <th>Référence</th>
                                                                            <th>Date</th>
                                                                            <th>Validation</th>
                                                                            <th>Statut</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        @forelse($allopp as $opp)
                                                                          <tr style="text-align: center">
                                                                            <td>{{ App\Providers\InterfaceServiceProvider::identiFilleul($opp->expediteur) }}</td>
                                                                            <!--td><img src="{{App\Providers\InterfaceServiceProvider::photoFilleul($opp->expediteur)}}" alt="{{ App\Providers\InterfaceServiceProvider::LibelleFilleul($opp->expediteur) }}" style="border-radius: 50%; width:50px; height:50px" ></td-->
                                                                            <td > @if($opp->nameservice == "achatssi") Achat SSI @endif
                                                                                  @if($opp->nameservice == "retrait") Retrait SSI @endif
                                                                                 
                                                                            </td>
                                                                            <td > {{ $opp->montant }} SSI</td>
                                                                            <td > {{ App\Providers\InterfaceServiceProvider::LibelleFilleul($opp->expediteur) }}</td>
                                                                            <td > @if($opp->typ != "") {{ $opp->typ }} @else espèce @endif</td>
                                                                            <td > {{ $opp->ref }}</td>
                                                                            <td > {{ $opp->created_at}}</td>
                                                                            <td > {{ $opp->datevalid }}</td>
                                                                            <td > @if($opp->statut == 0) <i class="fa fa-refresh fa-spin" style="font-size:30px;"></i> @else 
                                                                            <ul class="fa-ul"><li><i class="fa-li fa fa-check-square" style="font-size:30px;"></i> </li></ul>
                                                                            @endif</td>
                                                                            
                                                                            <?php 
                            												    $compte = array('da' =>$opp->created_at, 'ref' =>$opp->ref, 'typ' =>$opp->typ, 'client' => App\Providers\InterfaceServiceProvider::LibelleFilleul($opp->expediteur) ,'codes' => $opp->idS, 'montant' => $opp->montant, 'service' => $opp->nameservice);
                            													$comptejson = json_encode($compte);
													                        ?>
                                                                            <td > 
                                                                            <a class="identifyingeqp" href="#add" data-target="#add" data-toggle="modal" data-id="{{$comptejson}}edi"> <i class="fa fa-edit" style="font-size:30px;color:green;"></i> </a>
                                                                            
                                                                          </tr>
                                                                        @empty
                                                                          <tr >
                                                                            <td colspan="9" style="text-align: center; color: red">Opération vide!</td>
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
@endsection
<script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    
    <script type="text/javascript">
	    $(function () {
	        $(".identifyingeqp").click(function () {
	            var id = $(this).data('id');
	            var div = document.getElementById('tst');
	            console.log("jj");
	            if(id.substr(-3, 3) == "edi"){
	                identifiant = id.slice(0, id.length - 3);
	            	    var json = JSON.parse(identifiant);
	            	    lib = "";
	            	    if(json.service == "achatssi") lib = "Achat SSI";
	            	    if(json.service == "retrait") lib = "Retrait SSI";

                    	div.innerHTML = '<div class="modal-header">' +
							'<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button>' +
                            '<h4 class="modal-title" id="myModalLabel">Opération SSI : </h4>' +
                            '</div><div class="modal-body">' +
                            '<form class="form-horizontal" method="post" action="{{route("soppssi")}}">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}" /> ' +
                            '<input type="hidden" name="codes" value="'+json.codes+'" /> ' +
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12"> ' +
                            '    <label for="inp-type-2" class="col-sm-12">Service :</label>' +
                            '    <div class="col-sm-12"><input type="text" class="form-control" id="inp-type-2" value="'+lib+'" name="solde" disabled="true"></div>' +
                            '    </div> ' +
                            '    <div class="col-sm-12"> ' +
                            '    <label for="inp-type-2" class="col-sm-12">Montant :</label>' +
                            '    <div class="col-sm-12"> <input type="text" class="form-control" id="inp-type-2" value="'+json.montant+'" name="avance" disabled="true"> </div>  ' +
                            '    </div> ' +
                            ' </div> ' +
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12"> ' +
                            '       <label for="inp-type-2" class="col-sm-12">Client :</label>' +
                            '       <div class="col-sm-12"><input type="text" class="form-control" id="inp-type-2" name="duree" value="'+json.client+'" disabled="true"> </div> ' +
                            '    </div> ' +
                            '    <div class="col-sm-12"> ' +
                            '       <label for="inp-type-2" class="col-sm-12">Compte : </label>' +
                            '       <div class="col-sm-12"><input type="text" class="form-control" id="inp-type-2" name="recent" value="'+json.typ+'" disabled="true"> </div> ' +
                            '    </div> ' +
                            ' </div> ' +
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12">  ' +
                            '       <label for="inp-type-2" class="col-sm-12">Référence : </label>' +
                            '     <div class="col-sm-12"><input type="text" class="form-control" id="inp-type-2" name="lib" value="'+json.ref+'" disabled="true"></div> ' +
                            '    </div> ' +
                            '<button type="submit" class="btn btn-warning btn-sm waves-effect waves-light" style="float:left; color:white;">CONFIRMER</button>' +
                            '</div>'+
                            '</div><div class="modal-footer">'+
                            '<button type="button" data-dismiss="modal" class="btn btn-primary btn-sm waves-effect waves-light" style="float:right; color:white;">FERMER</button></div>';
	            }
	            
	            if(id.substr(-3, 3) == "del"){
	                identifiant = id.slice(0, id.length - 3);
	            	    var json = JSON.parse(identifiant);
	            	    lib = "";
	            	    if(json.service == "achatssi") lib = "Achat SSI";
	            	    if(json.service == "retrait") lib = "Retrait SSI";

                    	div.innerHTML = '<div class="modal-header">' +
							'<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span></button>' +
                            '<h4 class="modal-title" id="myModalLabel">Supprimer une demande d\'opération SSI : </h4>' +
                            '</div><div class="modal-body">' +
                            '<form class="form-horizontal" method="post" action="{{route("doppssi")}}">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}" /> ' +
                            '<input type="hidden" name="codes" value="'+json.codes+'" /> ' +
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12"> ' +
                            '    <label for="inp-type-2" class="col-sm-12">Voulez-vous vraiment supprimer la demande d\'opération suivante ?</label>' +
                            '    </div> ' +
                            ' </div> ' +
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12"> ' +
                            '    <label for="inp-type-2" class="col-sm-12">Service :</label>' +
                            '    <div class="col-sm-12"><input type="text" class="form-control" id="inp-type-2" value="'+lib+'" name="solde" disabled="true"></div>' +
                            '    </div> ' +
                            '    <div class="col-sm-12"> ' +
                            '    <label for="inp-type-2" class="col-sm-12">Montant :</label>' +
                            '    <div class="col-sm-12"> <input type="text" class="form-control" id="inp-type-2" value="'+json.montant+'" name="avance" disabled="true"> </div>  ' +
                            '    </div> ' +
                            ' </div> ' +
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12"> ' +
                            '       <label for="inp-type-2" class="col-sm-12">Client :</label>' +
                            '       <div class="col-sm-12"><input type="text" class="form-control" id="inp-type-2" name="duree" value="'+json.client+'" disabled="true"> </div> ' +
                            '    </div> ' +
                            '    <div class="col-sm-12"> ' +
                            '       <label for="inp-type-2" class="col-sm-12">Compte : </label>' +
                            '       <div class="col-sm-12"><input type="text" class="form-control" id="inp-type-2" name="recent" value="'+json.typ+'" disabled="true"> </div> ' +
                            '    </div> ' +
                            ' </div> ' +
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12">  ' +
                            '       <label for="inp-type-2" class="col-sm-12">Référence : </label>' +
                            '     <div class="col-sm-12"><input type="text" class="form-control" id="inp-type-2" name="lib" value="'+json.ref+'" disabled="true"></div> ' +
                            '    </div> <br>' +
                            '    <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light" style="float:left; color:white;">CONFIRMER</button>' +
                            '</div>'+
                            ' </div>   </div><div class="modal-footer"> ' + 
                            '<button type="button" data-dismiss="modal" class="btn btn-primary btn-sm waves-effect waves-light" style="float:right; color:white;">FERMER</button></div>';
	            }
      			
	        })
	    });
	</script>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
