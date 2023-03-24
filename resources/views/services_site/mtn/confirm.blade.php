@extends('layouts.template')


@section('css') 
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content') 

<section id="services" >

  <div class="container">

                    <div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('mtnbS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de crédit MTN  ï¿½ partir de vos compte avoirs</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input id="input" type="hidden" name="lib" value="credit">
	
	                     <div class="form-group">
	                      <input id="input" type="number" value="{{ $num }}" class="form-control form-control-user" name="numero">
	                     
	                    </div>
	
	                    
	                    <div class="form-group">
	                      <input id="input" type="text" class="form-control form-control-user" value="{{ $forfait }}" name="forfait">
	                     
	                    </div>
            		</div>
            		<div class="modal-footer" >
            		<button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">Confirmer</button>
            		</div>
            		 </form>
    </div>
</div>
@endsection
