<?php ini_set('max_execution_time', 120000); //12000 seconds = 20 minutes ?>
@extends('layouts.template')

@section('stylesheet')

<style type="text/css">
@media only screen and (min-width: 760px) {
  #log_image{
      height: 200px; width: 420px; margin-top: -55px;
  }
}

@media only screen and (max-width: 760px) {
  #log_image{
      height: 150px; width: 300px; margin-top: -55px; margin-left: -40px;
  }
}

    .at-itemt {
      
      animation-name: shutter-in-top;
      animation-duration: 6s;
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


@section('header')
  <header class="masthead" style="background-image: url('img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>La Source du Succès International</h2>
            <span class="subheading">Effectuer le payement</span>
          </div>
        </div>
      </div>
    </div> 
  </header> 
@endsection

@section('content')

  <div class="container">

    <div class=" my-5">
      <div class="card-body p-0">
        <div class="progress">
            <div class=" progress-bar-striped progress-bar-animated" role="progressbar" style="width: 60%" id="progres" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row" style="background-color: rgba(255, 255, 255, 0.5);">
          <div class="col-lg-2">
            
          </div>
          <div class="col-xl-8 col-lg-8 col-md-7 col-sm-5 col-xs-5">
            <div class="p-5">
              <!-- Titre -->
              <div class="text-center">
                  <img src="img/app_ssi.png" id="log_image">
                  
              </div>
              <div class="text-center">
                @include('flash::message')
              </div>

              <!-- Formulaire de création de compte -->
               <form class="user at-itemt" method="post" action="{{ route('validerpayementT') }}"> 
              
                {{ csrf_field() }}
                <br>
                <input type="hidden" name="idres" value="{{ $idres }}">
                
                <div class="form-group">
                    <label>Code d'approbation <i style="color: red">*</i></label>
                    <input type="text" class="form-control" name="parraincode" id="parrain" placeholder="Code d'approbation" data-original-title="Code d'approbation" /> 
                </div>

                                        
                    <button type="submit" class="btn btn-user btn-block" id="but">
                      <b>VALIDER</b>
                    </button>               
            </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

@endsection('content')
