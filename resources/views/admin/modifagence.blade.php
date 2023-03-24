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
                      Modifier une agence
                      </h2>
                      </div>
                    
                    <div class="body">
           
                        <div class="text-center" id="data">
                          @include('flash::message')
                        </div>
                            <form  class="user trna" style="border: 0.5px solid gray; padding: 20px" method="post" action="{{ route('coursSMg') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}    
                             <input type="hidden" class="form-control " id="idunset" name="idA" value="{{ $agen->id }}" style="display:none">
              
                <div class="form-group">
                  <div class="col-md-6">
                    <label for="filiden">Photo de l'agence <i style="color: red">*</i></label><br>
                    @if( $agen->images == null || $agen->images == "")
                        <img class="profile-image" id="identi" src="photo/deadd.png" style="border-radius: 50%; width:150px; height:150px" >
                    @else
                    <img class="profile-image" id="identi" src="mapsapi/images/{{ $agen->images }}" style="border-radius: 50%; width:150px; height:150px" >
                    @endif
                    <input type="file" class="form-control " name="filiden" id="filiden"  hidden style="display:none">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6">
                      
                  </div>
                  <!--div class="col-md-6">
                      
                      <input type="checkbox" class="form-control " name="valphoto" id="valphoto" checked> 
                      <input type="checkbox" class="form-control " name="valphoto" id="valphoto"> 
                      <label for="valphoto">Valider la carte d'identitï¿½</label>
                  </div-->
                </div>
                
                <div class="form-group ">
                  <div class="col-md-6 ">
                    <label>Nom ou denomination <i style="color: red">*</i></label>
                        <div class="form-line">
                      <input type="text" class="form-control " name="nom" id="nom" value="{{ $agen->name }}"  >
                      </div>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="description">Description <i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="description" id="description" value="{{ $agen->description }}" >
                    </div>
                  </div>
                </div>

                
                <div class="form-group ">
                  <div class="col-md-6">
                    <label>Telephone <i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="number" class="form-control " name="tel" id="tel" value="{{ $agen->phone}}"  >
                    </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Longitude <i style="color: red">*</i></label>
                    <div class="form-line">
                    <input type="number" class="form-control " name="long" id="long" step="0.0000001" value="{{ $agen->longitude}}" >
                    </div>
                  </div>
                </div>
                
                <!-- Mail -->
                <div class="form-group">
                    <div class="col-md-6">
                  <label>Latitude <i style="color: red">*</i></label>
                  <div class="form-line">
                  <input type="number" class="form-control " value="{{ $agen->latitude}}" step="0.0000001" name="lat" id="lat"  >
                  </div>
                  </div>
                  <div class="col-md-6">
                  <label>Adresse <i style="color: red">*</i></label>
                  <div class="form-line">
                  <input type="text" class="form-control " value="{{$agen->adresse}}" name="adr" id="adr" placeholder="Entrer votre E-mail"  data-original-title="Entrer votre E-mail" >
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