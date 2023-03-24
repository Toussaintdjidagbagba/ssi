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
                      Liste des contacts
                      </h2>
                    </div>
                    <div class="text-center">
                          @include('flash::message')
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th><i class="icon_ol"></i> Id</th>
                                  <th><i class="icon_pin_alt"></i> Nom</th>
                                  <th><i class="icon_pin_alt"></i> Téléphone</th>
                                  <th><i class="icon_pin_alt"></i> Statut</th>
                                  <th><i class="icon_pin_alt"></i> Message</th>
                                  <th><i class="icon_pin_alt"></i> Répondre</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($contacts as $contact)
                              <tr>
                                <td>{{ $contact->id }}</td>
                                <td>{{ $contact->Nom }}</td>
                                <td>{{ $contact->Tel }}</td>
                                <td>
                                  @if($contact->Statut == "oui")
                                      <i style="color: white; background-color: green">reponse envoyée</i>
                                  @else
                                      <i style="color: white; background-color: red">en attente</i> 
                                  @endif
                                </td>
                                <td>{{ $contact->Message}}</td>
                                <td>
                                  <form action="{{route('listecontactS')}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$contact->id}}">
                                    <input type="hidden" name="email" value="{{$contact->Email}}">
                                    <input type="hidden" name="message" value="{{$contact->Message}}">
                                    <input type="submit" name="repondre" value="Répondre">
                                  </form>
                                </td>
                                
                                
                              </tr>
                            @empty
                              <tr >
                                <td colspan="6" style="text-align: center;">Pas de message disponible!!!</td>
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
</section

@endsection