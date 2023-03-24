@extends('layouts.template_client')
@section('css') 
  <!-- Custom fonts for this template -->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('css/clean-blog.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/mlm.css')}}" rel="stylesheet">
  
@endsection
@section('content')
  <div class="row">
        
      <div class="col-lg-12">
        <h3 class="page-header">Transfert d'un compte à l'autre</h3>
        <ol class="breadcrumb">
          <li><i class="fa fa-home"></i></li>
        </ol>
        <br>
      </div>
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
                  <form class="user" method="post" action="{{ route('transfertS') }}">
                    {{ csrf_field() }}
                     
                    <div class="form-group">
                      <input type="number" class="form-control form-control-user" required placeholder="Entrez identifiant du destinataire" name="id">
                      @if($errors->has('id'))
                        <p style="color: red"> {{ $errors->first('id') }}</p>
                      @endif
                    </div>

                     <div class="form-group">
                      <input type="number" step="0.00001" class="form-control form-control-user"  placeholder="Entrez le montant" name="montant" required>
                      @if($errors->has('montant'))
                        <p style="color: red"> {{ $errors->first('montant') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <input type="number" class="form-control form-control-user"  placeholder="Entrez le code" name="otp" required>
                      @if($errors->has('otp'))
                        <p style="color: red"> {{ $errors->first('otp') }}</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <button class="btn btn-user" id="but">
                        <a href="#" id="code"> Générer code OPT</a>
                      </button>
                    </div>
                    
                    <button type="submit" class="btn btn-user btn-block" id="but">
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
@endsection('content')