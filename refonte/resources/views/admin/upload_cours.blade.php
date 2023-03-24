@extends('layouts.template_admin')

@section('css')
	
	<style type="text/css">
		#sidebar_right
		{
		    background-color: #f0f8ff;
		    border-bottom: 1px solid #688a7e !important;
		    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.176) !important;
		    
		}

		#link{
		    color: #65BBD6;
		}
		.bg-link
		{
			background-color: #65BBD6;
			color: white; 
		}
	</style>

@endsection

@section('content')


<!-- <section class="content">
    <div class="container-fluid">
        
       

    </div>
</section>   -->


<section class="content">
    <div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">AJOUTER UN COURS</h1>
    </div>
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    Enregistrer un cours
                    </h2>
                </div>
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="body">
                    <form  role="form" style="border: 0.5px solid gray; padding: 20px" method="post" enctype="multipart/form-data" action="{{ route('coursS')}}">
                    {{ csrf_field() }}    
                        <label for="titre">Titre du cours <i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre du cours" value="{{ old('titre') }}" autofocus autocomplete>
                            </div>
                            @if($errors->has('titre'))
                              <p style="color: red"> {{ $errors->first('titre') }}</p>
                            @endif
                        </div>

                        <label for="cours">Choisissez votre image<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="file" class="form-control" id="document" name="img"  >
                            </div>
                            @if($errors->has('img'))
                              <p style="color: red"> {{ $errors->first('img') }}</p>
                            @endif
						</div>
						
						<label for="description">Description<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
							<textarea class="form-control" id="description" name="description" placeholder="Entrer la description du cours" value="{{ old('description') }}" autofocus autocomplete style="height: 150px"></textarea>
                            </div>
                            @if($errors->has('description'))
                              <p style="color: red"> {{ $errors->first('description') }}</p>
                            @endif
                        </div>

                        
                        <br>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Valider</button>
                    </form>
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>       		
@endsection