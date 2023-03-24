<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MessageGoogle;
use App\Mail\Recu;

class SendMail extends Controller
{
    public static function sendachatechec($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.echecachat";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}
    
    public static function sendretraitvisa($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.validervisa";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}
	
	public static function sendechecretraitvisa($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.echecvisa";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}
    
    public static function sendachat($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.validerachat";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}

	public static function sendmailIndexController($destinataire, $subject, $messa, $object) {
		
		$users = [$destinataire, "sourcedusucces@gmail.com"];
		$view = "mail.envoiemail";

		Mail::to($users)->queue(new MessageGoogle($object, $messa, $subject, $view));		
	}

	public static function sendmailnotification($destinataire, $subject, $messa, $object) {
		$data = ["object" => $object, "messa" => $messa ];
		$users = [$destinataire];
		$view = "mail.envoiemail";

		Mail::to($users)->queue(new MessageGoogle($object, $messa, $subject, $view));		
	}
	
	public static function sendmailValidation($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.validation";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}
	
	
	public static function sendMessageGoogle (Request $request) {
	
		$data = ["don" => 0];
		$users = ["sourcedusucces@gmail.com"];

		Mail::to($users)->queue(new MessageGoogle($data, "FACTURE", 'mail.name'));

		return "Bien";
	}
	
	public static function sendrecucreditsbee($destinataire, $Subject, $data) {
	    $users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.recucreditsbee";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));
	}
	
	public static function sendrecusoneb($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.recusoneb";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}

	public static function sendrecuhealth($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.recuhealth";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}

	public static function sendreculongrich($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.reculongrich";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}


	public static function sendrecucanal($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.recucanal";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}

	public static function sendrecuconventionnel($destinataire, $Subject, $data)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];
		$view = "mail.recuconventionnel";

		Mail::to($users)->queue(new Recu($data, $Subject, $view));	
	}
	
	public static function sendretrait($destinataire, $sujet, $data, $view)
	{
		$users = ["sourcedusucces@gmail.com", $destinataire];

		Mail::to($users)->queue(new Recu($data, $sujet, $view));
	}
}
