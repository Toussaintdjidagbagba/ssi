@extends('layouts.template_client')

@section('css')
  <style type="text/css">
    
    @media (min-width: 480px) and (max-width: 780px) {
      
      width :auto ;
    }

    #lag{
      width: 550px;
      text-align: center;
      font-size: 12px;
    }

    #lag1{
      width: 850px;
      text-align: center;
      font-size: 12px;
    }

    .horizontal-scrollable > .row { 
            overflow-x: auto; 
            white-space: nowrap; 
    }

    .horizontal-scrollable > .row > .col-xs-4 { 
            display: inline-block; 
            float: none; 
        } 
        /* Decorations */ 
          
        .col-xs-4 { 
            color: white; 
            font-size: 24px; 
            padding-bottom: 20px; 
            padding-top: 18px; 
        } 
          
        .col-xs-4:nth-child(2n+1) { 
            background: green; 
        } 
          
        .col-xs-4:nth-child(2n+2) { 
            background: black; 

  </style>

@endsection

@section('content')
	<div class="row"> 
      <div class="col-lg-12">
        <h3 class="page-header">Mes Filleuls</h3>
        <ol class="breadcrumb">
          <li><i class="fa fa-home"></i></li>
        </ol>
      </div>
    </div>

  <div class="container horizontal-scrollable"> 
    <div class="row text-center"> 
                 

    <div class="row">
    <center>
      <table>
        <tr>
          <td id="lag">
              <center>{{ $moi[0]->nomuser }} ( {{ $moi[0]->codeperso }} ) <br> {{ $moi[0]->email }} <br> || <br> ||</center>
          </td> 
        </tr>
      </table>  
    </center>
    </div>

    <br>

    <div class="row">
    <center>
      <table>
        <tr>
          <td id="lag1">
            @if($ouf[0]->PositionGauche <> "A")
            @foreach($mesfilleuls as $filleul)
              @if($filleul->codeperso == $ouf[0]->PositionGauche)
                  <center> {{ $filleul->nomuser }} ( {{ $filleul->codeperso }} ) <br> {{ $filleul->email }} <br> || <br> ||</center>
              @endif
            @endforeach
            @else
              <center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>
            @endif
          </td> 
          <td id="lag1">
            @if($ouf[0]->PositionDroite <> "A")
            @foreach($mesfilleuls as $filleul)
              @if($filleul->codeperso == $ouf[0]->PositionDroite)
                  <center> {{ $filleul->nomuser }} ( {{ $filleul->codeperso }} ) <br> {{ $filleul->email }} <br> || <br> ||</center>
              @endif
            @endforeach
            @else
              <center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>
            @endif
          </td> 
        </tr>
      </table>  
    </center>
    </div>

    <br>

    <div class="row">
    <center>
      <table>
        <tr>
          <td id="lag">
            <?php 

              if (isset($filleulg['nomuser'])) {
                // identifiant de mon gauche
                //dd($filleuld['nomuser']);
                echo "<center> ".$filleulg['nomuser']." (  ".$filleulg['codeperso']."  ) <br> ".$filleulg['email']."  <br> || <br> ||</center>"; 
              }
              else
              {
                echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
              } 
            ?>
          </td> 
          <td id="lag">
              
              <?php 

              if (isset($filleuld['nomuser'])) {
                // identifiant de mon gauche
                //dd($filleuld['nomuser']);
                echo "<center> ".$filleuld['nomuser']." (  ".$filleuld['codeperso']."  ) <br> ".$filleuld['email']."  <br> || <br> ||</center>"; 
              }
              else
              {
                echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
              } 
            ?>
          </td>
          <td id="lag">
            <?php 
              //dd($filleuldg);
              if (isset($filleuldg['nomuser'])) {
                // identifiant de mon gauche
                //dd($filleuld['nomuser']);
                echo "<center> ".$filleuldg['nomuser']." (  ".$filleuldg['codeperso']."  ) <br> ".$filleuldg['email']."  <br> || <br> ||</center>"; 
              }
              else
              {
                echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
              } 
            ?>
          </td> 
          <td id="lag">
             <?php 

              if (isset($filleuldd['nomuser'])) {
                // identifiant de mon gauche
                //dd($filleuld['nomuser']);
                echo "<center> ".$filleuldd['nomuser']." (  ".$filleuldd['codeperso']."  ) <br> ".$filleuldd['email']."  <br> || <br> ||</center>"; 
              }
              else
              {
                echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
              } 
            ?>
          </td>  
        </tr>
      </table>  
    </center>
    </div>
    <br><br>
       </div> 
            </div>

@endsection