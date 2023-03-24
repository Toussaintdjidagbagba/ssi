@extends('layouts.template')


@section('header')
  <header class="masthead" style="background-image: url('img/logg.png')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>La Source du Succès International</h2>
            <div class="subheading">HEALTH</div>
          </div>
        </div>
      </div>
    </div> 
  </header>
@endsection

@section('css') 
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
@endsection


@section('content')
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        
      </div>

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-2">
                
              </div> 
              <div class="col-lg-8">
                <div class="p-5">
                  <div class="text-center">
                    @include('flash::message')
                  </div>
                  <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4">Formation en éducation physique  </h1>  Une formation qui vous guarantit SANTÉ ET RICHESSE <br>
                     
                  </div>
                  <form class="user" method="post" action="{{ route('healthformS') }}">
                    {{ csrf_field() }}

                     <div class="form-group"> <br>
                      <label >Pseudo :</label>
                      <input type="text" class="form-control form-control-user" placeholder="Entrez votre pseudo" name="pseudo">
                      @if($errors->has('pseudo'))
                        <p style="color: red"> Saisissez votre pseudo</p>
                      @endif
                    </div>
                     
                    <div class="form-group">
                      <label >Nom :</label>
                      <input type="text" class="form-control form-control-user" placeholder="Entrez votre nom" name="nom">
                      @if($errors->has('nom'))
                        <p style="color: red"> Saisissez votre nom</p>
                      @endif
                    </div>

                     <div class="form-group">
                      <label >Prénom :</label>
                      <input type="text"  class="form-control form-control-user"  placeholder="Entrez votre prénom" name="prenom">
                      @if($errors->has('prenom'))
                        <p style="color: red"> Saisissez votre prenom</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label >Date :</label>
                      <input type="date" class="form-control form-control-user"  placeholder="Entrez votre date de naissance" name="nais" >
                      @if($errors->has('nais'))
                        <p style="color: red"> Saisissez une date valide</p>
                      @endif
                    </div>

                     <div class="form-group">
                      <label >Pays :</label>
                      <select type="text" class="form-control"  name="pays" id="pays" placeholder="Entrer votre pays" data-original-title="Entrer votre Pays">
                        <option>Bénin</option>
                        @foreach($pays as $pay)
                        <option>{{ $pay->libelle }}</option>
                      @endforeach
                    </select>
                    </div>

                     <div class="form-group">
                      <label >Numéro de téléphone :</label>
                      <input type="number" class="form-control form-control-user"  placeholder="Entrez votre numero de téléphone" name="tel" >
                      @if($errors->has('tel'))
                        <p style="color: red"> Saisissez un numéro valide</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <label >Adresse mail :</label>
                      <input type="email" class="form-control form-control-user"  placeholder="Entrez une adresse mail valide" name="mail" >
                      @if($errors->has('mail'))
                        <p style="color: red"> Saisissez votre mail valide</p>
                      @endif
                    </div>
                    
                    <button type="submit" class="btn btn-user btn-block" id="but">
                      <b>Valider</b>
                    </button>
                  
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

@endsection