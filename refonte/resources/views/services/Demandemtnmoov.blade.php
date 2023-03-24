@extends('layouts.template_admin')

@section('content')


<section class="content">
    <div class="container-fluid">
        <!-- Hover Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2>
                      Liste des demandes MTN / MOOV
                      </h2>
                    </div>
                    <div class="text-center">
                          @include('flash::message')
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th> Nom</th>
                                  <th> Identifiant</th>
                                  <th> Téléphone</th>
                                  <th> Libelle</th>
                                  <th> Envoyer le</th>
                                  <th> Montant Payer</th>
                                  <th> Valider le</th>
                                  <th> Répondre</th>
                                  <th> Statut</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($demandes as $monetique)
                              <tr>
                                <td>{{ $monetique->NomUser }}</td>
                                <td>{{ $monetique->CodePersoUser }}</td>
                                <td>{{ $monetique->Tel }}</td>
                                <td>{{ $monetique->libelle }}</td>
                                <td>{{ $monetique->created_at }}</td>
                                <td>{{ $monetique->MontantPayer }}</td>
                                <td>{{ $monetique->DateValider }}</td>
                                
                                <td>
                                  @if($monetique->Statut == "oui")
                                      <a href="#"><span class="fa fa-check-square" style="color: #A6ACAF;"></span></a>
                                  @else
                                      <form action="{{route('mtnmoovrecuS')}}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$monetique->id}}">	
                                      <input type="submit" name="valid" style="background: green; color : #fff" value="V">		
                                      </form>
                                  @endif
                                </td>
                                <td>


                                  @if($monetique->Statut == "oui")
                                      <i style="color: white; background-color: green;" class="material-icons">check_box</i>
                                  @else
                                      <i style="color: white; background-color: red;" class="material-icons">check_box</i>
                                  @endif
                                </td>
                                <td>
                                  <a class="" 
                                        style="color:red;font-weight:bold;" 
                                        href="{{url('admin/delete-mtnmoov-'.$monetique->id)}}">
                                        <i class="material-icons">delete</i> </a> 
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