<?php

	require_once('model/User.php');
	require_once('model/UsersManager.php');

	use \Eric\Blog\Model\Users\User;
	use \Eric\Blog\Model\Users\UsersManager;

												//DEFINE ACTION

	if (isset($_GET['action']) AND !empty($_GET['action']))
	{
		$action = strip_tags($_GET['action']);
		switch ($action)
		{
			case 'signed':
				signin();
			break;

			case 'forgot_password':
				require 'view/frontend/newPasswordView.php';
			break;

			case 'reset_password':
				resetPass();
			break;

			default:
				throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			break;
		}
	}
	else
	{
		require 'view/frontend/signInView.php';
	}

												//FUNCTIONS

	function signin()
	{
		if (isset($_POST['id_connect'], $_POST['pass_connect']))
		{
			if ($_POST['id_connect']!='' AND $_POST['pass_connect']!='')
			{
				$id_connect = strip_tags($_POST['id_connect']);
				$pass_connect = strip_tags($_POST['pass_connect']);
				$user = new User([
					'connect' => $id_connect,
					'password' => $pass_connect
				]);
				$usersManager = new UsersManager();

				if ($usersManager->isExist($user->getConnect()))
				{
					$user = $usersManager->findUser($user->getConnect());

					if (!$usersManager->isExist($user->getTokenPass()))
					{
						if ($user->getConfirm() == 1)
						{
							if (password_verify($pass_connect, $user->getPassword()))
							{
								if ($user->getAdmin() == 1)
								{
							        $_SESSION['id'] = $user->getId();
							        $_SESSION['pseudo'] = $user->getPseudo();
							        $_SESSION['email'] = $user->getEmail();
							        $_SESSION['admin'] = 'ok';

							        if ($_POST['auto_connect'] == 'checked')
									{
										setcookie('id_user', $user->getPseudo(), time()+60*60*24*30, null, null, false, true);
									}
							        $path = 'Location: http://127.0.0.1/blog/index.php?link=admin';
									header($path);
								}
								else
								{
							        $_SESSION['id'] = $user->getId();
							        $_SESSION['pseudo'] = $user->getPseudo();
							        $_SESSION['email'] = $user->getEmail();

							        if ($_POST['auto_connect'] == 'checked')
									{
										setcookie('id_user', $user->getPseudo(), time()+60*60*24*30, null, null, false, true);
									}
							        header('Location: index.php');
								}
							}
							else
							{
								throw new Exception('<p>Mauvais identifiant ou mot de passe !<br/>Retour à la page de <a href="index.php?link=signin" title="Page de connexion" class="alert-link">connexion</a></p>');
							}
						}
						else
						{
							throw new Exception('<p>Vous devez d\'abord confirmer votre inscription avant de vous connecter.<br/>Retour à la page de <a href="index.php?link=signin" title="Page de connexion" class="alert-link">connexion</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>Vous avez effectué une demande de réinitialisation de mot de passe. Tant que la réinitialisation ne sera pas effectuée, vous ne pourrez pas vous connecter.<br/>Retour à la page de <a href="index.php?link=signin" title="Page de connexion" class="alert-link">connexion</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Mauvais identifiant ou mot de passe !<br/>Retour à la page de <a href="index.php?link=signin" title="Page de connexion" class="alert-link">connexion</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Vous devez renseigné tous les champs.<br/>Retour à la page de <a href="index.php?link=signin" title="Page de connexion" class="alert-link">connexion</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseigné tous les champs.<br/>Retour à la page de <a href="index.php?link=signin" title="Page de connexion" class="alert-link">connexion</a></p>');
		}
	}

	function resetPass()
	{
		if (isset($_POST['email']) AND $_POST['email']!='')
		{
			$email = strip_tags($_POST['email']);
			$user = new User(['email' => $email]);
			$usersManager = new UsersManager();

			if ($usersManager->isExist($user->getEmail()))
			{
				$user = $usersManager->findUser($user->getEmail());
				$user->setNewTokenPass();

				$usersManager->updateTokenPass($user->getTokenPass(), $user->getId());
				$user->sendResetPassword();

				$_SESSION['forgotPass'] = 'yes';
				require 'view/frontend/signInView.php';
			}
			else
			{
				throw new Exception('<p>Cette adresse e-mail ne correspond à aucuns comptes.<br/>Retour à la page de <a href="index.php?link=signin&amp;action=forgot_password" title="Page de réinitialisation" class="alert-link">réinitialisation</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseigné tous les champs.<br/>Retour à la page de <a href="index.php?link=signin&amp;action=forgot_password" title="Page de réinitialisation" class="alert-link">réinitialisation</a></p>');
		}
	}

	/*
	require_once('model/UsersManager.php');

	use \Eric\Blog\Model\Users\UsersManager;

	//Vérifications pour la connexion d'un utilisateur + envoi nouveau mot de passe
	function verifyConnect($id_connect)
	{
		$verifyConnect = new UsersManager();
		$verifyId = $verifyConnect->checkConnect($id_connect);

		return $verifyId;
	}

	function verifyRegistrationKey($registration_key)
	{
		$verifyRegistrationKey = new UsersManager();
		$isKeyExist = $verifyRegistrationKey->checkRegistrationKey($registration_key);

		return $isKeyExist;
	}

	function changeConfirm($registration_key)
	{
		$changeConfirm = new UsersManager();
		$changeConfirm->updateConfirm($registration_key);
	}

	function verifyToken($id_connect)
	{
		$verifyToken = new UsersManager();
		$isPresent = $verifyToken->checkTokenPresence($id_connect);

		return $isPresent;
	}

	function verifyConfirm($id_connect)
	{
		$verifyConfirm = new UsersManager();
		$isConfirm = $verifyConfirm->checkConfirm($id_connect);

		return $isConfirm;
	}

	function newTokenPassword($email)
	{
		$newToken = new UsersManager();

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
		$verifyToken = new UsersManager();
		$avaibleToken = $verifyToken->checkTokenPassword($id, $token);

		return $avaibleToken;
	}

	function deleteToken($email)
	{
		$deleteToken = new UsersManager();
		$deleteToken->deleteTokenPassword($email);
	}

	function resetPassword($pass_hash, $email)
	{
		$resetPassword = new UsersManager();
		$resetPassword->forgottenPassword($pass_hash, $email);
	}
	*/