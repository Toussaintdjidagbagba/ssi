@extends('layouts.template')


@section('content')
<section id="services">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt">
        <div class=" my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-2">
                
              </div>
              <div class="col-lg-8">
                <div class="form-group">
                </div>
                <div class="p-5">
                  <div class="text-center">
                      <img src="img/vali.png" style="height: 200px; width: 200px">
                  </div>
                  <center>
                    <h2>ECHEC!!!</h2>
                    <h3>Le solde de votre parrain est insuffisant. Veuillez le contacté pour en savoir davantage. Merci!!!</h3>
                    <h5>
                    <p style="color: red; text-align: justify;">
                      Consulter votre boite mail pour vous assuré de la création effective de(s) compte(s) . 
                      Si la création n'est pas effectuée veuillez consulter votre compte et/ou nous contacté mentionnant le dernier compte créé avec succès en plus de votre identifiant, votre adresse mail et le pseudo . 
                    </p>
                    </h5>
                  </center>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ route('seconnecter')}}" id="bouton" style="color:#fff">Se connecter à présent.</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection('content')