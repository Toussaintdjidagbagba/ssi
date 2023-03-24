@extends('layouts.templaterefonte')
@section('content')
<div class="pcoded-content">
     <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row">    
                                        <div class="col-lg-12">
                                          <h3 class="page-header">Vendre (Gain Espèce)</h3>
                                          
                                        </div>
  
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        
      </div>

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-2">
                
              </div>
              <div class="col-lg-8"> 
                <div class="p-5">
                  <div class="text-center" id="data">
                    @include('flash::message')
                  </div>
                  <br>
                  <form class="user trna" method="post" action="{{ route('transfertS') }}">
                    {{ csrf_field() }}
                     
                    <div class="form-group">
                      <input type="number" class="form-control form-control-user ident" id="identif" required placeholder="Entrez identifiant du destinataire" name="id">
                      @if($errors->has('id'))
                        <p style="color: red"> {{ $errors->first('id') }}</p>
                      @endif
                    </div>

                     <div class="form-group">
                      <input type="number" step="0.00001" class="form-control form-control-user mont" placeholder="Entrez le montant" name="montant" required>
                      @if($errors->has('montant'))
                        <p style="color: red"> {{ $errors->first('montant') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <input type="number" class="form-control form-control-user otp"  placeholder="Entrez le code" name="otp" required>
                      @if($errors->has('otp'))
                        <p style="color: red"> {{ $errors->first('otp') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <button class="btn btn-user" id="but">
                        <a href="#" id="code"> Générer code OPT</a>
                      </button>
                    </div>
                    
                    <a class="btn btn-user btn-block" href="#" style="background: #C0C0C0; color:black" id="bouton">VALIDER</a>
                    
                    <a class="btn btn-user btn-block" href="#" style="background: #4f2e14; color:white; display : none" id="boutonT"><b>VENDRE</b></a>
                    
                    <a class="btn btn-user btn-block" href="#" style="background: #4f2e14; color:white; display : none" id="boutonA">ANNULER</a>
                    
                  </form>
                 
                </div>
              </div>
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
            
            var y = document.getElementById("code");
            y.addEventListener("click", function () {
              //console.log("Mois ");
              var xhr = getXMLHttpRequest(); 
              xhr.open("GET", "{{route('genotp')}}", true);
              xhr.send(null);
              xhr.onreadystatechange = function() {
                  if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                      readData(xhr.responseText); // Données textuelles récupérées
                  }
              };
            }, true);             
            
            
            // VALIDER
            var x = document.getElementById("bouton");
            x.addEventListener("click", function () {
                
              // 
              var ident = document.querySelector("input.ident").value;
              var mont = document.querySelector("input.mont").value;
              var otp = document.querySelector("input.otp").value;
              
              console.log(ident);
              
              if(ident == "" || (mont == "" || otp == ""))
                document.getElementById("data").innerHTML = "<b style='color:red'>Veuillez remplir tous les champs..</b>";
              else{
                  
              
                  document.getElementById("data").innerHTML = "En cours de traitement..";
                  
                  //document.querySelector("input.ident").style.display="none";
                  //document.querySelector("input.mont").style.display="none";
                  document.getElementById("bouton").style.display="none";
                  
                  var xhr = getXMLHttpRequest(); 
                  xhr.open("GET", "{{route('setcheckpseudo')}}?pseudo="+ident, true);
                  xhr.send(null);
                  xhr.onreadystatechange = function() {
                      if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                          //readData(xhr.responseText); 
                          //console.log(xhr.responseText);
                          
                          if(xhr.responseText == 1){
                                document.getElementById("data").innerHTML = "Aucun identifiant n'est saisir. ";
                                document.getElementById("boutonA").style.display="block";
                          }else{
                              if(xhr.responseText == 2){
                                    document.getElementById("data").innerHTML = "L'identifiant  n'existe pas. ";
                                    document.getElementById("boutonA").style.display="block";
                              }else{
                                  document.getElementById("data").innerHTML = xhr.responseText;
                                  document.getElementById("boutonT").style.display="block";
                                  document.getElementById("boutonA").style.display="block";
                              }
                          }
                      }
                  };
              }
            }, true); 
            
            // Annuler
            var ax = document.getElementById("boutonA");
            ax.addEventListener("click", function () {
               
              document.getElementById("data").innerHTML = "";
              document.querySelector("input.ident").style.display="block";
              document.querySelector("input.mont").style.display="block";
              document.getElementById("bouton").style.display="block";
              document.getElementById("boutonA").style.display="none";
              document.getElementById("boutonT").style.display="none";
              var ident = document.querySelector("input.ident").value = "";
              var mont = document.querySelector("input.mont").value = "";
              var otp = document.querySelector("input.otp").value = "";
            }, true); 
            
            
            // Confirmer
            var z = document.getElementById("boutonT");
            z.addEventListener("click", function () {
               
              document.querySelector("form.trna").submit();
             
            }, true);    
            
          </script>
@endsection('content')