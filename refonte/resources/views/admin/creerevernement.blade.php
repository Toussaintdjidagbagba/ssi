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

<section class="content">
    <div class="container-fluid">

      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="text-center">
          @include('flash::message')
        </div>
      </div>
        
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    Créer une conférence
                    </h2>
                </div>
                <div class="body">
                    <form  class="user" method="post" action="{{ route('evernementS') }}">
                    {{ csrf_field() }}    
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control form-control-user" placeholder="Enter le thème de la conférence" name="theme">
                            </div>
                            @if($errors->has('theme'))
                              <p style="color: red"> {{ $errors->first('theme') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control form-control-user" placeholder="Entrer le lieu" name="lieu">
                            </div>
                            @if($errors->has('lieu'))
                              <p style="color: red"> {{ $errors->first('lieu') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <input type="date" class="form-control form-control-user" id="exampleInputPassword" placeholder="Entrer la date" name="date">
                            </div>
                            @if($errors->has('date'))
                              <p style="color: red"> {{ $errors->first('date') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <input type="time" class="form-control form-control-user" placeholder="Entrer l'heure" name="heure">
                            </div>
                            @if($errors->has('heure'))
                              <p style="color: red"> {{ $errors->first('heure') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                          <label for="reponse">Entrer une courte description de la conférence (<i style="color: red">*</i>)</label>
                            <div class="form-line">
                            <textarea class="form-control" name="description" placeholder="Entrer description" value="{{ old('description') }}" autofocus autocomplete style="height: 150px"></textarea>
                            </div>
                            @if($errors->has('description'))
                              <p style="color: red"> {{ $errors->first('description') }}</p>
                            @endif
                        </div>

                        
                        <br>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">CREER UNE CONFERENCE</button>
                    </form>
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>  

@endsection