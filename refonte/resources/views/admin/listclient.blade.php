@extends('layouts.template_admin')

@section('css')
@endsection

@section('content')
    <div class="row">
        
      <div class="col-lg-12">
        
        <div class="text-center">
                @include('flash::message')
              </div>
        <ol class="breadcrumb">
          <li><i class="fa fa-home"></i></li>
          <li style="text-align: right"> <a href="{{ route('listclient') }}">Liste des clients du SSI</a>  </li>
        </ol>
      </div>
    </div>
    <div class="col-lg-4">
        
    </div>
    <div class="col-lg-6">
        
        <form class="form-inline" method="get" action="{{ route('search') }}">
          <input class="form-control mr-sm-2" type="search" placeholder="identifiant, pseudo, code de parrainage, nom ou prenom" name="motcle" aria-label="Search">
           
    </div>
    <div class="col-lg-2">
        <button class="btn btn-outline-info my-2 my-sm-0" type="submit" style="background-color: blue; color: white">Rechercher <i class="fa fa-search"></i></button>
        </form>
        <br> <br>
    </div>
    
    <!--/.row-->
    <div class="horizontal-scrollable">
    <div class="row">
        
      <div class="col-lg-12">
        <section class="panel">
          
		
          <table class="table table-striped table-advance table-hover">
            <tbody>
              <tr style="font-size: 12px">
                <th style="text-align: center"><i class="icon_ol"></i> Nom & Prénom</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Identifiant</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Code de parrainage</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Parrain ||<br> Parrain indirect</th>
                
                <!--th style="text-align: center"><i class="icon_pin_alt"></i> Pseudo</th-->
                <th style="text-align: center"><i class="icon_pin_alt"></i> Gain Espèce</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Gain Virtuel</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Gain CV</th>
                <th style="text-align: center"><i class="icon_pin_alt"></i> Status</th>
                <th style="text-align: center"> <i class="icon_pin_alt"></i> Inscrire le</th>
                <th style="text-align: center"> <i class="icon_pin_alt"></i> Action</th>
              </tr>
              @forelse($clients as $client)
                <tr style="text-align: center">
                  <td>{{ $client->nom }} {{ $client->prenom }} </td>
                  <td>{{ $client->codeperso}}</td>
                  <td>{{ $client->codeunique }}</td>
                  
                  <td>{{ $client->parrain }} ||<br> {{ $client->parrainindirect }}</td>

                  <td>{{ $client->gainespece }} $ SSI</td>
                  <td>{{ $client->gainvirtuel }} $ SSI</td>
                  <td>{{ $client->gaincommissionvente}} $ SSI</td>
                  <td>
                    @if($client->compteactive == "non")
                      <i style="color: white; background-color: red">inactif</i> 
                    @else
                      <i style="color: white; background-color: green">actif</i>
                    @endif
                  </td>
                  <td>{{ $client->created }}</td>
                  <td> <a class="btn btn-outline-primary btn-circle btn-icon" 
                          style="color:red;font-weight:bold;" 
                          
                          href="{{url('admin/delete-Filleul-'.$client->id)}}">
                      <i class="fa fa-trash"></i>Supprimer </a> 
                   </td>
                </tr>
              @empty
                <tr >
                  <td colspan="10" style="text-align: center; color: red">Liste vide!!! Pas de client disponible ou n'existe.</td>
                </tr>
              @endforelse
              
            </tbody>
          </table>
            {{ $clients->links() }}
        </section>
      </div>
    </div>
    </div>

@endsection