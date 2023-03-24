@extends('layouts.template_admin')

@section('css')
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
                        <div class="col-lg-12">
                          ({{ utf8_encode(" Historique � partir du 23 Ao�t 2021 � 14h44min19s")}} )
                          <div class="text-center">
                                  @include('flash::message')
                                </div>
                          <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i></li>
                            <li style="text-align: right"> <a href="{{ route('histadmin') }}">Historique des translations </a> </li>
                          </ol>
                        </div>
                      </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th style="text-align: center; background-color: #458b00; color: white"> Libelle de la translation</th>
                                  <th style="text-align: center; background-color: #458b00; color: white"> Contenu </th>
                                  <th style="text-align: center; background-color: #458b00; color: white"> {{ utf8_encode("Date de l'op�ration")}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($hists as $hist)
                              <tr style="text-align: center">
                                <td>
                                      @switch($hist->code)
                                          @case('A')
                                              {{ utf8_encode("Transfert d'un compte � l'autre")}}
                                              @break
                                          @case('B')
                                              {{ utf8_encode("Pr�lever du compte client")}}
                                              @break
                                          @case('C')
                                              {{ utf8_encode("Transfert sur le compte commission sur vente du client")}}
                                              @break
                                          @case('D')
                                              {{ utf8_encode("Pr�lever du compte commission sur vente du client")}}
                                              @break
                                          @case('E')
                                              {{ utf8_encode("Transfert sur le compte virtuel du client")}}
                                              @break
                                          @case('F')
                                              {{ utf8_encode("Pr�lever du compte virtuel du client")}}
                                              @break
                                          
                                          @default
                                              Inconnu
                                      @endswitch
                                      
                                </td>
                                <td> {{ $hist->libelle }}</td>
                                <td> {{ $hist->created_at}}</td>
                              </tr>
                            @empty
                              <tr >
                                <td colspan="3" style="text-align: center; color: red">Historique vide!</td>
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