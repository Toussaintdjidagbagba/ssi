@extends('layouts.templaterefonteadmin')

@section('css')


  <style type="text/css">
    .carre{
      width: 200px;
      height: 200px;
      text-align: center;
      color: white;
    }

    .arrondi{
      border-radius: 50%;
      line-height: 100px;
      
    }
  </style>
  
@endsection

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- Hover Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2>
                      Liste des demandes de retraire sur mobile money MTN
                      </h2>
                    </div>
                    <div class="text-center">
                          @include('flash::message')
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th> Référence No </th> 
                                  <th> Motif </th>
                                  <th> Numéro </th>
                                  <th> Montant </th>
                                  <th>Identifiant</th>
                                  <th> Envoyer le</th>
                                  <th> Délivré le</th>
                                  <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($demandes as $demande)
                              <tr>
                                <td>{{ $demande->reff }}</td>
                                <td>{{ $demande->intitule }}</td>
                                <td>{{ $demande->numero }}</td>
                                <td> {{ $demande->montant }} $ SSI</td>
                                <td> {{ $demande->codeperso }} </td>
                                <td>{{ $demande->created_at }}</td>
                                <td>{{ $demande->datevalider }}</td>
                                
                                <td>
                                  <button type="button" title="Reçu" class="btn btn-warning btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('mtnrecu', $demande->reff) }}" style="color:white;"> 
                                  <i class="material-icons">assignment</i></a></button>

                                   @if($demande->statut == "oui")
                                      <button type="button" title="Statut" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light" style=" background-color: #a2bd40"><a href="#" >
                                           <i class="material-icons" style="color:white">event_available</i></a></button>
                                  @else
                                      <button type="button" title="Statut" class="btn  btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"  style=" background-color: #ccc2c2" ><a href="#">
                                           <i class="material-icons" style="color:white" >event_busy</i></a></button>
                                  @endif

                                  <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="{{ route('deleteMTN',$demande->reff)}}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>
                                     

                                </td>
                                
                              </tr>
                            @empty
                              <tr >
                                <td colspan="7" style="text-align: center;">Pas de demande disponible!!!</td>
                              </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Hover Rows -->

    </div>
</section>

@endsection