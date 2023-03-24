@extends('layouts.template')

@section('content')

  <section id="services" >
    <div class="container">
      <div class="heading wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
              <div class="row">
                <div class="text-center col-sm-10 col-sm-offset-1">
                  <center> 
                    <h2  style="color: blue; font-size: xx-large;">À PROPOS DE NOUS</h2>
                  
                    <img src="img/bas1.png" style="width: 25%; height: 25%; margin-top: -50px;" >
                  </center>
                  <p  style="font-size: large;">
                    La Source du Succès International est une plate-forme basée sur des formations en éducation financière, entrepreneuriat, E-commerce et des œuvres sociales. Elle est ouverte à toute personne ayant la volonté d'entreprendre; de réaliser ses projets, ses rêves et atteindre ses objectifs de vie. Elle dispose également des services comme le payement des factures d'électricité , d'eau , réabonnement CANAL+ , achat de bien meuble ou immobilier etc.
                  </p>
                </div>
              </div> 
      </div>
  </div>
  </section>
@endsection

@section('stylesheet')

  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <style type="text/css">

    .img-galerie{
      text-align: center;
      width: 100%
    }
  </style>

@endsection
