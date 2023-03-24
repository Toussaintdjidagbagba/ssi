@extends('layouts.template_admin')

@section('css') 
  
@endsection

 
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="header">
                    <h2>
                    Prélever du compte client
                    </h2>
                </div>
               
                <div class="body">
                    <form  class="user" style="border: 0.5px solid gray; padding: 20px" method="post" action="{{ route('prelevementS') }}">
                    {{ csrf_field() }}    

                        <div class="form-group">
                            <div class="form-line">
                            <input type="number" class="form-control form-control-user" placeholder="Entrez identifiant du destinataire" name="id">
                            </div>
                            @if($errors->has('id'))
                              <p style="color: red"> {{ $errors->first('id') }}</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                            <input type="number" step="0.00001" class="form-control form-control-user"  placeholder="Entrez le montant" name="montant">
                            </div>
                            @if($errors->has('montant'))
                              <p style="color: red"> {{ $errors->first('montant') }}</p>
                            @endif
                        </div>
                        
                        <br>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect" id="but">PRELEVER</button>
                    </form>
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>
@endsection