@extends('layouts.template')

@section('content')
	<section id="services" >
	<nav class="navbar">
    @forelse($images as $image)
    
        <div class="articlepdf" >
         <i> Thème : </i> <b>{{ $image->image}}</b> <br> 
         
         <p style="text-align: left; margin-left: 20px"> <b><u> Adresse :</u></b> {{ $image->lieu }}<br></p>
         
         <p style="text-align: left; margin-left: 20px"> <b><u> Date et heure : </u></b> {{ $image->date }} à {{ $image->heure }}<br></p>
         <i>Administrateur</i> <br>
         {{ $image->description }}
          <div class="articledescription" style="text-align: left; margin-left: 15px; padding-bottom: 15px">
          </div>
        </div>
    @empty
      <div class="img-galerie" style="font-size: x-large;">
          <p style="font-size: xx-large;"> Info!!</p> <br> <br> Pas d'évènement prévu. <br>  
      </div>
    @endforelse

	</nav>
   </section>
@endsection


@section('stylesheet')

  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <style type="text/css">
    .articlepdf{
      text-align: center;
      width: 400px;
      max-width: 250px;
      border-radius: 3px; 
      max-height: 550px;
      
      margin: 5px;
      padding: 5px;
    }

    .img-galerie{
      text-align: center;
      width: 100%
    }
  </style>

@endsection

