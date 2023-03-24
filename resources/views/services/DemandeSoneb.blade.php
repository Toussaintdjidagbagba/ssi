@extends('layouts.templaterefonteadmin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
                @include('flash::message')
                <h2>
                    
                    <small></small> 
                </h2>
            </div>
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card"> 
                <div class="header">
                    <h2>
                    Liste des demandes SONEB
                    
                </div>
                
                <div class="body">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th> Identifiant </th> 
                                  <th> Nom & Prénom </th>
                                  <th> Mail / WhatsApp </th>
                                  <th>Zone + Numéro Abonné</th>
                                  <th> Présentation </th>
                                  <th> Montant Facture</th>
                                  <th> Envoyer le </th>
                                  <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($demandes as $demande)
                              <tr>
                                <td>{{ $demande->CodePersoUser }}</td>
                                <td>{{ $demande->Nom }} {{ $demande->Prenom }}</td>
                                <td>{{ $demande->Email }} / {{ $demande->WhatsApp }}</td>
                                <td>{{ $demande->Police }}</td>
                                <td>{{ $demande->Presentation }}</td>
                                <td>{{ $demande->Montant }}</td>
                                <td>{{ $demande->date }}</td>
                                <td>
                                  <button type="button" title="Reçu"  class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                    <a href="{{ route('sonebrecu', $demande->RefRecu)}}" style="color:white;"> <i class="material-icons">assignment</i></a> 
                                  </button>
                                  @if($demande->Statut == "oui")
                                      <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #a2bd40"><a href="#" style="color:white;"> <i class="material-icons">event_available</i></a></button>
                                  @else
                                      <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #ccc2c2"><a href="#" style="color:white;"> <i class="material-icons">event_busy</i></a></button>
                                  @endif
                                  @php
                                    	$comptesup = array('dem' => $demande->id, 'message' => "Voulez-vous vraiment supprimé la demande soneb de ".$demande->Nom." ".$demande->Prenom." sur la police ". $demande->Police. " dont le montant est ".
                                    	$demande->Montant);
										$comptesupjson = json_encode($comptesup);
										
										$compterej = array('dem' => $demande->id, 'message' => "Voulez-vous vraiment rejeté la demande soneb de ".$demande->Nom." ".$demande->Prenom." sur la police ". $demande->Police. " dont le montant est ".
                                    	$demande->Montant);
										$compterejjson = json_encode($compterej);
                                  @endphp
                                  <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                      <a href="{{ route('deleteSoneb',$demande->RefRecu)}}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>
                                  <button type="button" title="Rejet"  class="btn btn-warning btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                  <a class="dropdown-item identifyingeqp" href="#add" data-target="#add" data-toggle="modal" data-id="{{$compterejjson}}reje" title="Rejet">
                                      <i class="material-icons">reject</i>
                                  </a>
                                  </bouton>
                                </td>
                              </tr>
                            @empty
                              <tr >
                                <td colspan="6" style="text-align: center;">Pas de demande disponible!!!</td>
                              </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>
@endsection

@section("js")

<script type="text/javascript">
	    $(function () {
	        $(".identifyingeqp").click(function () {
	            var id = $(this).data('id');
	            var div = document.getElementById('tst');
	            console.log(id);
	            if (id != 0) {

	            	if(id.substr(-4, 4) == "reje"){
	            	    identifiant = id.slice(0, id.length - 4);
	            	    var json = JSON.parse(identifiant);

                    	div.innerHTML = 
                    	'<div class="modal-header">' +
                                '   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '   <h4 class="modal-title" id="myModalLabel">Rejet : </h4>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '   <form class="form-horizontal" method="post" action="">' +
                                '      <input type="hidden" name="_token" value="{{ csrf_token() }}" />' +
                                '      <input type="hidden" name="dem" value="'+json.dem+'" />' +
                                '      <div class="form-group">  ' +
                                '           <label for="inp-type-2" class="col-sm-12 control-label">'+ json.message +' </label> ' +
                                '      </div>       ' +
                                '    <div class="modal-footer">   '+
                                '    <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light" style="float:left; color:white;"> CONFIRMER </button>' +
                                '    <button type="bouton" data-dismiss="modal" class="btn btn-primary btn-sm waves-effect ' +
                                '    waves-light" style="float:right; color:white;">FERMER</button></div>';
	            	    
	            	}
	            	
	            	if(id.substr(-4, 4) == "supr"){
	            	    identifiant = id.slice(0, id.length - 4);
	            	    var json = JSON.parse(identifiant);

                    	div.innerHTML = 
                    	'<div class="modal-header">' +
                                '   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '   <h4 class="modal-title" id="myModalLabel">Supression : </h4>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '   <form class="form-horizontal" method="post" action="">' +
                                '      <input type="hidden" name="_token" value="{{ csrf_token() }}" />' +
                                '      <input type="hidden" name="dem" value="'+json.dem+'" />' +
                                '      <div class="form-group">  ' +
                                '           <label for="inp-type-2" class="col-sm-12 control-label">'+ json.message +' </label> ' +
                                '      </div>       ' +
                                '    <div class="modal-footer">   '+
                                '    <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light" style="float:left; color:white;"> CONFIRMER </button>' +
                                '    <button type="bouton" data-dismiss="modal" class="btn btn-primary btn-sm waves-effect ' +
                                '    waves-light" style="float:right; color:white;">FERMER</button></div>';
	            	    
	            	}
	            }
	        })
	    });
	</script>

@endsection