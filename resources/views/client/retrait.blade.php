@extends('layouts.templaterefonte')

@section('css')
  
  
@endsection

@section('content')

<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row">
                                                  
                                                  <!-- Titre -->
                                                      <div class="text-center">
                                                        <h1 class="h4 text-gray-900 mb-4">Retrait de fond</h1>
                                                      </div>
                                           
                                                      <div class="text-center">
                                                        @include('flash::message')
                                                      </div>
                                                
                                                <!-- Retrait MTN-->
                                                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-blue d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span>MTN MONEY</h4>
                                                        <p class="m-b-20"> </p>
                                                        <button class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#mtn">Cliquez</button>
                                                    </div>
                                                </div>
                                                </div>

                                                <!-- Retrait MOOV -->
                                                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-blue d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span>FLOOZ MOOV</h4>
                                                        <p class="m-b-20"> </p>
                                                        <button class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#moov">Cliquez</button>
                                                    </div>
                                                </div>
                                                </div>

                                                <!-- Retrait -->

                                                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-blue d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span>WESTERN UNION</h4>
                                                        <p class="m-b-20"> </p>
                                                        <button class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#werstern">Cliquez</button>
                                                    </div>
                                                </div>
                                                </div>

                                                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-blue d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span>MONEY GRAM </h4>
                                                        <p class="m-b-20"> </p>
                                                        <button class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#moneygram">Cliquez</button>
                                                    </div>
                                                </div>
                                                </div>

                                                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-blue d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span>PERFECT MONEY</h4>
                                                        <p class="m-b-20">  </p>
                                                        <button class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#perfect">Cliquez</button>
                                                    </div>
                                                </div>
                                                </div>

                                                <div class="col-md-12 col-lg-4">
                                                <div class="card">
                                                    <div class="card-block text-center">
                                                        <i class="ti-reload text-c-blue d-block f-40"></i>
                                                        <h4 class="m-t-20"><span class="text-c-blue">
                                                          
                                                        </span> TRUST WALLET</h4>
                                                        <p class="m-b-20"> </p>
                                                        <button class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#trust">Cliquez</button>
                                                    </div>
                                                </div>
                                                </div>
                                                  
                                              <div class="" style="padding-left : 20%; padding-right : 20%; padding-top : -5%">
                                                        
                                                        <div class="row align-items-center">
                                                          <div class="" >
                                                      <!-- Formulaire MTN -->
                                                      <div class="modal fade" id="mtn" tabindex="-1" role="dialog" aria-labelledby="mtn" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="mtn">Retrait sur MTN</h5>
                                                              <i style="color : red; text-align : left; font-size:9px">Veuillez entrer l'indicatif suivi du numéro. Exemple : +22900000000</i>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                             
                                                              <form class="user" method="post" action="{{ route('retraitmtnS') }}">
                                                                {{ csrf_field() }}
                                                              
                                                                   <div class="form-group">
                                                                      <label>Renseigner code OTP <i style="color: red">*</i></label>
                                                                      <input required pattern="[0-9]+" type="text" class="form-control" name="otpmtn" placeholder="Entrer le code otp " value="{{ old('otp') }}" data-original-title="Entrer le code otp">
                                                                      
                                                                   </div>
                                         
                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Montant <i style="color: red">*</i></label>
                                                                    <input required pattern="^+[0-9]+" min="0" max="{{session('max')}}" step="0.00001" type="number" class="form-control" name="montantmtn" id="montantmtn" placeholder="Entrer le montant" data-original-title="Entrer le montant">
                                                                    
                                                                  </div>

                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Numéro du compte<i style="color: red">*</i></label>
                                                                    <input required pattern="[0-9]+" type="number" class="form-control " name="numerom" id="numerom" placeholder="Entrer votre numero : +22961000000" data-original-title="Entrer votre numero">
                                                                      </div>
                                                                </div>

                                                                  <div class="form-group">
                                                                   <label>Motif<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Z a-z0-9]+" type="nom" class="form-control " name="nomm" id="nomm" placeholder="Entrer le motif " data-original-title="Entrer le nom du compte">
                                                                   </div>

                                                                <input type="submit" name="Valider le retrait" value="Valider le retrait" class="btn btn-user btn-block" style="background-color: #ffc961" />
                                                                
                                                              </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>

                                                      <!-- Fin formulaire mtn -->


                                                      <!-- Formulaire MOOV -->
                                                      <div class="modal fade" id="moov" tabindex="-1" role="dialog" aria-labelledby="moov" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                          <div style="background-color: rgba(250,250,250,0.90);" class="modal-content" >
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="moov">Retrait sur MOOV</h5>
                                                              <i style="color : red; text-align : left; font-size:9px">Veuillez entrer l'indicatif suivi du numéro. Exemple : +22900000000</i>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                              <form class="user" method="post" action="{{ route('retraitmoovS') }}">
                                                                {{ csrf_field() }}
                                                              
                                                                <div class="form-group">
                                                                  <label>Renseigner code OTP <i style="color: red">*</i></label>
                                                                  <input required pattern="[0-9]+" type="text" class="form-control" name="otpmoov" placeholder="Entrer le code otp" value="{{ old('otp') }}" data-original-title="Entrer le code otp">
                                                                  
                                                                </div>
                                         
                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Montant <i style="color: red">*</i></label>
                                                                    <input required pattern="[0-9]+" min="0" max="{{session('max')}}" step="0.00001" type="number" class="form-control " name="montantmoov" id="montantmoov" placeholder="Entrer le montant" data-original-title="Entrer le montant">
                                                                  </div>

                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Numero du compte<i style="color: red">*</i></label>
                                                                    <input required pattern="[0-9]+" type="number" class="form-control " name="numeromoov" id="numeromoov" placeholder="Entrer votre numero" data-original-title="Entrer votre numero">
                                                                    
                                                                  </div>
                                                                </div>
                                                                  <div class="form-group">
                                                                    <label>Motif<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Z a-z0-9]+" type="text" class="form-control " name="nommoov" id="nom" placeholder="Entrer le motif" data-original-title="Entrer le nom du compte">
                                                                 </div>

                                                                <input type="submit" name="Valider le retrait" value="Valider le retrait" class="btn btn-user btn-block" style="background-color: #0000ff" />
                                                                
                                                              </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>


                                                       <!-- Formulaire western -->
                                                      <div class="modal fade" id="werstern" tabindex="-1" role="dialog" aria-labelledby="werstern" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                          <div style="background-color: rgba(250,250,250,0.90);" class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="werstern">Retrait sur Western Union</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              <form class="user" method="post" action="{{ route('retraitwesternS') }}">
                                                                {{ csrf_field() }}
                                                              
                                                                <div class="form-group">
                                                                    <label>Renseigner code OTP <i style="color: red">*</i></label>
                                                                    <input required pattern="[0-9]+" type="text" class="form-control" name="otpwestern" placeholder="Entrer le code otp " value="{{ old('otp') }}" data-original-title="Entrer le code otp">
                                                                    
                                                                </div>

                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Nom<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z 0-9]+" type="text" class="form-control " name="nomwest" id="nomwest" placeholder="Entrer votre nom" data-original-title="Entrer votre nom">
                                                                </div>
                                                                
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Prénom<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z 0-9]+" type="text" class="form-control " name="prenomwest" id="prenomwest" placeholder="Entrer votre prenom" data-original-title="Entrer votre prenom">
                                                                  </div>
                                                                </div>
                                         
                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Adresse<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z: 0-9]+" type="text" class="form-control " name="addwest" id="addwest" placeholder="Entrer votre adresse" data-original-title="Entrer votre adresse">
                                                                   
                                                                  </div>
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Ville<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z' 0-9]+" type="text" class="form-control " name="villewest" id="villewest" placeholder="Entrer votre ville" data-original-title="Entrer votre ville">
                                                                    
                                                                  </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Pays<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z 0-9]+" type="text" class="form-control " name="payswest" id="payswest" placeholder="Entrer votre pays" data-original-title="Entrer votre pays">
                                                                    
                                                                  </div>

                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Montant<i style="color: red">*</i></label>
                                                                    <input required pattern="[.0-9]+" type="number" class="form-control " name="montwest" id="montwest" placeholder="Entrer le montant" data-original-title="Entrer le montant">
                                                                    
                                                                  </div>
                                                                </div>
                                                                <div class="form-group">
                                                                   <label>Motif<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z 0-9]+" type="text" class="form-control " name="motifwest" id="motifwest" placeholder="Entrer le motif" data-original-title="Entrer le motif">
                                                                    
                                                                </div>
                                                                <input type="submit" name="Valider le retrait" value="Valider le retrait" class="btn btn-user btn-block" style="background-color: #000; color : yellow" />
                                                                
                                                              </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>

                                                      <!-- Fin formulaire western -->


                                                       <!-- Formulaire Money gram -->
                                                      <div class="modal fade" id="moneygram" tabindex="-1" role="dialog" aria-labelledby="moneygram" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                          <div style="background-color: rgba(250,250,250,0.90);" class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="moneygram">Retrait sur Money Gram</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              <form class="user" method="post" action="{{ route('retraitgramS') }}">
                                                                {{ csrf_field() }}
                                        						
                                        						            <div class="form-group">
                                                                      <label>Renseigner code OTP <i style="color: red">*</i></label>
                                                                      <input required pattern="[0-9]+" type="number" class="form-control " name="otpgram" placeholder="Entrer le code otp " value="{{ old('otp') }}" data-original-title="Entrer le code otp">
                                                                      
                                                                </div>
                                                              
                                                                 <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Nom<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z ]+" type="text" class="form-control " name="nomgram" id="nomgram" placeholder="Entrer votre nom" data-original-title="Entrer votre nom">
                                                                    
                                                                  </div>
                                        						  
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Prénom<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z ]+" type="text" class="form-control " name="prenomgram" id="prenomgram" placeholder="Entrer votre prenom" data-original-title="Entrer votre prenom">
                                                                    
                                                                  </div>
                                                                 </div>
                                         
                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Adresse<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z 0-9]+" type="text" class="form-control " name="addgram" id="addgram" placeholder="Entrer votre adresse" data-original-title="Entrer votre adresse">
                                                                    
                                                                  </div>

                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Ville<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z 0-9]+" type="text" class="form-control " name="villegram" id="villegram" placeholder="Entrer votre ville" data-original-title="Entrer votre ville">
                                                                    
                                                                  </div>
                                        						            </div>

                                                                <div class="form-group row">
                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Pays<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z ]+"type="text" class="form-control " name="paysgram" id="paysgram" placeholder="Entrer votre pays" data-original-title="Entrer votre pays">
                                        							
                                                                  </div>

                                                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                                                    <label>Montant<i style="color: red">*</i></label>
                                                                    <input required pattern="[0-9]+" type="number" class="form-control " name="montgram" id="montwest" placeholder="Entrer le montant" data-original-title="Entrer le montant">
                                                                    
                                                                  </div>
                                        						            </div>

                                                                <div class="form-group">
                                                                  
                                                                    <label>Motif<i style="color: red">*</i></label>
                                                                    <input required pattern="[A-Za-z]+" type="text" class="form-control " name="motifgram" id="motifgram" placeholder="Entrer le motif" data-original-title="Entrer le motif">
                                                                    
                                                                  
                                                                </div>

                                                                <input type="submit" name="Valider le retrait" value="Valider le retrait" class="btn btn-user btn-block" style="background-color: red" />
                                                                
                                                              </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>

                                                      <!-- Fin formulaire money gram -->


                                                       <!-- Formulaire perfect -->
                                                      <div class="modal fade" id="perfect" tabindex="-1" role="dialog" aria-labelledby="perfect" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                          <div style="background-color: rgba(250,250,250,0.90);" class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="perfect">Retrait sur Perfet Money</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              <form class="user" method="post" action="{{ route('retraitperfectS') }}">
                                                                {{ csrf_field() }}
                                                              
                                                    						<div class="form-group">
                                                                                <label>Renseigner code OTP <i style="color: red">*</i></label>
                                                                                <input required pattern="[0-9]+" type="text" class="form-control " name="otpperfect" placeholder="Entrer le code otp " value="{{ old('otp') }}" data-original-title="Entrer le code otp">
                                                                                
                                                    						</div>
                                                    						
                                                    						<div class="form-group">
                                                                                <label>Motif<i style="color: red">*</i></label>
                                                                                <input required pattern="[A-Za-z ]+" type="text" class="form-control " name="intitulerperfect" id="nomgram" placeholder="Entrer le motif" data-original-title="Entrer le motif">
                                                                                
                                                                            </div>
                                                    						
                                                    						<div class="form-group">
                                                                                <label>Montant<i style="color: red">*</i></label>
                                                                                <input required pattern="[0-9]+" type="number" class="form-control " name="montperfect" id="montwest" placeholder="Entrer le montant" data-original-title="Entrer le montant">
                                                                            </div>
                                                    						   
                                                    						<div class="form-group"> 
                                                                                <label>Lien ou code <i style="color: red">*</i></label>
                                                                                <input type="text" class="form-control " name="lienperfect" placeholder="Entrer votre adresse $US" data-original-title="Entrer votre adresse $US">
                                                    						</div> 
                                                                  
                                                    						<input type="submit" name="Valider le retrait" value="Valider le retrait" class="btn btn-user btn-block" style="background-color: #000; color : orange" />
                                                                
                                                              </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                        			   <!-- fin perfect -->
                                        			  
                                        			  <!-- Formulaire trust -->
                                                      <div class="modal fade" id="trust" tabindex="-1" role="dialog" aria-labelledby="trust" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                          <div style="background-color: rgba(250,250,250,0.90);" class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="trust">Retrait sur Trust WALLET / COIN BASE</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              <form class="user" method="post" action="{{ route('retraittrustS') }}">
                                                                {{ csrf_field() }}
                                                              
                                                  					  <div class="form-group">
                                                                                <label>Renseigner code OTP <i style="color: red">*</i></label>
                                                                                <input required pattern="[0-9]+" type="text" class="form-control" name="otptrust" placeholder="Entrer le code otp " value="{{ old('otp') }}" data-original-title="Entrer le code otp">
                                                  							  
                                                                        </div>
                                                  						
                                                  					<div class="form-group">
                                                                              <label>Montant<i style="color: red">*</i></label>
                                                                              <input required pattern="[0-9]+" type="number" class="form-control " name="monttrust" id="montwest" placeholder="Entrer le montant" data-original-title="Entrer le montant">
                                                                      </div>
                                                  					<div class="form-group">
                                                                          <label>Motif<i style="color: red">*</i></label>
                                                                          <input required pattern="[A-Za-z ]+" type="text" class="form-control " name="intitulertrust" placeholder="Entrer le motif" data-original-title="Entrer le motif">
                                                            </div>
                                        					
                                                              <div class="form-group">
                                                                    <label>Lien ou code wallet<i style="color: red">*</i></label>
                                                                    <input type="text" class="form-control " name="lientrust" placeholder="Entrer votre adresse Bitcoin" data-original-title="Entrer votre adresse Bitcoin">
                                                                    
                                                                </div> 
                                                      
                                                                <input type="submit" name="Valider le retrait" value="Valider le retrait" class="btn btn-user btn-block" style="background-color: #000; color: #6495ed" />
                                                                
                                                              </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                                                              
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <hr>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                          
                                      </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

@endsection