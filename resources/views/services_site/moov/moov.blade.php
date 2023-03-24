@extends('layouts.template')

@section('css') 
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"> 
@endsection
 
@section('content') 
<section id="services">

  <div class="container">


<div class="text-center">
	 @include('flash::message')
</div> 
  <a  data-toggle="modal" href="#depot" >
        <div class="col-sm-2" 
        style="border-radius: 10px; padding:20px; margin-left:8px; margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        DEPÔT
        </div>
    </a>
    <a  data-toggle="modal" href="#credit" >
        <div class="col-sm-2" 
        style="border-radius: 10px; padding:20px; margin-left:8px;margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        CRÉDIT
        </div>
    </a>
    <a  data-toggle="modal" href="#internet" >
        <div class="col-sm-2" 
        style="border-radius: 10px; padding:20px; margin-left:8px;margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        FORFAIT INTERNET
        </div>
    </a>
    <a  data-toggle="modal" href="#bonus" >
        <div class="col-sm-2" 
        style="border-radius: 10px; padding:20px; margin-left:8px;margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        PASS BONUS
        </div>
    </a>
    <a  data-toggle="modal" href="#forfaitmoov" >
        <div class="col-sm-3" 
        style="border-radius: 10px; padding:20px; margin-left:8px; margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        PASS BONUS + INTERNET
        </div>
    </a>

     <!-- Achat de crédit -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="credit" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('moovS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de crédit MOOV</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input type="hidden" name="lib" value="credit">

                     <div class="form-group">
                      <input id="input" type="number" required class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
                      @if($errors->has('numero'))
                        <p style="color: red"> Saisissez votre numero</p>
                      @endif
                    </div>

                    
                    <div class="form-group">
                      <input id="input" type="number" step="0.00001" required class="form-control form-control-user" placeholder="Entrez le montant du crédit en SSI" name="forfait">
                      @if($errors->has('forfait'))
                        <p style="color: red"> Saisissez votre le montant du forfait</p>
                      @endif
                    </div>
            		</div>
            		<div class="modal-footer" >
            		<button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">VALIDER</button>
            		</div>
            		 </form>
            </div>
          </div>
        </div>

     <!-- fin Crédit -->

      <!-- forfait internet -->
     		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="internet" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('moovS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de Forfait internet MOOV </h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input type="hidden" name="lib" value="forfait">
		
		                     <div class="form-group">
		                      <input id="input" type="number" class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
		                      @if($errors->has('numero'))
		                        <p style="color: red"> Saisissez votre numero</p>
		                      @endif
		                    </div>
		
		                    <div class="form-group">
		                      <select id="input" type="number" class="form-control"  name="forfaitlib" placeholder="Forfait Appel" data-original-title="Entrer le module du forfait">
		                        <option value="17">0.4 SSI (24h)</option>
								<option value="18">0.5 SSI (24h)</option>
								<option value="19">0.6 SSI (24h)</option>
		                        <option value="1">1 SSI (48h) </option>
		                        <option value="2">1 SSI (06jrs) </option>
		                        <option value="3">2 SSI (07jrs)</option>
		                        <option value="4">4 SSI (07jrs)</option>
		                        <option value="5">4 SSI (30jrs)</option>
		                        <option value="6">5 SSI (30jrs)</option>
		                        <option value="7">8 SSI (30jrs)</option>
		                        <option value="8">10 SSI (30jrs)</option>
		                        <option value="9">12 SSI (30jrs)</option>
		                        <option value="10">18 SSI (30jrs)</option>
		                        <option value="11">30 SSI (30jrs)</option>
		                        <option value="20">31 SSI (illimité)</option>
		                        <option value="12">40 SSI (illimité)</option>
		                        <option value="13">50 SSI (illimité)</option>
		                        <option value="14">60 SSI (illimité)</option>
		                        <option value="15">100 SSI (illimité)</option>
		                        <option value="16">150 SSI (illimité)</option>
		                    </select>
		                    </div>
		                    
            		</div>
            		<div class="modal-footer" >
            		<button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">VALIDER</button>
            		</div>
            		 </form>
            </div>
          </div>
        </div>
     <!-- fin forfait internet -->

     <!-- forfait pass bonus -->
     		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="bonus" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('moovS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de Forfait Pass Bonus Moov </h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input type="hidden" name="lib" value="pass">
		
		
		                     <div class="form-group">
		                      <input id="input" type="number" class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
		                      @if($errors->has('numero'))
		                        <p style="color: red"> Saisissez votre numero</p>
		                      @endif
		                    </div>
		
		                    <div class="form-group">
		                      <select id="input" type="number" class="form-control"  name="forfaitlib" placeholder="Forfait Appel" data-original-title="Entrer le module du forfait">
		                        <option value="6">0.4 SSI (24h)</option>
		                        <!--option value="7">0.5 SSI (24h)</option-->
		                        <option value="1">1 SSI (48h) </option>
		                        <option value="2">2 SSI (07jrs) </option>
		                        <option value="3">3 SSI (07jrs)</option>
		                        <option value="4">5 SSI (30jrs)</option>
		                        <option value="5">10 SSI (30jrs)</option>
		                        
		                    </select>
		                    </div>
                        
            		</div>
            		<div class="modal-footer" >
            		<button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">VALIDER</button>
            		</div>
            		 </form>
            </div>
          </div>
        </div>
     <!-- fin forfait appel-->

      <!-- forfait appel internet -->
     		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="forfaitmoov" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('moovS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de Forfait Pass Bonus + Internet Moov</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input type="hidden" name="lib" value="forfaitmoov">
		
		
		                     <div class="form-group">
		                      <input id="input" type="number" class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
		                      @if($errors->has('numero'))
		                        <p style="color: red"> Saisissez votre numero</p>
		                      @endif
		                    </div>
		
		                    <div class="form-group">
		                      <select id="input" type="number" class="form-control"  name="forfaitlib" placeholder="Forfait Appel" data-original-title="Entrer le module du forfait">
		                        <option value="6">0.4 SSI (24h)</option>
		                        <!--option value="7">0.5 SSI (24h)</option-->
								<option value="1">1 SSI (48h) </option>
		                        <option value="2">2 SSI (07jrs) </option>
		                        <option value="3">3 SSI (07jrs)</option>
		                        <option value="4">5 SSI (30jrs)</option>
		                        <option value="5">10 SSI (30jrs)</option>
								
		                        
		                    </select>
		                    </div>
            		</div>
            		<div class="modal-footer" >
            		<button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">VALIDER</button>
            		</div>
            		 </form>
            </div>
          </div>
        </div>
     <!-- fin forfait appel internet -->
     
     <!-- Dépot -->
     <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="depot" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('moovS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Dépôt sur compte MOOV  </h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input type="hidden" name="lib" value="depot">

                     <div class="form-group">
                      <input id="input" type="number" required class="form-control form-control-user" pattern="229[0-9]{8}" 
                      placeholder="Entrez votre numéro" name="numero">
                      @if($errors->has('numero'))
                        <p style="color: red"> Saisissez votre numero</p>
                      @endif
                    </div>

                    <div class="form-group">
	                      <input id="input" type="text" required class="form-control form-control-user" 
	                       placeholder="Entrez votre nom" name="nom">
	                      @if($errors->has('nom'))
	                        <p style="color: red"> Saisissez votre nom</p>
	                      @endif
	               </div>
	                    
                    <div class="form-group">
                      <input id="input" type="number" step="0.00001" required class="form-control form-control-user" 
                      placeholder="Entrez le montant du crédit en SSI" name="forfait">
                      @if($errors->has('forfait'))
                        <p style="color: red"> Saisissez votre le montant du forfait</p>
                      @endif
                    </div>
            		</div>
            		<div class="modal-footer" >
            		<button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                <button class="btn btn-theme" type="submit" style="background-color: #5ca945; color : #fff">VALIDER</button>
            		</div>
            		 </form>
            </div>
          </div>
        </div>
     <!-- fin dépot -->
     
</div>
</section>

@endsection



    