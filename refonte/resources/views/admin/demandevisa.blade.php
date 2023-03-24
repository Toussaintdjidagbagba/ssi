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
                      Liste des demandes de retrait sur visa
                      </h2>
                    </div>
                    
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th style="text-align: center;"> {{ utf8_encode("Num�ro")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Identifiant")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Montant")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Intitil� de la carte")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Nom et pr�nom")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Identifiant de la carte")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Statut")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Date de la demande")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Date de service")}} </th>
                                  <th style="text-align: center;"> {{ utf8_encode("Envoyer une erreur")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Servir")}}</th>
                                  <th style="text-align: center;"> {{ utf8_encode("Supprimer")}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($visas as $visa)
                              <tr>
                                <td style="text-align: center;">{{ $visa->id }}</td>
                                <td style="text-align: center;">{{ $visa->codeperso }}</td>
                                
                                <td style="text-align: center;" >{{ $visa->mont }}</td>
                                <td style="text-align: center;">{{ $visa->intitule }}</td>
                                <td style="text-align: center;">{{ $visa->nom }}</td>
                                <td style="text-align: center;">{{ $visa->idcarte }}</td>
                                <td style="text-align: center;">
                                    @if($visa->statut == 1)
                                      <p style="color:red">En cours</p>
                                    @else
                                      <p style="color:green">Valider</p>
                                    @endif
                                </td>
                                <td style="text-align: center;">{{ $visa->created_at }}</td>
                                <td style="text-align: center;">
                                    @if (strtotime($visa->created_at) != strtotime($visa->updated_at))
                                        {{ $visa->updated_at }}
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($visa->statut == 1)
                                      <a href="{{ route('Visaechec', $visa->id) }}"><i class="material-icons" style="color: red;">done</i></a>
                                    @else
                                      <a href="#"><i class="material-icons" style="color: #A6ACAF;">done</i></a>
                                    @endif
                                    
                                </td>
                                <td style="text-align: center;">
                                    @if($visa->statut == 1)
                                      <a href="{{ route('Visaservir', $visa->id) }}"><i class="material-icons" style="color: green;">done</i></a>
                                    @else
                                      <a href="#"><i class="material-icons" style="color: #A6ACAF;">done</i></a>
                                    @endif
                                    
                                </td>
                                <td style="text-align: center;">
                                    
                                      <a href="{{ route('Visadelete', $visa->id) }}"><i class="material-icons" style="color: #ffa500;">done</i></a>
                                  
                                </td>
                              </tr>
                            @empty
                              <tr >
                                <td colspan="12" style="text-align: center;">Pas de demande disponible!!!</td>
                              </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $visas->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Hover Rows -->

    </div>
</section>

@endsection