<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Image as Image;
use Illuminate\Http\Request;

class ArticlePDFController extends Controller
{
	public function Ajout()
	{
		return view('AjoutPDF');
	}

	public static function SauvegardePDF(Request $request)
	{
		//$cheminpdf = request('pdf')->store('');
		$cheminpdf = request('pdf');
		$path = storage_path($cheminpdf);
		$nom = "form1";
		$cheminpath = "./stockpdf/". $nom.".pdf";
		//rename('C:/MLM/storage/app/'.$path, $cheminpath);
		/* sauvegarder dans la base de donne
		$var = $requete->input('PDF');

		$resultat = $var;

		$information = ['information' => $resultat];
		return view('AjoutPDF', $information); */
	}

}