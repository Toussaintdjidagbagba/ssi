@extends('layouts.templaterefonteadmin')

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    ENVOYER RECU TRUST WALLET
                    </h2>
                </div> 
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="body">

              <!-- Formulaire de création de compte -->
              <form class="user" method="post" action="{{ route('trustS') }}"> 
                {{ csrf_field() }}
              
                <div class="form-group row">
                  <div class="col-sm-12">
                  <label>Référence du recu TRUST WALLET SSI : </label>
                  <div class="form-line">
                  <input type="text" class="form-control" name="reff" value="{{ $demande->reff }}" disabled="true" >
				          <input type="hidden" class="form-control" name="reff" value="{{ $demande->reff }}" >
                </div>
                </div>
                </div>


                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Motif :</label>
                    <div class="form-line">
					           <input type="text" class="form-control" name="intituler" value="{{ $demande->intituler }}" disabled="true">
                   </div>
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Lien :</label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="lien" value="{{ $demande->lien }}" disabled="true">
                  </div>
                  </div>
                </div>

				        <div class="form-group row">
                    <div class="col-sm-12">
                    <label>Montant :</label>
                    <div class="form-line">
                    <input type="text" class="form-control " name="montant" value="{{ $demande->montant }}" disabled="true">
                  </div>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary m-t-15 waves-effect" name="ENVOYER RECU" value="ENVOYER RECU" class="btn btn-user btn-block" id="but">ENVOYER RECU</button>
                
              </form>
              </div>
            </div>
        </div>
      </div>       

    </div>
</section> 

@endsection