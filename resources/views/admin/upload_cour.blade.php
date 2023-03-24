@extends('layouts.templaterefonteadmin')

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
                    Cours
                    @if(in_array("add_cours", session("auto_action")))
                    <button type="button" style="margin-right: 30px; float: right; padding-right: 30px; padding-left: 30px;" class="btn bg-deep-blue waves-effect" data-color="deep-blue" data-toggle="modal" data-target="#add">Ajouter</button>
                    @endif
                    </h2>
                </div>
                
                <div class="body">
                    <div class="table-responsive" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th data-priority="1">Cours</th>
                                        <th data-priority="1">Coût</th>
                                        <th data-priority="1">Lien</th>
                                        <th data-priority="1">Date Lancement</th>
                                        <th data-priority="1">Etat</th>
                                        <th data-priority="1">Actions</th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($list as $cour)
                                        <tr>
                                            <th><span class="co-name">{{ $cour->titre }}</span></th>
                                            <td>  {{ $cour->doc }}</td>
                                            <th><span class="co-name"> {{ $cour->cout }} </span></th>
                                            <th><span class="co-name"> <a href="{{ $cour->coutlink }}">{{ $cour->titre }} (Sécuriser)</a>  </span></th>
                                            <th><span class="co-name">{{ $cour->datelancement }}</span></th>
                                            <th><span class="co-name">En attente</span></th>
                                            <td>
                                            @if(in_array("delete_cours", session("auto_action")))
                                            <button type="button" title="Supprimer"  class="btn btn-danger btn-circle btn-xs  margin-bottom-10 waves-effect waves-light"><a href="" style="color:white;"><i class="material-icons">delete_sweep</i></a> </button>
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
                <h4 class="modal-title" id="myModalLabel">Enregistrer un cours : </h4>
            </div>
            <form method="post" action="{{ route('coursS') }}" enctype="multipart/form-data">
             <div class="modal-body">
               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
               
               <div class="row clearfix">
                    <div class="col-md-6">
                          <label for="titre">Titre du cours <i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" required id="titre" name="titre" placeholder="" value="{{ old('titre') }}" autofocus autocomplete>
                            </div>
                            @if($errors->has('titre'))
                              <p style="color: red"> {{ $errors->first('titre') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                       <label for="log">Cours<i style="color: red">*</i></label>
                       <div class="form-group">
                            <div class="form-line">
                                <input type="file" id="log" required class="form-control" id="cours" name="cours" accept=".pdf"  >
                            </div>
                            @if($errors->has('cours'))
                              <p style="color: red"> {{ $errors->first('cours') }}</p>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12">
                          <label for="link">Lien du cours <i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" required id="link" name="link" placeholder="" value="{{ old('link') }}" autofocus autocomplete>
                            </div>
                            @if($errors->has('link'))
                              <p style="color: red"> {{ $errors->first('link') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-6">
                          <label for="cout">Coût<i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                            <input type="number" class="form-control" required id="cout" name="cout" value="{{ old('cout') }}" autofocus autocomplete>
                            </div>
                            @if($errors->has('cout'))
                              <p style="color: red"> {{ $errors->first('cout') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                          <label for="date">Date de lancement <i style="color: red">*</i></label>
                          <div class="form-group">
                            <div class="form-line">
                            <input type="date" class="form-control" id="date" name="date" required autofocus autocomplete>
                            </div>
                            @if($errors->has('date'))
                              <p style="color: red"> {{ $errors->first('date') }}</p>
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