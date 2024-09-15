<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Lignes de langue d'authentification
	|--------------------------------------------------------------------------
	|
	| Les lignes de langue suivantes sont utilisées lors de l'authentification
	| pour divers messages que nous devons afficher à l'utilisateur. Vous êtes
	| libre de modifier ces lignes selon les besoins de votre application.
	|
	*/

	'failed' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
	'password' => 'Le mot de passe fourni est incorrect.',
	'throttle' => 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',
	'mail' => [
		'description' => "Merci pour votre inscription ! \nAvant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez pas reçu l'email, nous vous en enverrons volontiers un autre.",
		'link-resent' => 'Un nouveau lien de vérification a été envoyé à votre adresse e-mail :email',
	],
	'register-title' => 'Inscription',
	'login-title' => 'Connexion',
	'not-account' => ['Vous n\'avez pas de compte ?', 'S\'inscrire'],
	'already-account' => ['Vous avez déjà un compte ?', 'Se connecter'],
	'label' => [
		'name' => 'Nom',
		'firstname' => 'Prénom',
		'lastname' => 'Nom de famille',
		'sex' => [
			'main' => 'Sexe',
			'male' => 'Homme',
			'female' => 'Femme',
		],
		'username' => 'Nom d\'utilisateur',
		'email' => 'Email',
		'email_or_username' => 'Email ou nom d\'utilisateur',
		'password' => [
			'main' => 'Mot de passe',
			'confirm' => 'Confirmer le mot de passe',
		],
	],
	'button' => [
		'google' => 'Continuer avec Google',
		'login' => 'Se connecter',
		'register' => 'S\'inscrire',
	],

];
