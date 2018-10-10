<?php

	require_once('model/Users.php');

	use \Eric\Blog\Model\Users\Users;

	//Vérifications pour la connexion d'un utilisateur + envoi nouveau mot de passe
	function verifyConnect($id_connect)
	{
		$verifyConnect = new Users();
		$verifyId = $verifyConnect->checkConnect($id_connect);

		return $verifyId;
	}

	function verifyRegistrationKey($registration_key)
	{
		$verifyRegistrationKey = new Users();
		$isKeyExist = $verifyRegistrationKey->checkRegistrationKey($registration_key);

		return $isKeyExist;
	}

	function changeConfirm($registration_key)
	{
		$changeConfirm = new Users();
		$changeConfirm->updateConfirm($registration_key);
	}

	function verifyToken($id_connect)
	{
		$verifyToken = new Users();
		$isPresent = $verifyToken->checkTokenPresence($id_connect);

		return $isPresent;
	}

	function verifyConfirm($id_connect)
	{
		$verifyConfirm = new Users();
		$isConfirm = $verifyConfirm->checkConfirm($id_connect);

		return $isConfirm;
	}

	function newTokenPassword($email)
	{
		$newToken = new Users();

		$length = 60;
		$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$maxLength = strlen($string);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
		$randomString.= $string[rand(0, $maxLength - 1)];
		}
		$token_key = $randomString;

		$newToken->addTokenPassword($token_key, $email);
		return $token_key;
	}

	function sendNewPassword($email, $id, $token)
	{
		$to = $email;
		$subject = 'Réinitialisation du mot de passe';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Réinitialisation de votre mot de passe</h3>
						<p>Vous êtes actuellement sur le point de changer votre mot de passe !<br/>
						Cliquez <a href="127.0.0.1/blog/index.php?id=' . $id . '&amp;token=' . $token . '" target="_blank">ici</a> pour réinitialiser votre mot de passe.</p>
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

		setcookie('email', $email, time()+60*15, null, null, false, true);
		require('view/frontend/signInView.php');
	}

	function verifyTokenPassword($id, $token)
	{
		$verifyToken = new Users();
		$avaibleToken = $verifyToken->checkTokenPassword($id, $token);

		return $avaibleToken;
	}

	function deleteToken($email)
	{
		$deleteToken = new Users();
		$deleteToken->deleteTokenPassword($email);
	}

	function resetPassword($pass_hash, $email)
	{
		$resetPassword = new Users();
		$resetPassword->forgottenPassword($pass_hash, $email);
	}