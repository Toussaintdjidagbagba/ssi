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
								<img src="https://sourcedusuccesinternational.com/img/sbee.jpg" style="width: 100px; height: 120px; margin-top: -80px">
							</td>
								
							</tr>
						</table>
				<div style="background-image: ; margin-top: 20px; max-height: 600px; height: 350px; width: 100%">
						<table>
							<tr style="border: 1px solid white;">
								<td style="text-align: left; width: 50%">
									Numéro reçu :  {{ $refrecu}}  <br> <br>

									<b>Informations de la facture :</b> <br> <br>

									Prestation :  {{ $libelle}}  
									<br>
									Référence :  {{ $police}} 
									<br>
									Date du reçu :  {{ $daterecu}} 
								</td>
								<td style="text-align: right; width: 50%">
									<i>
										Identifiant du compte :  {{ $CodePersoUser}}  <br><br>

										<b>Informations du client :</b> <br> <br>

										Nom :    {{ $nom}} <br>
										Prénom :  {{ $prenom}}  <br>
										Numéro :  {{ $WhatsApp}}  <br>
										Email :  {{ $mail}} <br>
									</i>
									
								</td>
								
							</tr>
						</table>
					<br><br>
					<div style="text-align: center;">
						<table style="border: 1px solid black;">
							<tr style="border: 1px solid black; color: #25599C">
								<td style="border: 1px solid blue;">CODE STS</td>
								<td style="border: 1px solid blue;">No FACTURE</td>
								<td style="border: 1px solid blue;" >MONTANT FACTURE</td>
								<td style="border: 1px solid blue;">FRAIS SSI PAYER</td>
								<td style="border: 1px solid blue;">TOTAL SSI ENCAISSER</td>
							</tr>
							<tr style="border: 1px solid black;">
								<td style="border: 1px solid black;">  {{ $sts}} </td>
								<td style="border: 1px solid black;">  {{ $reglementnum}} </td>
								
								<td style="border: 1px solid black;" >  {{ $total}} $ SSI <br>  {{ $totalf}}  F CFA</td>
								<td style="border: 1px solid black;">  {{ $FraisSSI}} $ SSI <br> {{ $FraisSSIf}}  F CFA</td>
								<td style="border: 1px solid black;">  {{ $montant}} $ SSI <br>  {{ $montantf}}  F CFA </td>
								
							</tr>
						</table>

					</div>
					<div>
						<br>
						Puissance (KWH) :   {{ $kwh }}  <br>
						Entretien :   {{ $entretien }}  <br>
						<p style="color: red"> SOLDE RESTANT :  {{ $solderestant }}  $ SSI /  {{ $solderestantf }}  F CFA</p>

						<center> Merci d'avoir choisi la SSI, la plateforme qui vous facilite la vie. <br> <br> 
							Votre satisfaction, notre priorité.
						</center>
					</div>
				</div>
			</div>

			</body>