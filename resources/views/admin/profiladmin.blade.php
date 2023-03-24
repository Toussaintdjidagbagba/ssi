@extends('layouts.templaterefonteadmin')

@section('content')


<section class="content">
    <div class="container-fluid">
        
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                    Profil
                    </h2>
                </div>
                <div class="text-center">
                  @include('flash::message')
                </div>
                <div class="body">
                    <form  class="user" style="border: 0.5px solid gray; padding: 20px" method="post" action="{{ route('profiladminS') }}">
                    {{ csrf_field() }}    

                        <label for="nom">Nom<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text"  class="form-control " name="nom" id="nom" value="{{ session('utilisateur')->nom}}" id="nom" placeholder="Entrer votre nom" >
                            </div>
                        </div>

                        <label for="prenom">Prénom<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text"  class="form-control " name="prenom" id="prenom" placeholder="Entrer votre prénom" data-original-title="Entrer votre prénom" value="{{ session('utilisateur')->prenom}}" >
                            </div>
                           
                        </div>

                        <label for="sexe">Profession :<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input value="{{ session('utilisateur')->other}}" type="text" class="form-control"  name="oth" id="sexe" placeholder="Entrer votre Sexe" data-original-title="Entrer votre Sexe" >
                            </div>
                        </div>


                        <label for="tel">Téléphone<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="tel"  class="form-control " value="{{ session('utilisateur')->tel}}" name="tel" id="tel" placeholder="Entrer votre téléphone" data-original-title="Entrer votre téléphone">
                            </div>
                            
                        </div>

                        <label for="nomuser">Nom d'utilisateur<i style="color: red">*</i></label>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control " name="nomuser" id="nomuser" value="{{ session('utilisateur')->login}}" disabled="true" >
                            </div>
                            
                        </div>
                        
                        <br>
                        <button type="submit" name="mettreajour" value="Mettre à jour" id="but" class="btn btn-primary m-t-15 waves-effect">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
      </div>       

    </div>
</section>  



</div>
@endsection