@extends('layouts.template')

@section('header')
  <header class="masthead" style="background-image: url('img/logg.png')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>La Source du Succès International</h2>
            <div class="subheading">Boutique SSI</div>
          </div>
        </div>
      </div>
    </div> 
  </header>
@endsection

@section('stylesheet')

  <link href="{{asset('vendorr/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">


  <style type="text/css">
  .wrapper {
  display: flex;
  justify-content: center;
}

.cta {
    display: flex;
    padding: 2px 18px;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-size: 17px;
    color: white;
    background: #6225E6;
    transition: 1s;
    box-shadow: 6px 6px 0 black;
    transform: skewX(-15deg);
}

.cta:focus {
   outline: none; 
}

.cta:hover {
    transition: 0.5s;
    box-shadow: 10px 10px 0 #FBC638;
}

.cta span:nth-child(2) {
    transition: 0.5s;
    margin-right: 0px;
}

.cta:hover  span:nth-child(2) {
    transition: 0.5s;
    margin-right: 45px;
}

  span {
    transform: skewX(15deg) 
  }

  span:nth-child(2) {
    width: 14px;
    margin-left: 5px;
    position: relative;
    top: 2%;
  }
  
/**************SVG****************/

path.one {
    transition: 0.4s;
    transform: translateX(-60%);
}

path.two {
    transition: 0.5s;
    transform: translateX(-30%);
}

.cta:hover path.three {
    animation: color_anim 1s infinite 0.2s;
}

.cta:hover path.one {
    transform: translateX(0%);
    animation: color_anim 1s infinite 0.6s;
}

.cta:hover path.two {
    transform: translateX(0%);
    animation: color_anim 1s infinite 0.4s;
}

/* SVG animations */

@keyframes color_anim {
    0% {
        fill: white;
    }
    50% {
        fill: #FBC638;
    }
    100% {
        fill: white;
    }
}
    .articlepdf{
      background-color: #ffffff;
      border-radius: 20%;
      
      
      
  
	     -moz-background-clip: border;     /* Firefox 3.6 */
  	-webkit-background-clip: border;  /* Safari 4? Chrome 6? */
  	background-clip: border-box;      /* Firefox 4, Safari 5, Opera 10, IE 9 */
				
	  -moz-background-clip: padding;     /* Firefox 3.6 */
	  -webkit-background-clip: padding;  /* Safari 4? Chrome 6? */
	  background-clip: padding-box;      /* Firefox 4, Safari 5, Opera 10, IE 9 */
					
	  -moz-background-clip: content;     /* Firefox 3.6 */
	  -webkit-background-clip: content;  /* Safari 4? Chrome 6? */
	  background-clip: content-box;      /* Firefox 4, Safari 5, Opera 10, IE 9 */
  
     border: 20px solid rgba(0, 0, 255, 0.3);
      text-align: center;
      width: 350px;
      max-width: 300px;
      border-radius: 3px; 
      max-height: 450px;
      height: 400px;
      margin: 5px;
      padding: 5px;
    }

    .articledescription{
      max-height: 100px;
      word-wrap: break-word;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    

  </style>

@endsection


@section('content')
  <div class="container"><div class="row"><div class="col-lg-12">
    <hr>
    <div class="col-lg-12">
          <center><h3 style="color: blue">BOUTIQUE DE LA SSI</h3></center>
          <img src="img/bas1.png" class="bas" style="width: 32%; height: 32%; margin-left: 33%; margin-top: -15px" ></div>
        </div>
	<nav class="navbar">
    @forelse($cours as $cour)
    
    	<div class="articlepdf " >
         <b> {{ $cour->titre}}</b> <br> 
         <a href="article-{{$cour->id}}"> <img src="img/{{$cour->path}}" class="article_img"> </a> <br> <br>
         <p style="text-align: left; margin-left: 20px">Prix : {{ $cour->prix }} $ SSI<br></p>
         
        <div class="articledescription" style="text-align: left; margin-left: 15px; padding-bottom: 15px"> <br> <div class="wrapper">
  <a class="cta" href="article-{{$cour->id}}">
    <span >PAYER</span>
    
  </a>
</div>
          </div>
          </div>
    @empty
      <div class="articlepdf ">
          Bientôt disponible <br> 
         <a href="#"> <img src="img/ID-100348894.jpg" class="article_img"> </a> <br> <br>
         <p style="text-align: left; margin-left: 20px">Prix : 0 $ SSI<br></p>
         
        <div class="articledescription" style="text-align: left; margin-left: 15px; padding-bottom: 15px"> Pas de description
          </div>
          </div>
    @endforelse
  

	</nav> 
@endsection