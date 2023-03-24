@extends('layouts.templatetest')

@section('header')

  <header id="header" class="masthead" style="background-image: url('img/logg.png')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>La Source du Succès International</h2>
            <div class="subheading">Accueil</div>
          </div>
        </div>
      </div>
    </div> 
  </header>
@endsection

@section('js')

        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="{{asset('design/js/mdb.min.js')}}"></script>

        <!-- Wow js -->
        <script type="text/javascript" src="{{asset('design/js/wow.min.js')}}"></script>

        
        <!-- accordion js -->
        <script type="text/javascript" src="{{asset('design/js/accordion.js')}}"></script>
        
        
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="{{asset('design/js/tether.min.js')}}"></script>

        <!-- Mixitup js -->
        <script type="text/javascript" src="{{asset('design/js/jquery.mixitup.min.js')}}"></script>

        <!-- Magnific-popup js -->
        <script type="text/javascript" src="{{asset('design/js/jquery.magnific-popup.js')}}"></script>
        
        
        <script type="text/javascript" src="{{asset('design/js/main.js')}}"></script>
        
        <script type="text/javascript" src="{{asset('design/js/jquery-2.2.3.min.js')}}"></script>


        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="{{asset('design/js/materialize.js')}}"></script>

        <script type="text/javascript" src="{{asset('design/js/plugins.js')}}"></script>

        
        <script>
            $(".button-collapse").sideNav();
        </script>

        <!-- wow js active -->
        <script type="text/javascript">
            new WOW().init();
        </script> 
        
	<script type="text/javascript">
		window.onload = function () {
		    var header = document.getElementById('header');
		    var pictures = new Array('https://sourcedusuccesinternational.com/img/logg.png'
		    'https://newevolutiondesigns.com/images/freebies/winter-facebook-cover-preview-13.jpg');
		    var numPics = pictures.length;
		    if (document.images) {
		        var chosenPic = Math.floor((Math.random() * numPics));
		        header.style.background = 'url(' + pictures[chosenPic] + ')';
		    }
		}
	</script>
@endsection

@section('stylesheet')

  <link href="{{asset('vendorr/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  
    <link href="{{asset('design/css/mdb.min.css')}}" rel="stylesheet">
    <link href="{{asset('design/css/style.css')}}" rel="stylesheet">
    
    <link href="{{asset('design/css/responsive.css')}}" rel="stylesheet">


  <style type="text/css">
  
  @media only screen and (max-width: 760px) {
      #pet{
          width: 100px;
          height: 85px;
          text-align: center;
          
      }
      
      #pte{
          width: 100px;
          height: 85px;
          text-align: center;
          font-size: 10px;
          margin-top:-30px;
      }
    }
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

    
<section id="about" class="about">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="main_about_area">
                            <div class="head_title center m-y-3 wow fadeInUp">
                                <h2 style="text-align:center; color: blue">BIENVENUE À LA SOURCE DU SUCCÈS INTERNATIONAL</h2>
                                 <img src="img/bas2.png" class="bas" style="width: 35%; height: 35%; margin-left: 32%; margin-top: -15px" >
                            </div>

                            <div class="main_about_content">
                                <div class="row">
                                    <div class="col-md-1">
                                            
                                    </div>
                                    <div class="col-md-10">

                                        <div class="main_accordion wow fadeInLeft" data-wow-duration="2s" data-wow-delay="0.3s" data-wow-offset="0">

                                            <div class="single_accordion">
                                                <button class="accordion active">MISSION</button>
                                                <div class="panel show" >
                                                    <p style="text-align:justify; ">LA PLATE-FORME QUI A POUR MISSION DE VOUS SERVIR, TRANSFORMER VOTRE VIE, VOUS AIDER À LUTTER CONTRE LE CHOMAGE, 
                                                    LA PAUVRETÉ, VOUS CONDUIRE A LA RÉALISATION DE VOS PROJETS DE VIE, VOUS PROPULSER AU SOMMET ET S'OCCUPER DE VOTRE BIEN ÊTRE. 
                                                    ELLE MET À LA DISPOSITION DE SES MEMBRES DES FORMATIONS EN ÉDUCATION FINANCIÈRE, 
                                                    DÉVELOPPEMENT PERSONNEL, SÉCURITÉ ALIMENTAIRE ET FINANCIÈRE AFIN DE LES AMENER À DEVENIR UNE AIDE POUR LA SOCIÉTÉ.</p>
                                                </div>
                                            </div>
                                            
                                            <div class="single_accordion">
                                                <button class="accordion">À PROPOS DE NOUS</button>
                                                <div class="panel show">
                                                    <p style="text-align:justify; ">La Source du Succès International est une plate-forme basée sur des formations en éducation financière, entrepreneuriat, E-commerce et des œuvres sociales. 
                                                    Elle est ouverte à toute personne ayant la volonté d'entreprendre; de réaliser ses projets, ses rêves et atteindre ses objectifs de vie. 
                                                    Elle dispose également des services comme le payement des factures d'électricité, d'eau, réabonnement CANAL+, achat de bien meuble ou immobilier etc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <br />
        </section><!-- End of About Section-->

  </div>

  <div class="container"><div class="row"><div class="col-lg-12">
    
    <div class="col-lg-12">
        <div class="head_title center m-y-3 wow fadeInUp">
          <center><h2 style="color: blue">LES FORMATIONS DISPONIBLES</h2></center>
          <img src="img/bas1.png" class="bas" style="width: 32%; height: 32%; margin-left: 33%; margin-top: -15px" ></div>
        </div>
	<nav class="navbar">
          
    <div class="articlepdf " >
         <b> FORMATION EN EDUCATION PHYSIQUE</b> <br> 
         <a href="#"> <img src="img/health.jpg" class="article_img"> </a> <br> 
         <b><p style=" font-size: 12px ">  Une formation qui vous guarantit SANTÉ ET RICHESSE <br> <i style="font-size: 12px; text-align:left; margin-left: 10px;">Coût d'adhésion : 10 $ SSI</i> </p>
         </b>
        <div class="articledescription" style="text-align: left; margin-top: -23px; margin-left: 15px; padding-bottom: 15px"> <br> <div class="wrapper">
  <a class="cta" href="{{ route('healthform') }}">
    <span >S'inscrire</span>
    <span>
      <svg width="36px" height="16px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
        </g>
      </svg>
    </span> 
  </a>
</div>
          </div>
          </div>
          
           
    <div class="articlepdf " >
         <b> Produit cosmétique et de <br> santé </b> <br> 
         <a href="#"> <img src="img/longrich.jpg" class="article_img"> </a> <br> <br>
         <b><p style="text-align: left; margin-left: 20px; font-size:12px"> <i>Coût d'adhésion : 50 $ SSI</i> <br></p></b>
         
        <div class="articledescription" style="text-align: left; margin-top: -23px; margin-left: 15px; padding-bottom: 15px"> <br>
        	<div class="wrapper">
  <a class="cta" href="{{ route('longrichform') }}">
    <span >S'inscrire</span>
    <span>
      <svg width="36px" height="16px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
          <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
        </g>
      </svg>
    </span> 
  </a>
</div>
          </div>
          </div>
          
    </div></div></div>


	</nav>

  <br><br>

        <div class="head_title center m-y-3 wow fadeInUp">
         <center><h2 style="color: blue">LES SERVICES DISPONIBLES</h2></center><br><br>
        </div>
        
        <nav class="navbar col-lg-12" style="background-image: url('img/fond.jpg'); padding-top: 11px; color: #fff;  
        background-repeat: repeat; border-radius: 0px 0px 20px 20px; background-size: contain; object-fit: cover; width: 100%; ">
        
        <div >
         <a href="{{ route('canalplus') }}"> <img src="img/canal.jpg" class="article_img" id="pet"> </a> 
         <p id="pte"><center> CANAL+</center><br></p>
        </div>
        <div >
         <a href="{{ route('soneb') }}"> <img src="img/soneb.jpg" class="article_img" id="pet"> </a> 
         <p id="pte"><center> SONEB</center><br></p>
        </div>
        <div >
         <a href="{{ route('sbee') }}"> <img src="img/sbee.jpg" class="article_img" id="pet"> </a> 
         <p id="pte"><center>SBEE</center><br></p>
        </div>
        <div >
         <a href="{{ route('moov') }}"> <img src="img/moov.png" class="article_img" id="pet"> </a>
         <p id="pte"> <center>MOOV</center><br></p>
        </div>
        
        <div >
         <a href="{{ route('mtnb') }}"> <img src="img/MTN.jpg" class="article_img" id="pet"> </a> 
         <p id="pte"> <center>MTN </center><br></p> 
        </div >
        
        </nav>
        </div></div> 
@endsection