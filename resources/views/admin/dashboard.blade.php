@extends('layouts.templaterefonteadmin')

@section('meta')
    <meta http-equiv="refresh" content="15">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        
        <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('canalservice') }}">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE CANAL+</div>
                        <div> <b> {{ $ncanals }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('mtnmoovservice') }}">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE MTN et MOOV</div>
                        <div> <b> {{ $nmtnmoovs }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('achat$ssi') }}">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE Achat de gain</div>
                        <div> <b> {{ $nachats }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('getSRVISA') }}">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE VISA</div>
                        <div> <b> {{ $nvisas }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('sbeecarteservice') }}">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE SBEE CARTE</div>
                        <div> <b> {{ $nbeecartes }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('sbeeconventionnelservice') }}">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE SBEE FACTURE</div>
                        <div> <b> {{ $nbeeconventiels }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('sonebservice') }}">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE SONEB</div>
                        <div> <b> {{ $nsonebs }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('retraitmtn') }}">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT MTN</div>
                        <div> <b> {{ $nmtns }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('retraitmoov') }}">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT MOOV</div>
                        <div> <b> {{ $nmoovs }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('retraitwestern') }}">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT WESTERN UNION</div>
                        <div> <b> {{ $nwesterns }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('retraitperfect') }}">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT PERFECT MONEY</div>
                        <div> <b> {{ $nperfects }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('retraitgram') }}">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT MONEY GRAM</div>
                        <div> <b> {{ $ngrams }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>



            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('retraittrust') }}">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">DEMANDE RETRAIT TRUST WALLET</div>
                        <div> <b> {{ $ntrusts }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="#">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">GAIN RECOLTER</div>
                        <div> <b> {{ $compterecu[0]->compteavoirrecu }} $ SSI </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="#">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">GAIN DEBITER</div>
                        <div> <b> {{ $compterecu[0]->compteavoirsortant }} $ SSI  </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="#">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">Commission sur vente</div>
                        <div> <b> 0 $ SSI </b></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('listclient') }}">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">NOMBRE DE CLIENT</div>
                        <div> <b> {{ $allclient }}</b></div>
                    </div>
                </div>
              </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('listvendeur') }}">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">NOMBRE DE VENDEUR</div>
                        <div> <b> {{ $allvendeur }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div>
            <!--div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
              <a style="text-decoration: none; cursor: pointer" href="{{ route('achat$ssi') }}">
                <div class="info-box bg-light-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">SERVICE Achat de gain</div>
                        <div> <b> {{ $nachats }} en attente </b></div>
                    </div>
                </div>
              </a>
            </div-->


        </div>

    </div>
</section>

@endsection