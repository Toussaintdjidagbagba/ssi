@extends('layouts.templaterefonteadmin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Hover Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2 >
                      FILLEULS
                      </h2>
                      </div>
                    
                    <div class="body">
           
                        <div class="text-center" id="data">
                          @include('flash::message')
                        </div>
                            <form  class="user trna" style="border: 0.5px solid gray; padding: 20px" method="post" action="{{ route('Sclient') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}    
                             <input type="hidden" class="form-control " id="idunset" name="id" value="{{ $users->id }}" style="display:none">
              
                <div class="form-group">
                  <div class="col-md-6">
                    <label for="phot">Image Profil <i style="color: red">*</i></label><br>
                    @if( $users->photo == null || $users->photo == "")
                        <img class="profile-image" id="profils" src="photo/deadd.png" style="border-radius: 50%; width:150px; height:150px" >
                    @else
                        <img class="profile-image" id="profils" src="{{ $users->photo }}" style="border-radius: 50%; width:150px; height:150px" >
                    @endif
                    
                    
                      <input type="file" class="form-control " name="phot" id="phot" hidden style="display:none">
                      
                  </div>
                  
                  <div class="col-md-6">
                    <label for="filiden">Photo de la pièce d'identité <i style="color: red">*</i></label><br>
                    @if( $users->identite == null || $users->identite == "")
                        <img class="profile-image" id="identi" src="photo/deadd.png" style="border-radius: 50%; width:150px; height:150px" >
                    @else
                    <img class="profile-image" id="identi" src="{{ $users->identite }}" style="border-radius: 50%; width:150px; height:150px" >
                    @endif
                    <input type="file" class="form-control " name="filiden" id="filiden"  hidden style="display:none">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6">
                      
                  </div>
                  <div class="col-md-6">
                      @if( $users->confirme == 1)
                      <input type="checkbox" class="form-control " name="valphoto" id="valphoto" checked> 
                      @else
                      <input type="checkbox" class="form-control " name="valphoto" id="valphoto"> 
                      @endif
                      <label for="valphoto">Valider l'identité</label>
                  </div>
                </div>
                
                <div class="form-group ">
                  <div class="col-md-6 ">
                    <label>Code Personnel <i style="color: red">*</i></label>
                        <div class="form-line">
                      <input type="number" class="form-control " name="codepersonnel" id="codepersonnel" value="{{ $users->codeperso }}" placeholder="" disabled="true" >
                      </div>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="numide">Numéro de la pièce d'identité  <i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="numide" id="numide" value="{{ $users->numidentite }}" >
                    </div>
                  </div>
                </div>

                <!-- Nom et Prï¿½nom -->
                <div class="form-group ">
                  <div class="col-md-6">
                    <label>Nom <i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="nom" id="nom" value="{{ $users->nom}}" placeholder="" >
                    </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Prenom <i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="prenom" id="prenom" value="{{ $users->prenom}}" placeholder="" data-original-title="Entrer votre prï¿½nom">
                    </div>
                  </div>
                </div>
                
                <!-- Mail -->
                <div class="form-group">
                    <div class="col-md-12">
                  <label>E-mail <i style="color: red">*</i></label>
                  <div class="form-line">
                  <input type="mail" class="form-control " value="{{ $users->email}}" name="mail" id="mail" placeholder="Entrer votre E-mail"  data-original-title="Entrer votre E-mail" >
                  </div>
                  </div>
                </div>
                
                  <!--sexe-->
                 <div class="form-group ">
                  <div class="col-md-6">
                    <!-- Requete pour pays de la base de donnees-->
                    <label>Sexe <i style="color: red">*</i></label>
                    <div class="form-line">
                    <input value="{{ $users->sexe}}" type="text" class="form-control"  name="sexe" id="sexe" placeholder="" data-original-title="Entrer votre Sexe" disabled="true">
                     </div>
                  </div>

                  <!--telephone-->
                   <div class="col-md-6">
                    <label>Téléphone<i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="tel" class="form-control " value="{{ $users->tel}}" name="tel" id="tel" placeholder="" data-original-title="Entrer votre tï¿½lï¿½phone">
                    </div>
                  </div>
                </div>
                 
 
                <!-- Mail -->
                <div class="form-group">
                    <div class="col-md-12">
                  <label>Lien sponsor <i style="color: red">*</i></label>
                  <div class="form-line">
                  <input type="text" class="form-control " value="https://sourcedusuccesinternational.com/inscription-monsponsor-{{$users->codeunique}}" name="mail" id="mail" placeholder="Entrer votre E-mail"  data-original-title="Entrer votre E-mail" disabled="true">
                  </div>
                  </div>
                </div>

                <!-- Parrain et Payement -->
                <div class="form-group ">
                  <div class="col-md-6">
                    <label>Mon sponsor <i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="parrain" id="parrain" placeholder="Code de sponsor" data-original-title="Entrer votre Parrain" disabled="true" value="{{ $users->parrain}}" /> 
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label>Mon code sponsor<i style="color: red">*</i></label>
                    <div class="form-line">
                    <input value="{{ $users->codeunique}}" type="text" class="form-control"  name="codeunique" id="codeunique" data-original-title="Entrer votre code unique" disabled="true"> 
                     </div>
                    </input>
                  </div>
                </div>
          

                <div class="form-group">
                    <div class="col-md-6">
                      <label>Nom d'utilisateur <i style="color: red">*</i></label>
                      <div class="form-line">
                      <input type="text" class="form-control " value="{{ $users->nomuser}}" name="nomuser" id="nomuser" disabled="true">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label>Définir en tant que distributeur <i style="color: red">*</i> :</label>
                      <div class="form-line">
                      <select type="number" class="form-control show-tick" name="role" id="role">
                        @if( $users->Role == 4)
                            <option value="4">Distributeur</option>
                        @endif
                        @if( $users->Role == 5)
                            <option value="5">Point de Vente</option>
                        @endif
                        <option value="0"></option>
                        <option value="4">Distributeur</option>
                        <option value="5">Point de Vente</option>
                      </select>
                      </div>
                    </div>
                </div>

               

                <input type="submit" name="mettreajour" value="METTRE A JOUR" class="btn btn-primary .hor-grd .btn-grd-2 .btn-out-dotted btn-user btn-block" />
                
              </form>
              
              </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
        <link href="cssdste/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    	<script type="text/javascript">
    	
    	function getXMLHttpRequest() {
              var xhr = null;
              
              if (window.XMLHttpRequest || window.ActiveXObject) {
                if (window.ActiveXObject) {
                  try {
                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
                  } catch(e) {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                  }
                } else {
                  xhr = new XMLHttpRequest(); 
                }
              } else {
                alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
                return null;
              }
              
              return xhr;
            }
    	
    	// Validation du profil
    	const valphoto = document.getElementById("valphoto");
    	const unset = document.getElementById("idunset").value;
    	
    	
    	valphoto.addEventListener("click", function () {
            //console.log(valphoto.value);
    	
    	    document.getElementById("data").innerHTML = "<b style='color:green'>En cours de validation..</b>";
            
            var xhr = getXMLHttpRequest(); 
            xhr.open("GET", "{{ route('vpl') }}?uset="+unset, true);
            xhr.send(null);
            xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                  document.getElementById("data").innerHTML = "<b style='color:green'> "+xhr.responseText+" </b>";
              }
            }; 
        }, true); 
        
        
		
		const input = document.getElementById("phot")
		const pick = document.querySelector("#profils")
		pick.addEventListener('click', () => {
		    console.log("Bon");
			input.click()
		})


		input.addEventListener('change', () => {
			var reader = new FileReader()
			const preview = document.getElementById("profils")
			reader.onload = function() {
				preview.setAttribute('src', reader.result)
			}
			reader.readAsDataURL(event.target.files[0]);
		})
		
		const inputi = document.getElementById("filiden")
		const picki = document.querySelector("#identi")
		picki.addEventListener('click', () => {
		    console.log("Bon");
			inputi.click()
		})


		inputi.addEventListener('change', () => {
			var reader = new FileReader()
			const preview = document.getElementById("identi")
			reader.onload = function() {
				preview.setAttribute('src', reader.result)
			}
			reader.readAsDataURL(event.target.files[0]);
		})
        </script>

@endsection