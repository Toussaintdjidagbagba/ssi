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
            <div class="row at-itemb" style="background-color: rgba(255, 255, 255, 0.5);">
              <div class="col-xl-2 col-lg-2 col-md-2 col-sm-1 col-xs-1">
                <img src="img/f1.gif" id="fel">  
            </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-xl-offset-2 col-lg-offset-2 col-md-offset-2" >
                <div class="form-group">
                </div>
                <div class="p-5" >
                    <center style="font-size : 18px; font-weight: bold;"> <br>
                    
                    <b> {{ $Pack }} <br> Félicitation à vous {{ $nom }} {{ $prenom }}. <br>
                    <div class="text-center">
                      <img src="img/validation.png" id="log_vali">
                    </div>
                    Bienvenue à la Source du Succès International! <br> La plateforme qui faire de vous un homme ou une femme de Succès et s'occupe de votre bien être. <br>
						<br> </b>
						
					<b style="text-align : left;"> Information personnel : </b>  <br> <br>
                    </center>
                    <center style="font-size : 12px">
                    <table style="border: 1px solid white;">
						<tr style="border: 1px solid white;">
							<td style="border: 1px solid white; text-align: left; width: 50%">
								<b> Identifiant :<br> <br>

								Nom d'utilisateur : <br> <br>

								Nom du sponsor : </b>
								<br>
								
							</td>
							<td style="border: 1px solid white; text-align: right; width: 50%">
								<i> <b>
									{{ $id }} <br><br>

									{{ $nomuser }} <br> <br>

									{{ $sponsor }} <br> </b>
									
								</i>
								
							</td>
						</tr>
					</table>
                  </center>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ route('seconnecter')}}" id="bouton" style="color: #fff">Se connecter à présent.</a>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2">
                
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
</section>
@endsection

@section('stylesheet')

<style type="text/css">

@media only screen and (min-width: 760px) {
  #log_image{
      background-image: url('img/logo.png');
      height: 500px; width: 700px; margin-left : -290px;
  }
  
  #log_ima{
      height: 0px; width: 0px; 
  }
}

@media only screen and (min-width: 760px) {
  
}

@media only screen and (max-width: 760px) {
  #fel{
      height: 0px; width: 0px; 
  }
  #log_ima{
      height: 300px; width: 400px; margin-left : -50px;
  }
  #felet{
      margin-top: -120px;
  }
}

@media only screen and (min-width: 760px) {
    #log_vali{
        height: 50px; width: 50px;
    }
}
</style>

@endsection 
