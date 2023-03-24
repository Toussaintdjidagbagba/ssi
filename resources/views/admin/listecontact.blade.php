@extends('layouts.templaterefonteadmin')

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
                    <div class="body">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
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
                                      <button type="button" title="Statut" class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="#" style="color:white;"> <i class="material-icons">toggle_on</i></a></button>
                                  @else
                                      <button type="button" title="Statut" class="btn btn-warning btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="#" style="color:white;"> <i class="material-icons">toggle_off</i></a></button>
                                  @endif
                                  
                                </td>
                                <td>
                                  @if(strlen($contact->Message) > 70)
                                                    <?php $texte = $contact->Message; $newtexte =""; ?>
                                                    @for ($i = 0; $i < 70; $i++)
                                                        <?php $newtexte .= substr($texte, 0, 1); $texte = substr($texte, 1) ?>
                                                    @endfor
                                                    {{ $newtexte }}<a href="{{ route('listecontactS', $contact->id) }}">... (Lire la suite)</a>
                                                @else
                                                    {{$contact->Message}}
                                                @endif
                                </td>
                                <td>
                                  <button type="button" title="Répondre"  class="btn btn-primary btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                                <a href="{{ route('listecontactS', $contact->id)}}" style="color:white;"> <i class="material-icons">system_update_alt</i></a> 
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
</section>

@endsection