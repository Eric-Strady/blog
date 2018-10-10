<?php

	require_once('model/Users.php');
	require_once('model/Warning.php');
	require_once('model/Banned.php');

	use \Eric\Blog\Model\Users\Users;
	use \Eric\Blog\Model\Warning\Warning;
	use \Eric\Blog\Model\Banned\Banned;

	//Lien vers la page du profil + paramétrages du compte (administrateur)
	function accountLink()
	{

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/accountView.php');
	}

	function newPseudo($new_pseudo, $id)
	{
		$newPseudo = new Users();
		$newPseudo->changePseudo($new_pseudo, $id);
	}

	function newEmail($new_email, $id)
	{
		$newEmail = new Users();

		$to = 'strady60@gmail.com';
		$subject = 'Changement d\'adresse e-mail';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Un petit pas pour l\'homme mais un grand pas pour le numérique !</h3>
						<p>Bravo ! La modification de votre adresse e-mail a bien été prise en compte.</p>
						<p>Lors de votre prochaine connexion vous pourrez renseigner cette adresse e-mail comme identifiant ;)</p>
						<p>A bientôt sur le <a href="127.0.0.1/blog/index.php?link=connexion" target="_blank">blog de Jean Forteroche</a></p>
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

		$newEmail->changeEmail($new_email, $id);
	}

	function newPassword($pass_hash, $id)
	{
		$newPassword = new Users();
		$newPassword->changePassword($pass_hash, $id);
	}

	function selectEmail($id_user)
	{
		$selectEmail = new Users();
		$user_email = $selectEmail->getEmail($id_user);

		return $user_email;
	}

	function bannedUser($pseudo, $email, $reasons)
	{
		$bannedUser = new Banned();
		$deleteUser = new AdminManager();

		$bannedUser->addBanned($pseudo, $email, $reasons);

		$to = 'strady60@gmail.com';
		$subject = 'Suppression de votre compte utilisateur';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Suppression de votre compte !</h3>
						<p>Bonjour,<br/>
						Votre compte utilisateur sur le blog de Jean Forteroche a fait l\'objet d\'une suppression par l\'administrateur.</p>
						<p>En voici les raisons:<br/>
						"' . $reasons . '"</p>
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

		$deleteUser->deleteUser($pseudo);
	}

	function confirmDeleteAccount()
	{
		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/deleteAccountView.php');
	}

	function eraseAccount($pseudo, $id)
	{
		$eraseAccount = new Users();
		$deleteAsloComments = new Comments();

		$eraseAccount->deleteAccount($pseudo);
		$deleteAsloComments->deleteComments($pseudo);

		unlink('public/images/avatars/' . $id . '.png');
		unlink('public/images/thumbnails/' . $id . '.png');
	}