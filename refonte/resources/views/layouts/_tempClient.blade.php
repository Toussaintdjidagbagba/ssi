<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="La plateforme qui vous conduit au sommet.">
  <meta name="author" content="SSI">

  <link rel="shortcut icon" href="{{ asset('img/logo.jpeg') }}">

  <title>Mon Compte SSI</title>
  <meta name="keywords" content="keywords,here">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
  <link href="cssnew/tailwind.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>

  @yield('css')

  <style type="text/css">
        
            .alert-success {
              background-color: #dff8e3;
              border-color: #4CAF50;
              color: #4CAF50;
              border-radius: 50px;
            }
        
            .dataTable {
              display: block;
              width: 100%;
              margin: 1em 0;
            }
        
            .dataTable thead, .dataTable tbody, .dataTable thead tr, .dataTable th {
              display: block;
            }
        
            .dataTable thead {
              float: left;
            }
        
            .dataTable tbody {
              width: auto;
              position: relative;
              overflow-x: auto;
            }
        
            .dataTable td, .dataTable th {
              padding: .625em;
              line-height: 1.5em;
              border-bottom: 1px dashed #ccc;
              box-sizing: border-box;
              overflow-x: hidden;
              overflow-y: auto;
            }
        
            .dataTable th {
              text-align: left;
              background: rgba(0, 0, 0, 0.14);
              border-bottom: 1px dashed #aaa;
            }
        
            .dataTable tbody tr {
              display: table-cell;
            }
        
            .dataTable tbody td {
              display: block;
            }
        
            .dataTable tr:nth-child(odd) {
              background: rgba(0, 0, 0, 0.07);
            }

    @media screen and (min-width: 50em) {

      .dataTable {
        display: table;
      }

      .dataTable thead {
        display: table-header-group;
        float: none;
      }

      .dataTable tbody {
        display: table-row-group;
      }

      .dataTable thead tr, .dataTable tbody tr {
        display: table-row;
      }

      .dataTable th, .dataTable tbody td {
        display: table-cell;
      }

      .dataTable td, .dataTable th {
        width: auto;
      }

    }

  </style>

</head>


<body class="bg-yellow-900 font-sans leading-normal tracking-normal mt-12">

  <!--Nav-->
  <nav class="bg-yellow-900 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">

    <div class="flex flex-wrap items-center">
      <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
        <a href="#"> 
          <a href="{{ route('index') }}" class="logo"><img src="{{ asset('img/logo.jpeg') }}" style="margin-left: 20px;margin-bottom: -22px; height: 50px; margin-top: -2px; width: 50px" /></a>
          <span class="text-xl " ><h2 style="margin-left: 50px"></h2></span>
        </a>
      </div>

      <div class="flex flex-1 md:w-1/3 justify-center md:justify-start text-white px-2">
          
          
      </div>

      <div class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
        <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
          <li class="flex-1 md:flex-none md:mr-3">
            <a class="inline-block py-2 px-4 text-white no-underline" style="font-size: small; margin-top : 10px; padding-top : 15px" href="{{ route('index') }}">SITE</a>
          </li>

          <li class="flex-1 md:flex-none md:mr-3">
            <div class="relative inline-block">
              <button style="font-size: small; margin-top : 5px; padding-top : 15px" onclick="toggleDD('myDropdown')" class="drop-button text-white focus:outline-none"><span class="pr-2"></span>FORMATION
              <!--svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg--></button>
                <div id="myDropdown" class="dropdownlist absolute bg-yellow-900 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                  <input type="text" class="drop-search p-2 text-gray-600" placeholder="Rechercher.." id="myInput" onkeyup="filterDD('myDropdown','myInput')">
                  <a style="font-size: small;" href="{{ route('regle') }}" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-award fa-fw"></i> Règle du MLM</a>
                  <a style="font-size: small;" href="{{ route('formation')}}" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-book fa-fw"></i> Mes formations</a>

                </div>
              </div>
            </li>

            <li class="flex-1 md:flex-none md:mr-3">
              <div class="relative inline-block">
                <button style="font-size: small;margin-top : 5px; padding-top : 15px" onclick="toggleDD('myDropdown1')" class="drop-button text-white focus:outline-none"> <span class="pr-2"></span> 
                PORTEFEUILLE <!--svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg--></button>
                  <div id="myDropdown1" class="dropdownlist absolute bg-yellow-900 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                    <input type="text" class="drop-search p-2 text-gray-600" placeholder="Rechercher.." id="myInput" onkeyup="filterDD('myDropdown1','myInput')">
                    <a href="{{ route('gains') }}" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-briefcase fa-fw"></i> Mes gains</a>
                    <a href="{{ route('retrait')}}" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-briefcase fa-fw"></i> Retrait de fond</a>
                    <div class="border border-gray-800"></div>
                    <a href="{{ route('transfert')}}" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-sign-out-alt fa-fw"></i> Transfert de fond</a>
                    <a href="{{ route('vte')}}" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-sign-out-alt fa-fw"></i> Transfert C.V vers Virtuel</a>
                    <a href="{{ route('cte')}}" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-sign-out-alt fa-fw"></i> Transfert C.V vers Espèce</a>
                  </div>
                </div>
              </li>

              <li class="flex-1 md:flex-none md:mr-3">
                <div class="relative inline-block">
                  <button style="font-size: small;margin-top : 5px; padding-top : 15px" onclick="toggleDD('myDropdown2')" class=" uppercase drop-button text-white focus:outline-none"> <span class="pr-2"></span> 
                    Menu <!--svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg--></button>
                      <div id="myDropdown2" class="dropdownlist absolute bg-yellow-900 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                        <a href="{{ route('profil') }}" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-user fa-fw"></i> Profil</a>
                        <div class="border border-gray-800"></div>
                        <a href="{{ route('admin.logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="p-2 hover:bg-yellow-900 text-white text-sm no-underline hover:no-underline block"><i class="fas fa-sign-in-alt fa-fw"></i> Déconnexion</a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                        </form>
                      </div>
                    </div>
                  </li>

                </ul>
              </div>
            </div>

          </nav>


          <div class="flex flex-col md:flex-row">

            @yield('content')


          </div>

          <!-----------------------------------Session-storage---------------------------------------->
          <script>// <![CDATA[
          if (!sessionStorage.pageLoadCount) {
          sessionStorage.pageLoadCount = 0;
          }
          sessionStorage.pageLoadCount = parseInt(sessionStorage.pageLoadCount) + 1;
          document.getElementById('count').textContent = sessionStorage.pageLoadCount;
          //document.getElementById('fond').style.display = "none";
          document.getElementById('popin').style.display = "none";
          // ]]></script>

          <script>
                           var smallBreak = 800; // Your small screen breakpoint in pixels
                           var columns = $('.dataTable tr').length;
                           var rows = $('.dataTable th').length;

                           $(document).ready(shapeTable());
                           $(window).resize(function() {
                            shapeTable();
                          });

                           function shapeTable() {
                            if ($(window).width() < smallBreak) {
                              for (i=0;i < rows; i++) {
                                var maxHeight = $('.dataTable th:nth-child(' + i + ')').outerHeight();
                                for (j=0; j < columns; j++) {
                                  if ($('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').outerHeight() > maxHeight) {
                                    maxHeight = $('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').outerHeight();
                                  }
                                  if ($('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').prop('scrollHeight') > $('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').outerHeight()) {
                                    maxHeight = $('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').prop('scrollHeight');
                                  }
                                }
                                for (j=0; j < columns; j++) {
                                  $('.dataTable tr:nth-child(' + j + ') td:nth-child(' + i + ')').css('height',maxHeight);
                                  $('.dataTable th:nth-child(' + i + ')').css('height',maxHeight);
                                }
                              }
                            } else {
                              $('.dataTable td, .dataTable th').removeAttr('style');
                            }
                          }
                        </script>


                        <script>
                          /*Toggle dropdown list*/
                          function toggleDD(myDropMenu) {
                            document.getElementById(myDropMenu).classList.toggle("invisible");
                          }
                          /*Filter dropdown options*/
                          function filterDD(myDropMenu, myDropMenuSearch) {
                            var input, filter, ul, li, a, i;
                            input = document.getElementById(myDropMenuSearch);
                            filter = input.value.toUpperCase();
                            div = document.getElementById(myDropMenu);
                            a = div.getElementsByTagName("a");
                            for (i = 0; i < a.length; i++) {
                              if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                                a[i].style.display = "";
                              } else {
                                a[i].style.display = "none";
                              }
                            }
                          }
        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function(event) {
          if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
            var dropdowns = document.getElementsByClassName("dropdownlist");
            for (var i = 0; i < dropdowns.length; i++) {
              var openDropdown = dropdowns[i];
              if (!openDropdown.classList.contains('invisible')) {
                openDropdown.classList.add('invisible');
              }
            }
          }
        }
      </script>


    </body>

    </html>
