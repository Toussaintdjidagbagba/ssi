<?php 
			setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                    date_default_timezone_set('Africa/Porto-Novo');
                    
                  $date1 = strftime('%d-%m-%Y');
                  
                  $date2 = "25".strftime('-%m-%Y');
                  $moisprochain = strftime('%m') + 1;
                  if ($moisprochain >= 12)
                    $moisprochain = 1;
                  $date3 = "1"."-".$moisprochain."-".strftime('-%Y');
                  $timestamp1 = strtotime($date1);
                  $timestamp2 = strtotime($date2);
                  $timestamp3 = strtotime($date3); ?>
                  
                  @if ($timestamp1 >= $timestamp2 || $timestamp1 === $timestamp3) 
                   <li><a href="{{ route('retrait')}}">Retraire de fond</a></li> 
                  @else
                   <!--li><a href="{{ route('retrait')}}">Retraire de fond</a></li--> 
                  @endif