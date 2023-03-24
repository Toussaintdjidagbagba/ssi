@extends('layouts.template')


@section('content')
	
  <section id="services" >
	<nav class="navbar">
    @forelse($images as $image)
    
        <div class="articlepdf" >
          {{ $image->image}} <br> 
          <?php 
            echo "<img src='storage/$image->path' style='width : 100%' />";  
          ?> 
        </div>
    @empty
      <div class="img-galerie" style="font-size: x-large;">
          <p style="font-size: xx-large;"> Info!!</p> <br> <br> Pas d'image disponible dans la galerie. <br>  
      </div>
    @endforelse

	</nav>
  </section>
@endsection

@section('stylesheet')

  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <style type="text/css">
    .articlepdf{
      background-color: rgb(255,255,255);
      text-align: center;
      width: 300px;
      max-width: 250px;
      border-radius: 3px; 
      max-height: 450px;
      margin: 5px;
      padding: 5px;
    }

    .img-galerie{
      text-align: center;
      width: 100%
    }
  </style>

@endsection
