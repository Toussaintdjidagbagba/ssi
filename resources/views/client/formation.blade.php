@extends('layouts.templaterefonte')

@section('content')

<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <div class="page-body">
                                      <div class="row"> 
<div class="col-lg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Mes formations</h5>
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="fa fa-chevron-left"></i></li>
                                                                <li><i class="fa fa-window-maximize full-card"></i></li>
                                                                <li><i class="fa fa-minus minimize-card"></i></li>
                                                                <li><i class="fa fa-refresh reload-card"></i></li>
                                                                <li><i class="fa fa-times close-card"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <!-- Tab panes -->
                                                        <div class="tab-content card-block">
                                                            <div class="tab-pane active" role="tabpanel">

                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Titre Formation</th>
                                                                            <th>Document</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        @forelse($formations as $formation)
                                                                          <tr>
                                                                            <td>{{ $formation->id }}</td>
                                                                            <td>{{ $formation->titre }}</td>
                                                                            <td>{{ $formation->doc }}</td>
                                                                            <td style="text-align: center !important;">
                                                                                <form action="{{ route('formationS') }}" method="post">
                                                                                    {{ csrf_field() }}
                                                                                    <input type="hidden" value="{{ $formation->id }}" name="id" />
                                                                                    <input type="submit"  style="margin-right: 20px; background-color: blue; color: #fff;" value="SUPPRIMER" />
                                                                                </form>
                                                                            </td>
                                                                        </tr>
                                                                      @empty
                                                                        <tr >
                                                                          <td colspan="4" style="text-align: center;">Pas de cours disponible.</td>
                                                                        </tr>
                                                                      @endforelse
                                                                    </table>
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
                    </div>
    
    <!--/.row-->

@endsection