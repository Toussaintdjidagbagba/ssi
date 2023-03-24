@extends('layouts.template_client')

@section('css')
  <style type="text/css">
    
    @media (min-width: 480px) and (max-width: 780px) {
      
      width :auto ;
    }

    #lag{
      width: 750px;
      text-align: center;
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
                 
  @if(isset($non))
    <div class="row"> 
      <div class="col-lg-12">
        <h3 class="page-header">Mes Filleuls</h3>
        <ol class="breadcrumb">
          <li><i class="fa fa-home">Vous n'être pas encore à l'étape 3 </i></li>
        </ol>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          
        </section>
      </div>
    </div>
  @else

  
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
<?php 

    /*
    <div class="row">
    <center>
      <table>
        <tr>
          <td id="lag">

            @if($ouf[2]->PositionGauche <> "A")
              @foreach($mesfilleuls as $filleul)
                @if($filleul->codeperso == $ouf[2]->PositionGauche)
                    <center> {{ $filleul->nomuser }} ( {{ $filleul->codeperso }} ) <br> {{ $filleul->email }} <br> || <br> ||</center>
                @endif
              @endforeach
            @else
              <center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>
            @endif
          </td> 
          <td id="lag">
            @if($ouf[2]->PositionDroite <> "A")
            @foreach($mesfilleuls as $filleul)
              @if($filleul->codeperso == $ouf[2]->PositionDroite)
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


      <!-- level 3 -->
    <div class="row">
    <center>
      <table>
        <tr>
          <!-- Gauche -->
          <td id="lag">
            <!-- ggg -->
                    <?php 
                      if (isset($filleulggg['nomuser'])) {
                        echo "<center> ".$filleulggg['nomuser']." (  ".$filleulggg['codeperso']."  ) <br> ".$filleulggg['email']."  <br> || <br> ||</center>"; 
                      }
                      else
                      {
                        echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
                      } 
                    ?>
          </td>
          <td id="lag">
            <!-- ggd -->
                    <?php 
                      if (isset($filleulggd['nomuser'])) {
                        echo "<center> ".$filleulggd['nomuser']." (  ".$filleulggd['codeperso']."  ) <br> ".$filleulggd['email']."  <br> || <br> ||</center>"; 
                      }
                      else
                      {
                        echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
                      } 
                    ?>
          </td>
          <td id="lag">
            <!-- gdg -->
                    <?php 
                      if (isset($filleulgdg['nomuser'])) {
                        echo "<center> ".$filleulgdg['nomuser']." (  ".$filleulgdg['codeperso']."  ) <br> ".$filleulgdg['email']."  <br> || <br> ||</center>";
                      }
                      else
                      {
                        echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
                      } 
                    ?>
          </td>
          <td id="lag">
            <!-- gdd -->
                    <?php 
                      if (isset($filleulgdd['nomuser'])) {
                        echo "<center> ".$filleulgdd['nomuser']." (  ".$filleulgdd['codeperso']."  ) <br> ".$filleulgdd['email']."  <br> || <br> ||</center>";
                      }
                      else
                      {
                        echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
                      } 
                    ?>
          </td>
          <!-- Droite -->
          <td id="lag">
            <!-- dgg -->
                    <?php 
                      if (isset($filleuldgg['nomuser'])) {
                        echo "<center> ".$filleuldgg['nomuser']." (  ".$filleuldgg['codeperso']."  ) <br> ".$filleuldgg['email']."  <br> || <br> ||</center>";
                      }
                      else
                      {
                        echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
                      } 
                    ?>
          </td>
          <td id="lag">
            <!-- dgd -->
                    <?php 
                      if (isset($filleuldgd['nomuser'])) {
                        echo "<center> ".$filleuldgd['nomuser']." (  ".$filleuldgd['codeperso']."  ) <br> ".$filleuldgd['email']."  <br> || <br> ||</center>";
                      }
                      else
                      {
                        echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
                      } 
                    ?>
          </td>
          <td id="lag">
            <!-- ddg -->
                    <?php 
                      if (isset($filleulddg['nomuser'])) {
                        echo "<center> ".$filleulddg['nomuser']." (  ".$filleulddg['codeperso']."  ) <br> ".$filleulddg['email']."  <br> || <br> ||</center>";
                      }
                      else
                      {
                        echo "<center>n\a ( n\a ) <br> n\a <br> || <br> ||</center>";
                      } 
                    ?>
          </td>
          <td id="lag">
            <!-- ddd -->
                    <?php 
                      if (isset($filleulddd['nomuser'])) {
                        echo "<center> ".$filleulddd['nomuser']." (  ".$filleulddd['codeperso']."  ) <br> ".$filleulddd['email']."  <br> || <br> ||</center>";
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
    </div> */ ?>
  @endif  
    <!--/.row-->
    </div> 
            </div>

@endsection