@extends('layouts.template')

@section('header')
  <header class="masthead" style="background-image: url('img/logg.png')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>La Source du Succès International</h2>
            <span class="subheading">MTN/MOOV</span>
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

                    <h1 class="h4 text-gray-900 mb-4">Achat de crédit MTN / MOOV à partir de vos compte avoirs</h1>
                  </div>
                  <form class="user" method="post" action="{{ route('mtnS') }}">
                    {{ csrf_field() }}

                     <div class="form-group">
                      <input type="number" class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
                      @if($errors->has('numero'))
                        <p style="color: red"> Saisissez votre numero</p>
                      @endif
                    </div>

                    <div class="form-group">
                      <select type="number" class="form-control"  name="forfaitlib" placeholder="Forfaitlib" data-original-title="Entrer le module du forfait">
                        <option value="1">Crédit</option>
                        <option value="2">Forfait Appel</option>
                        <option value="3">Forfait Appel + Internet</option>
                        <option value="4">Forfait Internet</option>
                    </select>
                    </div>
                    
                    <div class="form-group">
                      <input type="number" step="0.00001" class="form-control form-control-user" placeholder="Entrez le montant en $ SSI" name="forfait">
                      @if($errors->has('forfait'))
                        <p style="color: red"> Saisissez votre forfait</p>
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