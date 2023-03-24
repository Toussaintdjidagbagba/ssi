@extends('layouts.templaterefonte')

@section('content')
<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-body">
                                      <div class="row"> 
                                        <div class="col-lg-12">
                                          <h3 class="page-header">Profil</h3>
                                        </div>
      <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        
        <!-- Nested Row within Card Body -->
        <div class="row">
          
          <div class="col-lg-12">
            <div class="p-5">
   
              <div class="text-center">
                @include('flash::message')
                
              </div>
              <!-- Formulaire du profil -->
              <form class="user" method="post" action="{{ route('profilS') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
              
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="phot">Image Profil <i style="color: red">*</i></label><br>
                    @if( $users[0]->photo == null || $users[0]->photo == "")
                        <img class="profile-image" id="profils" src="photo/deadd.png" style="border-radius: 50%; width:150px; height:150px" >
                    @else
                        <img class="profile-image" id="profils" src="{{ $users[0]->photo }}" style="border-radius: 50%; width:150px; height:150px" >
                    @endif
                    
                      <input type="file" class="form-control " name="phot" id="phot" hidden>
                      
                  </div>
                  
                  <div class="col-sm-6">
                    <label for="filiden">Photo de la pièce d'identité <i style="color: red">*</i></label><br>
                    @if( $users[0]->identite == null || $users[0]->identite == "")
                        <img class="profile-image" id="identi" src="photo/deadd.png" style="border-radius: 50%; width:150px; height:150px" >
                    @else
                    <img class="profile-image" id="identi" src="{{ $users[0]->identite }}" style="border-radius: 50%; width:150px; height:150px" >
                    @endif
                    <input type="file" class="form-control " name="filiden" id="filiden"  hidden>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Code Personnel <i style="color: red">*</i></label>
                      <input type="number" class="form-control " name="codepersonnel" id="codepersonnel" value="{{ $users[0]->codeperso }}" placeholder="" disabled="true" >
                      @if($errors->has('codepersonnel'))
                        <p style="color: red"> {{ $errors->first('codepersonnel') }}</p>
                      @endif
                  </div>
                  
                  <div class="col-sm-6">
                    <label for="numide">Numéro de la pièce d'identité <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="numide" id="numide" value="{{ $users[0]->numidentite }}" >
                  </div>
                </div>

                <!-- Nom et Prénom -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nom <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="nom" id="nom" value="{{ $users[0]->nom}}" placeholder="" >
                    @if($errors->has('nom'))
                      <p style="color: red"> {{ $errors->first('nom') }}</p>
                    @endif
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Prenom <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="prenom" id="prenom" value="{{ $users[0]->prenom}}" placeholder="" data-original-title="Entrer votre prénom">
                    @if($errors->has('prenom'))
                      <p style="color: red"> {{ $errors->first('prenom') }}</p>
                    @endif
                  </div>
                </div>
                
                <!-- Mail -->
                <div class="form-group">
                  <label>E-mail <i style="color: red">*</i></label>
                  <input type="mail" class="form-control " value="{{ $users[0]->email}}" name="mail" id="mail" placeholder="Entrer votre E-mail"  data-original-title="Entrer votre E-mail" disabled="true">
                  @if($errors->has('mail'))
                      <p style="color: red"> {{ $errors->first('mail') }}</p>
                  @endif
                </div>
                
                  <!--sexe-->
                 <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <!-- Requete pour pays de la base de donnees-->
                    <label>Sexe <i style="color: red">*</i></label>
                    <input value="{{ $users[0]->sexe}}" type="text" class="form-control"  name="sexe" id="sexe" placeholder="" data-original-title="Entrer votre Sexe">
                      
                  </div>

                  <!--telephone-->
                   <div class="col-sm-6">
                    <label>Téléphone <i style="color: red">*</i></label>
                    <input type="tel" class="form-control " value="{{ $users[0]->tel}}" name="tel" id="tel" placeholder="" data-original-title="Entrer votre téléphone">
                    @if($errors->has('tel'))
                      <p style="color: red"> {{ $errors->first('tel') }}</p>
                    @endif
                  </div>
                </div>
                 
 
                <!-- Mail -->
                <div class="form-group">
                  <label>Lien sponsor <i style="color: red">*</i></label>
                  <input type="text" class="form-control " value="https://sourcedusuccesinternational.com/inscription-monsponsor-{{$users[0]->codeunique}}" name="mail" id="mail" placeholder="Entrer votre E-mail"  data-original-title="Entrer votre E-mail" disabled="true">
                  @if($errors->has('mail'))
                      <p style="color: red"> {{ $errors->first('mail') }}</p>
                  @endif
                </div>

                <!-- Parrain et Payement -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Mon sponsor <i style="color: red">*</i></label>
                    <input type="text" class="form-control " name="parrain" id="parrain" placeholder="Code de sponsor" data-original-title="Entrer votre Parrain" disabled="true" value="{{ $users[0]->parrain}}" /> 
                    
                  </div>
                  <div class="col-sm-6">
                    <label>Mon code sponsor<i style="color: red">*</i></label>
                    <input value="{{ $users[0]->codeunique}}" type="text" class="form-control"  name="codeunique" id="codeunique" data-original-title="Entrer votre code unique" disabled="true"> 
                      
                    </input>
                  </div>
                </div>
          

                <div class="form-group">
                  <label>Nom d'utilisateur <i style="color: red">*</i></label>
                  <input type="text" class="form-control " value="{{ $users[0]->nomuser}}" name="nomuser" id="nomuser" value="{{ old('id') }}" disabled="true">
                  @if($errors->has('nomuser'))
                    <p style="color: red"> {{ $errors->first('nomuser') }}</p>
                  @endif
                </div>

               

                <input type="submit" name="mettreajour" value="METTRE A JOUR" class="btn btn-primary .hor-grd .btn-grd-2 .btn-out-dotted btn-user btn-block" />
                
              </form>
              <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

    <!--/.row-->
</div>
</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
@endsection

@section('jss')

    	<script type="text/javascript">
		
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