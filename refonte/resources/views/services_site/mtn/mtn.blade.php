@extends('layouts.template')


@section('css') 
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
@endsection

@section('content') 

<section id="services" >

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
    <a  data-toggle="modal" href="#forfaitinternet" >
        <div class="col-sm-2" 
        style="border-radius: 10px; padding:20px; margin-left:8px;margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        FORFAIT INTERNET
        </div>
    </a>
    <a  data-toggle="modal" href="#forfaitappel" >
        <div class="col-sm-2" 
        style="border-radius: 10px; padding:20px; margin-left:8px;margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        FORFAIT APPEL
        </div>
    </a>
    <a  data-toggle="modal" href="#forfaitappelinternet" >
        <div class="col-sm-3" 
        style="border-radius: 10px; padding:20px; margin-left:8px; margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        FORFAIT APPEL + INTERNET
        </div>
    </a>
    <a  data-toggle="modal" href="#p" >
        <div class="col-sm-2" 
        style="border-radius: 10px; padding:20px; margin-left:8px; margin-top:8px; text-align:center; color:#fff; 
        background-color:#5ca945; box-shadow: 4px 4px 7px 1px rgba(79, 46, 20, .2);">
        CREDIT P3
        </div>
    </a>
    
     <!-- Achat de crédit -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="credit" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('mtnbS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de crédit MTN  à partir de vos compte avoirs</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input id="input" type="hidden" name="lib" value="credit">
	
	                     <div class="form-group">
	                      <input id="input" type="number" required class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
	                      @if($errors->has('numero'))
	                        <p style="color: red"> Saisissez votre numero</p>
	                      @endif
	                    </div>
	
	                    
	                    <div class="form-group">
	                      <input id="input" type="number" step="0.00001" required class="form-control form-control-user" 
	                      placeholder="Entrez le montant du crédit en $ SSI" name="forfait">
	                      @if($errors->has('forfait'))
	                        <p style="color: red"> Saisissez le montant en $ SSI</p>
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
     		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="forfaitinternet" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('mtnbS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de Forfait internet MTN à partir de vos compte avoirs</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input type="hidden" name="lib" value="internet">
	
	                     <div class="form-group">
	                      <input id="input" type="number" required class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
	                      @if($errors->has('numero'))
	                        <p style="color: red"> Saisissez votre numero</p>
	                      @endif
	                    </div>
	
	                    <div class="form-group">
	                      <select id="input" type="number" class="form-control"  name="forfaitlib" placeholder="Forfait Appel" data-original-title="Entrer le module du forfait">
	                        <option value="11">0.4 $ SSI (24h)</option>
													<option value="12">0.5 $ SSI (24h)</option>
													<option value="13">0.6 $ SSI (24h)</option>
	                        <option value="1">1 $ SSI (48h) </option>
	                        <option value="2">1 $ SSI (06jrs)</option>
	                        <option value="3">2 $ SSI (07jrs)</option>
	                        <option value="4">2 $ SSI (15jrs)</option>
	                        <option value="5">4 $ SSI (07jrs)</option>
	                        <option value="6">4 $ SSI (15jrs)</option>
	                        <option value="7">5 $ SSI (15jrs)</option>
	                        <option value="8">8 $ SSI (30jrs)</option>
	                        <option value="9">12 $ SSI (30jrs)</option>
	                        <option value="10">29 $ SSI (30jrs)</option>
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

     <!-- forfait appel -->
     		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="forfaitappel" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('mtnbS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de forfait maxi appel MTN à partir de vos compte avoirs</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input type="hidden" name="lib" value="forfaitappel">

                         <div class="form-group">
                          <input id="input" type="number" required class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
                          @if($errors->has('numero'))
                            <p style="color: red"> Saisissez votre numero</p>
                          @endif
                        </div>

                        <div class="form-group">
                          <select id="input" type="text" class="form-control"  name="forfaitlib" placeholder="Forfait MAXI" data-original-title="Entrer le module du forfait">
                            <option value="4">0.4 $ SSI (24h)</option>
														<option value="1">1 $ SSI (48h)</option>
                            <option value="2">2 $ SSI (07jrs)</option>
                            <option value="3">3 $ SSI (07jrs)</option>
                            <option value="6">5 $ SSI (30jrs)</option>
		                        <option value="5">10 $ SSI (30jrs)</option>
                            
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
     		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="forfaitappelinternet" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('mtnbS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Achat de Forfait Maxi appel et internet MTN à partir de vos compte avoirs</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input type="hidden" name="lib" value="maxi">

                         <div class="form-group">
                          <input id="input" type="number" required class="form-control form-control-user" pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
                          @if($errors->has('numero'))
                            <p style="color: red"> Saisissez votre numero</p>
                          @endif
                        </div>

                        <div class="form-group">
                          <select id="input" type="text" class="form-control"  name="forfaitlib" placeholder="Forfait MAXI" data-original-title="Entrer le module du forfait">
                            <option value="4">0.4 $ SSI (24h)</option>
                            <option value="1">1 $ SSI (48h)</option>
                            <option value="2">2 $ SSI (07jrs)</option>
                            <option value="3">3 $ SSI (07jrs)</option>
                            <option value="6">5 $ SSI (30jrs)</option>
		                    <option value="5">10 $ SSI (30jrs)</option>
                            
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
</div>

    <!-- Dépot -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="depott" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('mtnbS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Dépôt sur compte MTN  à partir de vos compte avoirs</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input id="input" type="hidden" name="lib" value="depot">
	
	                     <div class="form-group">
	                      <input id="input" type="number" required class="form-control form-control-user" 
	                      pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
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
	                      placeholder="Entrez le montant du crédit en $ SSI" name="forfait">
	                      @if($errors->has('forfait'))
	                        <p style="color: red"> Saisissez le montant en $ SSI</p>
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

     <!-- fin Dépot -->
     
     <!-- Dépot -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="depot" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('mtnbS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff">Dépôt sur compte MTN  à partir de vos compte avoirs</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>
            		</div>
            		<div class="modal-body" style="text-align: left;">
            			Service en maintenance.
            		</div>
            		<div class="modal-footer" >
            		<button data-dismiss="modal" class="btn btn-default" type="button" style="background-color: #5ca945; color : #fff">Annuler</button>
                    
            		</div>
            		 </form>
            </div>
          </div>
        </div>

     <!-- fin Dépot -->

    <!-- P3 -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="p" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
            		<div class="modal-header" style="text-align: left; background-color: #5ca945;">
            			<form class="user" method="post" action="{{ route('mtnbS') }}">
	                    {{ csrf_field() }}
            			<div class="modal-header" style="text-align: left; background-color: #5ca945;">
		                <h4 class="modal-title" style="color : #fff"> CREDIT P3 </h4>
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		              </div>

            		</div>
            		<div class="modal-body" style="text-align: left;">
            			<input id="input" type="hidden" name="lib" value="p3">
	
	                     <div class="form-group">
	                      <input id="input" type="number" required class="form-control form-control-user" 
	                      pattern="229[0-9]{8}" placeholder="Entrez votre numéro" name="numero">
	                      @if($errors->has('numero'))
	                        <p style="color: red"> Saisissez votre numero</p>
	                      @endif
	                    </div>
	
	                    <div class="form-group">
	                      <input id="input" type="number" step="0.00001" min="6" required class="form-control form-control-user" 
	                      placeholder="Entrez le montant du crédit en $ SSI" name="forfait">
	                      @if($errors->has('forfait'))
	                        <p style="color: red"> Saisissez le montant en $ SSI</p>
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
    <!-- fin P3 -->
</section>
@endsection