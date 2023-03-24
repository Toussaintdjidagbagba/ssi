<body style="background: #e5e5e5; padding: 30px;" >

            <div style="max-width: 650px; width: 500px; margin: 0 auto; padding: 20px; background: #fff;">
                <table>
                            <tr style="border: 1px solid white;">
                                
                                <td style="text-align: right; width: 20%">
                                    <img src="https://sourcedusuccesinternational.com/logo.jpeg" style="width: 80px; height: 120px; margin-top: -80px">
                                </td>
                                <td style="text-align: left; width: 50%">
                                    <center> <h1 style="color : #25599C; margin-left: 10px;">La Source du Succès International</h1> </center>
                                </td>
                                <td style=" width: 20%">
                                    <img src="https://sourcedusuccesinternational.com/img/health.jpg" style="width: 100px; height: 120px; margin-top: -80px">
                                </td>
                                
                            </tr>
                        </table>
                <div style=" margin-top: 20px; max-height: 600px; height: 350px; width: 100%">
                        <table>
                            <tr style="border: 1px solid white;">
                                <td style="text-align: left; width: 50%">
                                    Numéro reçu : {{$refrecu}} <br> <br>

                                    <b>Informations de la facture :</b> <br> <br>

                                    Prestation : {{$libelle}} 
                                    <br>
                                    Date du reçu : {{$daterecu}}
                                </td>
                                <td style="text-align: right; width: 50%">
                                    <i>
                                        Identifiant du compte : {{$CodePersoUser}} <br><br>

                                        <b>Informations du client :</b> <br> <br>

                                        Nom :   {{$nom}}<br>
                                        Prénom : {{$prenom}} <br>
                                        Numéro : {{$tel}} <br>
                                        Email : {{$mail}}<br>
                                    </i>
                                    
                                </td>
                                
                            </tr>
                        </table>
                    <br><br>
                    <div style="text-align: left;">
                        <p>
                            Veuillez-vous connecté grâce au lien suivant : <a href="{{$lien}}">{{$lien}}</a>
                            <br>
                            <br>
                            Votre Pseudo est : {{$pseudo}}
                            <br>
                            <br>
                            Votre Email est : {{$mail}}
                            <br>
                            <br>
                            Votre Mot de passe est : {{$pass}}

                        </p>
                    </div>
                    <div>
                        <br>
                        Montant Payer : {{ $montant }} $ SSI / {{$montantf}} F CFA <br>

                        <center>Merci d'avoir choisi la SSI, la plateforme qui vous facilite la vie. <br> <br> 
                            Votre satisfaction, notre priorité.
                        </center>
                    </div>
                </div>
            </div>

            </body>