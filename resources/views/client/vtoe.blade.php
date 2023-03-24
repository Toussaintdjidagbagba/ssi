@extends('layouts.templaterefonte')

@section('content')
  
<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-body">
                                      <div class="row"> 
                                        <div class="col-lg-12">
                                          <h3 class="page-header">Transfert du compte commission sur vente vers compte gain virtuel</h3>
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
                  <form class="user" method="post" action="{{ route('vteS') }}">
                    {{ csrf_field() }}
                     
                     <div class="form-group">
                      <input type="number" step="0.00001" class="form-control form-control-user"  placeholder="Entrez le montant" name="montant">
                      @if($errors->has('montant'))
                        <p style="color: red"> {{ $errors->first('montant') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <input type="number" class="form-control form-control-user"  placeholder="Entrez le code" name="otp">
                      @if($errors->has('otp'))
                        <p style="color: red"> {{ $errors->first('otp') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <button class="btn btn-info .hor-grd .btn-grd-* .btn-out-dotted btn-user" style="background-color: #c18556">
                        <a href="#" id="code"> Générer code OPT</a>
                      </button>
                    </div>
                    
                    <button type="submit" class="btn btn-primary .hor-grd .btn-grd-2 .btn-out-dotted btn-user btn-block">
                      <b>TRANSFERER</b>
                    </button>
                  
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
            
            
          </script>

          </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
@endsection('content')