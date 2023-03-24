<!DOCTYPE html>
<html>
<head>
	<title>Ajout de PDF</title>
</head>
<body>


<script type="text/javascript">

	var b = 0;
	function recupvaleur(valeur) {
		//alert(valeur);
		b = valeur;
		document.getElementById('#tre').value = valeur;
	}
	function affiche() {
		return b;
	}
</script>

	<form method="post" action="Sauvegarde">
		{{ csrf_field() }}
		<input type="file" name="pdf">
		<input type="submit" name="Envoyer">
		<input type="test" name="texte" onkeyup="recupvaleur(this.value);">
		<input type="test" name="tre" id="tre" value="" onkeyup="affiche();">
	</form>  <br><br><br><br>
	@if(isset($information))
		<a href="{{ asset('$information')}}">Voir pdf</a>
	@endif
</body>
</html>




