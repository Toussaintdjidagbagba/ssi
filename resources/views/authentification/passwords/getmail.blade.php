@extends('layouts.template')

@section('content')

<section id="services" >
  <div class="container">

    
    <!-- Outer Row -->
    <div class="row justify-content-center" >
      <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt">
        <div class="text-center">
          @include('flash::message')
        </div>
      </div>

      <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt" >

        <div class=" my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row" >
              <div class="col-lg-2">
                
              </div>
              <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 " style="background-color: rgba(255, 255, 255, 0.5);">
                <div class="p-5">
                  <div class="text-center" style="margin-top: 20px;">
                    <p style="color: #4f2e14; font-size: large;"> <b>Réinitilisation de mot de passe</b> </p> <br>
                     
                  </div>
                  <div class="text-center" id="message">
                    
                  </div>
                  
                  <form class="user at-itemt" name="user" method="post" action="{{ route('fogotR') }}">
                    {{ csrf_field() }}
                    <div class="form-group ">
                      <input  type="text" class="form-control mail" id="input" aria-describedby="emailHelp" required placeholder="Entrer votre pseudo " name="mail">
                      
                    </div>
                     
                    <div class="form-group ">
                      <input type="text" class="form-control pseudo " id="input" required placeholder="Entrer votre identifiant" name="codeperso">
                      
                    </div>
                    
                    <div class="form-group " >
                      <input type="text" class="form-control otp" id="input" placeholder="Entrer le code" name="otp" style="display : none">
                    </div>
                    
                    <div class="form-group " >
                      <input type="password" class="form-control mdp1" id="input" placeholder="Entrer un nouveau mot de passe" name="mdp" style="display : none">
                    </div>
                    
                    <div class="form-group " >
                      <input type="password" class="form-control mdp2" id="input" placeholder="Valider à nouveau le mot de passe" name="mdpv" style="display : none">
                    </div>
                    
                      <br>
                   
                    
                    <a class="btn btn-user btn-block" href="#" style="background: #4f2e14; color:white" id="bouton">VALIDER</a>
                    
                    
                    <a class="btn btn-user btn-block" href="#" style="background: #4f2e14; color:white; display : none" id="boutonC">CONFIRMER</a>
                    
                    <a class="btn btn-user btn-block" href="#" style="background: #4f2e14; color:white; display : none" id="boutonA">ANNULER</a>
                    
                    <a class="btn btn-user btn-block" href="#" style="background: #4f2e14; color:white; display : none" id="boutonR">REINITIALISER</a>
                    
                    <a class="btn btn-user btn-block" href="{{route('seconnecter')}}" style="background: #4f2e14; color:white; display : none" id="boutonB">Retour à la connexion</a>
                    
                  </form> 
                  <hr>
                 <div class="text-center">
                    <a class="small" href="{{route('inscription')}}" style="color: #4f2e14;">Créer un compte!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{route('seconnecter')}}" style="color: #4f2e14;">Je me rappel!</a>
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
          <script>    
            
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
            
            function readData(sData) {
              //alert(sData);
              var oSelect = document.getElementById("data");
              
              oSelect.innerHTML = '<div class="alert alert-info" role="alert">'+sData+'</div>';
            }
            
            var y = document.getElementById("bouton");
            y.addEventListener("click", function () {
                
                
              // 
              var mail = document.querySelector("input.mail").value;
              var psudo = document.querySelector("input.pseudo").value;
              
              console.log(mail);
              document.getElementById("message").innerHTML = "En cours de traitement..";
              document.querySelector("input.mail").style.display="none";
              document.querySelector("input.pseudo").style.display="none";
              document.getElementById("bouton").style.display="none";
              
              var xhr = getXMLHttpRequest(); 
              xhr.open("GET", "{{route('genotpreini')}}?pseudo="+mail+"&identi="+psudo, true);
              xhr.send(null);
              xhr.onreadystatechange = function() {
                  if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                      //readData(xhr.responseText); 
                      console.log(xhr.responseText);
                      
                      if(xhr.responseText == 1){
                            document.getElementById("message").innerHTML = "Aucun compte n'existe avec ces informations renseigner. ";
                            document.getElementById("boutonA").style.display="block";
                      }else{
                          if(xhr.responseText == 2){
                                document.getElementById("message").innerHTML = "Aucun email n'est liée à ces informations renseigner. ";
                                document.getElementById("boutonA").style.display="block";
                          }else{
                              document.getElementById("message").innerHTML = xhr.responseText;
                              document.getElementById("boutonC").style.display="block";
                              document.getElementById("boutonA").style.display="block";
                              document.querySelector("input.otp").style.display="block";
                          }
                      }
                  }
              };
            }, true);             
            
            var x = document.getElementById("boutonA");
            x.addEventListener("click", function () {
               
              document.getElementById("message").innerHTML = "";
              document.querySelector("input.mail").style.display="block";
              document.querySelector("input.pseudo").style.display="block";
              document.getElementById("bouton").style.display="block";
              document.getElementById("boutonA").style.display="none";
              document.getElementById("boutonC").style.display="none";
              document.querySelector("input.otp").style.display="none";
            }, true);   
            
            var z = document.getElementById("boutonC");
            z.addEventListener("click", function () {
               
               var otp = document.querySelector("input.otp").value;
               
              var xhr = getXMLHttpRequest(); 
              xhr.open("GET", "{{route('setotpreini')}}?otp="+otp, true);
              xhr.send(null);
              xhr.onreadystatechange = function() {
                  if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                      
                      if(xhr.responseText == 0){
                              document.getElementById("message").innerHTML = "";
                              document.querySelector("input.mail").style.display="none";
                              document.querySelector("input.pseudo").style.display="none";
                              document.getElementById("bouton").style.display="none";
                              document.getElementById("boutonA").style.display="none";
                              document.getElementById("boutonC").style.display="none";
                              document.querySelector("input.otp").style.display="none";
                              document.querySelector("input.mdp1").style.display="block";
                              document.querySelector("input.mdp2").style.display="block";
                              document.getElementById("boutonR").style.display="block";
                      }else{
                          if(xhr.responseText == 4){
                                document.getElementById("message").innerHTML = "OTP Incorrecte. Veuillez réessayer. ";
                                document.getElementById("boutonA").style.display="block";
                          }
                      }
                  }
              };
              
              
              
            }, true);    
            
            var p = document.getElementById("boutonR");
            p.addEventListener("click", function () {
               
              var pseudo = document.querySelector("input.pseudo").value;
              var mdp = document.querySelector("input.mdp1").value;
              var mdp2 = document.querySelector("input.mdp2").value;
              
              if(mdp != mdp2){
                   document.getElementById("message").innerHTML = "Les deux mot de passe ne sont pas identique.  Veuillez réessayer. ";
                   document.getElementById("boutonA").style.display="block";
              }else{
                  var xhr = getXMLHttpRequest(); 
                  xhr.open("GET", "{{route('setreini')}}?psdo="+pseudo+"&mdp="+mdp, true);
                  xhr.send(null);
                  xhr.onreadystatechange = function() {
                      if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                          
                          if(xhr.responseText == 0){
                                  document.getElementById("message").innerHTML = "Réinitialisation effectué avec succès. <br>Veuillez-vous connecté à présent.";
                                  document.querySelector("input.mdp1").style.display="none";
                                  document.querySelector("input.mdp2").style.display="none";
                                  document.getElementById("boutonR").style.display="none";
                                  document.getElementById("boutonB").style.display="block";
                          }else{
                              if(xhr.responseText == 4){
                                    document.getElementById("message").innerHTML = "Erreur Veuillez réessayer. ";
                                    document.getElementById("boutonA").style.display="block";
                              }
                          }
                      }
                  };
              }
              
              
            }, true);    
            
            
            /*
            var y = document.getElementById("confri");
            y.addEventListener("click", function () {
              var identi = document.getElementById("identif").value;
              var xhr = getXMLHttpRequest(); 
              xhr.open("GET", "/verifdestinataire-"+identi, true);
              xhr.send(null);
              xhr.onreadystatechange = function() {
                  if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                      readData(xhr.responseText); // Données textuelles récupérées
                  }
              };
            }, true);        */     
            
            
          </script>
      </div>

    </div>
    
  </div>
</section>
@endsection('content')

@section('stylesheet')




<style type="text/css">
  @media only screen and (min-width: 760px) {
    #log_image{
        height: 150px; width: 300px; margin-top: -55px
    }
  }

  @media only screen and (max-width: 760px) {
    #log_image{
        height: 150px; width: 300px; margin-top: -55px; margin-left: -40px;
    }
  }

    .at-itemt {
      
      animation-name: shutter-in-top;
      animation-duration: 2s;
      animation-timing-function: ease;
      animation-delay: 0s;
      animation-iteration-count: 1;
      animation-direction: normal;
      animation-fill-mode: none;
    }
    @keyframes shutter-in-top {
      0%{
        -webkit-transform: rotateX(-100deg);
        transform: rotateX(-100deg);
        -webkit-transform-origin: top;
        transform-origin: top;
        opacity: 0;
      }
      100%{
        -webkit-transform: rotateX(0deg);
        transform: rotateX(0deg);
        -webkit-transform-origin: top;
        transform-origin: top;
        opacity: 1;
      }
    }


</style>

@endsection 

