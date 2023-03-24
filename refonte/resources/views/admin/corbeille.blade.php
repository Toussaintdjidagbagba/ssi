@extends('layouts.template_admin')

@section('css')
@endsection

@section('content')
    <div class="row">
        
      <div class="col-lg-12">
        
        <div class="text-center">
                @include('flash::message')
              </div>
        <ol class="breadcrumb">
          <li><i class="fa fa-home"></i></li>
          <li style="text-align: right"> <a href="{{ route('corbeille') }}">Liste des demandes supprimer </a>  </li>
        </ol>
      </div>
    </div>
    <div class="col-lg-4">
        
    </div>
    <div class="col-lg-6">
        
        <form class="form-inline" method="get" action="{{ route('search') }}">
            <select class="form-control mr-sm-2" type="text" name="service">
                <option></option>
            </select>
    </div>
    <div class="col-lg-2">
        <button class="btn btn-outline-info my-2 my-sm-0" type="submit" style="background-color: blue; color: white">Rechercher <i class="fa fa-search"></i></button>
        </form>
        <br> <br>
    </div>
    
    <!--/.row-->
    <div class="horizontal-scrollable">
    <div class="row">
        
      <div class="col-lg-12">
        <section class="panel">
          <table class="table table-striped table-advance table-hover">
            <tbody>
              <tr style="font-size: 14px">
                <th style="text-align: center; background-color: #458b00; color: white"> Reference</th>
                <th style="text-align: center; background-color: #458b00; color: white"> Identifiant Client </th>
                <th style="text-align: center; background-color: #458b00; color: white"> Action</th>
              </tr>
              <tr style="font-size: 15px; color: #458b00;">
                  <td colspan="3" style="text-align: center; background-color: #f0f8ff">SONEB</td>
              </tr>
              @forelse($soneb as $dechet)
                <tr style="text-align: center">
                  <td>{{ $dechet->RefRecu }} </td>
                  <td> {{ $dechet->identifiant }}</td>
                  <td>
                  <a class="btn btn-outline-primary btn-circle btn-icon" 
                          style="color:red;font-weight:bold;" 
                          
                          href="{{ url('admin/restaurer/'.$dechet->RefRecu.'/soneb')}}">
                      <i class="fa fa-trash"></i>Restaurer </a> 
                   </td>
                </tr>
              @empty
                <tr >
                  <td colspan="3" style="text-align: center; color: red"></td>
                </tr>
              @endforelse
              
              <!-- Fin SONEB -->
              <tr style="font-size: 15px; color: #458b00;">
                  <td colspan="3" style="text-align: center; background-color: #f0f8ff">SBEE CARTE</td>
              </tr>
              @forelse($sbeecarte as $dechet)
                <tr style="text-align: center">
                  <td>{{ $dechet->RefRecu }} </td>
                  <td> {{ $dechet->identifiant }}</td>
                  <td> <a class="btn btn-outline-primary btn-circle btn-icon" 
                          style="color:red;font-weight:bold;" 
                          
                          href="{{ url('admin/restaurer/'.$dechet->RefRecu.'/sbeecarte')}}">
                      <i class="fa fa-trash"></i>Restaurer </a> 
                   </td>
                </tr>
              @empty
                <tr >
                  <td colspan="3" style="text-align: center; color: red"></td>
                </tr>
              @endforelse
              
              <!-- Fin SBEE CARTE -->
              
              <tr style="font-size: 15px; color: #458b00;">
                  <td colspan="3" style="text-align: center; background-color: #f0f8ff">SBEE FACTURE</td>
              </tr>
              @forelse($sbeeconventiel as $dechet)
                <tr style="text-align: center">
                  <td>{{ $dechet->RefRecu }} </td>
                  <td> {{ $dechet->identifiant }}</td>
                  <td> <a class="btn btn-outline-primary btn-circle btn-icon" 
                          style="color:red;font-weight:bold;" 
                          
                          href="{{ url('admin/restaurer/'.$dechet->RefRecu.'/sbeefacture')}}">
                      <i class="fa fa-trash"></i>Restaurer </a> 
                   </td>
                </tr>
              @empty
                <tr >
                  <td colspan="3" style="text-align: center; color: red"></td>
                </tr>
              @endforelse
              
              <!-- Fin SBEE FACTURE -->
              
            </tbody>
          </table>
        </section>
      </div>
    </div>
    </div>

@endsection