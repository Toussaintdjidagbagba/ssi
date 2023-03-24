@extends('layouts.template_admin')

@section('css') 

  
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    Activer un compte filleul
                    </h2>
                </div>
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="body">
                    <form  class="user" style="border: 0.5px solid gray; padding: 20px" method="post" action="{{ route('activer') }}">
                    {{ csrf_field() }}    
                        <label for="id">Identifiant filleul <i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                            <input type="text" class="form-control" name="id" id="pseudo" placeholder="Entrer l'identifiant du filleul" value="{{ old('id') }}" data-original-title="Entrer l'identifiant du filleul">
                            </div>
                            @if($errors->has('id'))
                              <p style="color: red"> {{ $errors->first('id') }}</p>
                            @endif
                        </div>

                        <input type="hidden" name="active" value="oui">

                        
                        <br>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect" name="ACTIVER COMPTE" value="ACTIVER COMPTE" class="btn btn-user btn-block" id="but">ACTIVER COMPTE</button>
                    </form>
                </div>
            </div>
        </div>
      </div>       

    </div>
</section> 

@endsection