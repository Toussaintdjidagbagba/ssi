@extends('layouts.templaterefonteadmin')

@section('css') 
  
@endsection


@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                
                <div class="header">
                    <h2>
                    Vendre CV
                    </h2>
                </div> 
               
                <div class="body">
                    <div class="text-center" id="data">
                  @include('flash::message')
                </div>
                    <form class="user trna" method="post" style="border: 0.5px solid gray; padding: 20px" action="{{ route('transfertadminSCV') }}">
                    {{ csrf_field() }}    

                        <div class="form-group">
                            <div class="col-md-6">
                            <label>Entrez identifiant du destinataire<i style="color: red">*</i></label>
                            <div class="form-line">
                            <input type="number" class="form-control form-control-user ident" name="id">
                            </div>
                            @if($errors->has('id'))
                              <p style="color: red"> {{ $errors->first('id') }}</p>
                            @endif
                            </div>
                        
                            <div class="col-md-6">
                                <label>Entrez le montant<i style="color: red">*</i></label>
                            <div class="form-line">
                            <input type="number" step="0.00001" class="form-control form-control-user mont" name="montant">
                            </div>
                            @if($errors->has('montant'))
                              <p style="color: red"> {{ $errors->first('montant') }}</p>
                            @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>Entrez le code<i style="color: red">*</i></label>
                            <div class="form-line">
                            <input type="number" class="form-control form-control-user otp" name="otp" >
                            </div>
                            @if($errors->has('otp'))
                              <p style="color: red"> {{ $errors->first('otp') }}</p>
                            @endif
                            </div>
                        </div>

                        <div class="form-group">
                          <button class="btn btn-user " >
                            <a href="#" id="code"> Générer code OPT</a>
                          </button>
                        </div>
                        <div class="row clearfix">
                            
                        <div class="col-sm-6">
                        <div class="form-group">
                             <a class="btn btn-user btn-block m-l-15 m-t-15 waves-effect" href="#" style="background: #C0C0C0; color:black" id="bouton">VALIDER</a>
                    
                            <a class="btn btn-user btn-block m-l-15 m-t-15 waves-effect" href="#" style="background: #4f2e14; color:white; display : none" id="boutonT"><b>VENDRE</b></a>
                            
                            
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <a class="btn btn-user btn-block m-l-15 m-t-15 waves-effect" href="#" style="background: #4f2e14; color:white; display : none" id="boutonA">ANNULER</a>
                            
                            
                            </div>
                        </div>
                        </div>
                        <br>
                        <!--button type="submit" class="btn btn-primary m-t-15 waves-effect" id="but">TRANSFERER</button-->
                    </form>
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
              xhr.open("GET", "https://sourcedusuccesinternational.com/genotp-admin", true);
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
    </div>
</section> 

@endsection