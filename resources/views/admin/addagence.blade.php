@extends('layouts.templaterefonteadmin')
<?php  header('Content-Type: text/html; charset="UTF-8"'); ?>
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
                @include('flash::message')
                <h2>
                    Tableau de bord
                    <small></small> 
                </h2>
            </div>
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card"> 
                <div class="header">
                    <h2>
                    Ajouter Agence
                    <button type="button" style="margin-right: 30px; float: right; padding-right: 30px; padding-left: 30px;" class="btn bg-deep-blue waves-effect" data-color="deep-blue" data-toggle="modal" data-target="#add">Ajouter</button>
                    </h2>
                </div>
                
                <div class="body">
                    <div class="table-responsive" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th data-priority="1">Description</th>
                                        <th data-priority="1">Téléphone</th>
                                        <th data-priority="1">Longitude</th>
                                        <th data-priority="1">Latitude</th>
                                        <th data-priority="1">Adresse</th>
                                        <th data-priority="1">Image</th>
                                        <th data-priority="1">Actions</th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($list as $cour)
                                        <tr>
                                            <th><span class="co-name">{{ $cour->name }}</span></th>
                                            <td>  {{ $cour->description }}</td>
                                            <th><span class="co-name"> {{ $cour->phone }} </span></th>
                                            <th><span class="co-name"> {{ $cour->longitude }} </span></th>
                                            <th><span class="co-name">{{ $cour->latitude }}</span></th>
                                            <th><span class="co-name">{{ $cour->adresse }}</span></th>
                                            <th><span class="co-name">
                                                <img class="profile-image" src="mapsapi/images/{{ $cour->images }}" style="border-radius: 10%; width:40px; height:50px" ></span></th>
                                            
                                            <td>
                                            @if(1)
                                            <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                                <a href="{{ route('coursSAg', $cour->id) }}" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>
                                            <button type="button" title="Modifier" style="background:green" class="btn btn-circle btn-xs  margin-bottom-10 waves-effect waves-light">
                                                <a href="{{ route('coursMg', $cour->id) }}" style="color:white;"><i class="material-icons">system_update_alt</i></a> </button>
                               
                                            @endif

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6"><center>Pas de cours enregistrer!!!</center> </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                
                    </div> 
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>       		
@endsection

@section('css')
@endsection

@section('js')

    <script src="{{ asset('newrefonteadmin/js/pages/forms/editors.js') }}"></script>
    <script src="{{ asset('newrefonteadmin/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('newrefonteadmin/plugins/tinymce/tinymce.js') }}"></script>

@endsection

@section("model")

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Enregistrer une agence : </h4>
            </div>
            <form method="post" action="{{ route('coursAgS') }}" enctype="multipart/form-data">
             <div class="modal-body">
               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
               
               <div class="row clearfix">
                    <div class="col-md-6">
                          <label for="titre">Nom ou dénomination<i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" required id="titre" name="nom" placeholder="" autofocus autocomplete>
                            </div>
                            @if($errors->has('nom'))
                              <p style="color: red"> {{ $errors->first('nom') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                       <label for="log">Image<i style="color: red">*</i></label>
                       <div class="form-group">
                            <div class="form-line">
                                <input type="file" id="log" required class="form-control" id="log" name="log"  >
                            </div>
                            @if($errors->has('log'))
                              <p style="color: red"> {{ $errors->first('log') }}</p>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12">
                          <label for="description">Description <i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" required id="description" name="description" autofocus autocomplete>
                            </div>
                            @if($errors->has('description'))
                              <p style="color: red"> {{ $errors->first('description') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-6">
                          <label for="long">Longitude<i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                            <input type="number" class="form-control" required id="long" name="long"  step="0.0000001" autofocus autocomplete>
                            </div>
                            @if($errors->has('long'))
                              <p style="color: red"> {{ $errors->first('long') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                          <label for="lat">Latitude <i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                            <input type="number" class="form-control" id="lat" name="lat" step="0.0000001" required autofocus autocomplete>
                            </div>
                            @if($errors->has('lat'))
                              <p style="color: red"> {{ $errors->first('lat') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-6">
                          <label for="tel">Téléphone<i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                            <input type="number" class="form-control" required id="tel" name="tel" value="{{ old('cout') }}" autofocus autocomplete>
                            </div>
                            @if($errors->has('tel'))
                              <p style="color: red"> {{ $errors->first('tel') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                          <label for="adr">Adresse <i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                            <input type="text" class="form-control" id="adr" name="adr" required autofocus autocomplete>
                            </div>
                            @if($errors->has('adr'))
                              <p style="color: red"> {{ $errors->first('adr') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">FERMER</button>
                <button type="submit" class="btn bg-deep-blue waves-effect">AJOUTER</button>
            </div>
            </form>
        </div>
    </div>
    </div>

@endsection