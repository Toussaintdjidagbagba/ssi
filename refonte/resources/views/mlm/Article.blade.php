@extends('layouts.template')

@section('header')
  <header class="masthead" style="background-image: url('img/logg.png')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>La Source du Succès International</h2>
            <span class="subheading">Article</span>
          </div>
        </div>
      </div>
    </div> 
  </header>
@endsection

@section('stylesheet')

  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <style type="text/css">
    .rating {
       direction: rtl;
    }
    .rating a {
       color: #aaa;
       text-decoration: none;
       font-size: 2em;
       transition: color .4s;
    }
    .rating a:hover,
    .rating a:focus,
    .rating a:hover ~ a,
    .rating a:focus ~ a {
       color: orange;
       cursor: pointer;
    }
  </style>

@endsection


@section('content')

  <div class="container">
    <div class="col-xl-12 col-lg-12 col-md-11">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-1">
                
              </div>
              <div class="col-lg-8">
                <div class="p-5">
                  
                    <div class="row">
                      <div class="col-lg-4">
                        <img src="img/{{$cour[0]->path}}" class="article_img">
                      </div>
                      <div class="col-lg-7">
                        <p>
                          <h4> {{ $cour[0]->titre }} </h4>
                        </p>
                        <p>
                          Prix : {{ $cour[0]->prix }} F CFA
                        </p> 
                        <hr>
                        <p> 
                          <div class="rating"><!--
                             --><a href="#5" title="Donner 5 étoiles">☆</a><!--
                             --><a href="#4" title="Donner 4 étoiles">☆</a><!--
                             --><a href="#3" style="color : orange" title="Donner 3 étoiles">☆</a><!--
                             --><a href="#2" style="color : orange" title="Donner 2 étoiles">☆</a><!--
                             --><a href="#1" style="color : orange" title="Donner 1 étoile">☆</a> : Evaluation 
                          </div>

                        </p>
                        <hr>
                        
                          Desciption : <p style="text-align: justify;">{{ $cour[0]->description }}</p>
                        
                      </div>
                      <div class="col-lg-1">
                        
                      </div>
                      <div class="col-lg-2"> <br><br>
                        <a href="paiement-{{$cour[0]->id}}" class="btn btn-primary" id="but">PAYER</a>
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

@endsection