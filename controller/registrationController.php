<?php

	require_once('model/Posts.php');
	require_once('model/Banned.php');

	use \Eric\Blog\Model\Posts\Posts;
	use \Eric\Blog\Model\Banned\Banned;

	//Vérifications pour l'insciption d'un utilisateur + inscription et confirmation par e-mail
	function verifyPseudo($pseudo)
	{
		$verifyPseudo = new Users();
		$avaiblePseudo = $verifyPseudo->checkPseudo($pseudo);

		return $avaiblePseudo;
	}

	function verifyEmail($email)
	{
		$verifyEmail = new Users();
		$avaibleEmail = $verifyEmail->checkEmail($email);

		return $avaibleEmail;
	}

	function verifyBanned($email)
	{
		$verifyBanned = new Banned();
		$avaibleAccount = $verifyBanned->checkBanned($email);

		return $avaibleAccount;
	}

	function registration($pseudo, $pass_hash, $email)
	{
		$registration = new Users();

		$length = 10;
		$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$maxLength = strlen($string);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
		$randomString.= $string[rand(0, $maxLength - 1)];
		}
		$registration_key = $randomString;

		$to = $email;
		$subject = 'Confirmation d\'inscription';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Bienvenue parmi les membres du blog de Jean Forteroche !</h3>
						<p>Pour pouvoir vous connecter, merci de bien vouloir finaliser votre inscription en cliquant sur le lien ci-dessous:</p>
						<p><a href="127.0.0.1/blog/index.php?key=' . $registration_key . '" target="_blank">Confirmer mon inscription</a></p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		$confirm = 0;
		$admin = 0;
		$registration->addUser($pseudo, $pass_hash, $email, $registration_key, $confirm, $admin);
	}