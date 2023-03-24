@extends('layouts.templaterefonteadmin')

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- Hover Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2 style="margin-right: 30px; float: right; padding-right: 30px; padding-left: 30px;">
                      Liste des vendeurs du SSI
                      </h2>
                      <form class="form-inline" method="get" action="{{ route('searchv') }}">
                        <input style="width: 400px" class="form-control" type="search" placeholder="identifiant, pseudo, code de parrainage, nom ou prenom" name="motcle" aria-label="Search">
                         
                      <button class="btn btn-outline-info" type="submit">Rechercher <i class="fa fa-search"></i></button>
                      </form>
                    </div>
                    <div class="text-center">
                          @include('flash::message')
                    </div>
                    <div class="body">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table table-small-font table-bordered table-striped"> 
            <thead>
              <tr style="font-size: 12px">
                <th style="text-align: center"><i class="icon_ol"></i> Nom & Prénom</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Téléphone</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Identifiant</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Code de parrainage</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Parrain</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Gain Espèce</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Gain Virtuel</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Gain Actuel CV</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Gain Collecter CV</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> PV</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Etape</th>
                <th style="text-align: center"> <i class="icon_pin_alt"></i> Inscrire le</th>
                <th style="text-align: center"> <i class="icon_pin_alt"></i> Actions</th>
              </tr>
            </thead>
              <tbody>
              @forelse($clients as $client)
                <tr style="text-align: center">
                  <td>{{ $client->nom }} {{ $client->prenom }} </td>
                  <td>{{ $client->tel}} </td>
                  <td>{{ $client->codeperso}}</td>
                  <td>{{ $client->codeunique }}</td>
                  
                  <td>{{ $client->parrain }}</td>

                  <td>{{ $client->gainespece }} SSI</td>
                  <td>{{ $client->gainvirtuel }} SSI</td>
                  <td>{{ $client->gaincommissionvente}} SSI</td>
                  
                  <td>{{ $client->compv}} SSI</td>
                  <td>{{ floor($client->cvpv / 10) }}</td>
                  
                  <td>{{ $client->etapeActuel}} </td>
                  
                  <td>{{ $client->created }}</td>
                  <td> 
                     @if($client->compteactive == "non")
                                      <button type="button" title="Statut" class="btn btn-warning btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="#" style="color:white;"> 
                                      <i class="material-icons">event_busy</i></a></button>
                                  @else
                                      <button type="button" title="Statut" class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style="background-color: green"><a href="#" style="color:white;"> 
                                      <i class="material-icons" >event_available</i></a></button>
                                  @endif
                    <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('deleteclient', $client->id) }}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>
                   <button type="button" title="Modifier"  style="background:green" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('gclient', $client->id) }}" style="color:white;"><i class="material-icons">system_update_alt</i></a> </button>
                   
                </tr>
              @empty
                <tr >
                  <td colspan="12" style="text-align: center; color: red">Liste vide!!! Pas de client disponible ou n'existe.</td>
                </tr>
              @endforelse
              
            </tbody>
          </table>
        </section>
      </div>
    </div>
    </div>
    </div>
    </div>
    </div>

@endsection