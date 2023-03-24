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
                    Liste des demandes NSIA Automobile
                    
                </div>
                
                <div class="body">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th> Nom</th>
                                  <th> Numéro</th>
                                  <th> Moteur</th>
                                  <th> Puissance</th>
                                  <th> Nombre de places</th>
                                  <th> Duree</th>
                                  <th> Carte grise</th>
                                  <th> Montant</th>
                                  <th> Saisir montant</th>
                                  <th> Valider</th>
                                  <th> Statut</th>
                                  <th> Valider le</th>
                                  <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $demande)
                              <tr>
                                <td>{{ $demande->nom }}</td>
                                <td>{{ $demande->num }}</td>
                                <td>{{ $demande->moteur }}</td>
                                <td>{{ $demande->puissance }}</td>
                                <td>{{ $demande->nombre }}</td>
                                <td>{{ $demande->duree }}</td>
                                <td><a href="{{ $demande->doc }}">Telecharger </a></td>
                                <td>{{ $demande->montant }} SSI</td>
                                <?php 
                            		$compte = array('id' =>$demande->id, 'montant' =>$demande->montant);
                            		$comptejson = json_encode($compte);
								?>
                                <td><a class="identifyingeqp" href="#addmontant" data-target="#addmontant" data-toggle="modal" data-id="{{$comptejson}}edi">
                                     <center><i class="material-icons">assignment</i></a></center>
                                     </a></td>
                                <td><a class="identifyingeqp" href="#confir" data-target="#confir" data-toggle="modal" data-id="{{$comptejson}}edv">
                                     <center><i class="material-icons">assignment</i></a></center>
                                     </a></td>
                                <td>
                                      @if($demande->Statut != 'n')
                                        <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #a2bd40"><a href="#" style="color:white;"> <i class="material-icons">event_available</i></a></button>
                                      @else
                                        <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #ccc2c2"><a href="#" style="color:white;"> <i class="material-icons">event_busy</i></a></button>
                                      @endif
                                </td>
                                <td>{{ $demande->DateValider }}</td>
                                
                                <td>
                                <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('deleteNSIA',$demande->id)}}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>
                                </td>
                                
                                
                              </tr>
                            @empty
                              <tr >
                                <td colspan="9" style="text-align: center;">Pas de demande disponible!!!</td>
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
<script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    
    <script type="text/javascript">
	    $(function () {
	        $(".identifyingeqp").click(function () {
	            var id = $(this).data('id');
	            
	            
	            if(id.substr(-3, 3) == "edi"){
	                var div = document.getElementById('montactu');
	                identifiant = id.slice(0, id.length - 3);
	            	    var json = JSON.parse(identifiant);
	            	    
	            	    div.innerHTML = '<div class="col-md-12">'+
	            	                    '<input type="hidden" name="id" value="'+json.id+'" /> ' +
	            	                    '       <label for="titre"> Montant actuel '+json.montant+' SSI. </label>' +
	            	                    '</div> ';
                        //console.log("jj");
	            }
	            if(id.substr(-3, 3) == "edv"){
	                var div = document.getElementById('tst');
	                var divval = document.getElementById('infoval');
	                identifiant = id.slice(0, id.length - 3);
	            	    var json = JSON.parse(identifiant);
	            	    
	            	    if(json.montant == 0){
	            	        div.innerHTML = '<div class="modal-header">' +
							'<h4 class="modal-title" id="myModalLabel">Validation :</h4>' +
                            '</div><div class="modal-body">' +
                            '<form class="form-horizontal">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}" /> ' +
                            '<input type="hidden" name="id" value="'+json.id+'" /> ' +
                            
                            ' <div class="form-group"> ' +
                            '    <div class="col-sm-12"> ' +
                            '       <label for="inp-type-2" class="col-sm-12">Impossible!! Veuillez saisir le montant d\'abord. </label>' +
                            '    </div> ' +
                            '</div>'+
                            '</div><div class="modal-footer">'+
                            '<button type="button" data-dismiss="modal" class="btn btn-primary btn-sm waves-effect waves-light" style="float:right; color:white;">FERMER</button></div>';
	            	    }else{
	            	        divval.innerHTML = '<div class="col-md-12">'+
	            	                    '<input type="hidden" name="id" value="'+json.id+'" /> ' +
	            	                    '       <label for="titre">  Vous voulez vraiment valider l\'operation NSIA Assurance Automobile d\'un montant de '+json.montant+' SSI ? Si oui importer les fichiers. </label>' +
	            	                     '</div> ';
	            	                    
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
                <h4 class="modal-title" id="myModalLabel">Valider le montant : </h4>
            </div>
            <form method="post" action="{{ route('nsiaserviceV') }}" enctype="multipart/form-data">
             <div class="modal-body">
               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
               
               <div class="row clearfix" id="infoval">
                    
                </div>
                
                <div class="row clearfix">
                    <div class="col-md-12">
                          <label for="cout">Fichier <i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                                <input type="file" accept=".pdf" class="form-control" required id="fich" name="fich">
                            
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">FERMER</button>
                <button type="submit" class="btn bg-deep-blue waves-effect">VALIDER</button>
            </div>
            </form>
		</div>

	</div>
	</div>
	
<div class="modal fade" id="addmontant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Saisir le montant : </h4>
            </div>
            <form method="post" action="{{ route('nsiaserviceM') }}">
             <div class="modal-body">
               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
               
               <div class="row clearfix" id="montactu">
                    
                </div>
                
                <div class="row clearfix">
                    <div class="col-md-12">
                          <label for="cout">Remplacer par <i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                                <input type="number" class="form-control" required id="montant" name="montant" autofocus autocomplete>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">FERMER</button>
                <button type="submit" class="btn bg-deep-blue waves-effect">AJOUTER</button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection