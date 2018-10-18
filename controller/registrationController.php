<?php
	
	require ('recaptcha/autoload.php');
	require_once('model/User.php');
	require_once('model/UsersManager.php');
	require_once('model/Banned.php');
	require_once('model/BannedManager.php');

	use \Eric\Blog\Model\Users\User;
	use \Eric\Blog\Model\Users\UsersManager;
	use \Eric\Blog\Model\Banned\Banned;
	use \Eric\Blog\Model\Banned\BannedManager;

												//DEFINE ACTION

	if (isset($_GET['action']) AND !empty($_GET['action']))
	{
		$action = strip_tags($_GET['action']);
		switch ($action)
		{
			case 'register':
				registration();
			break;

			case 'confirm':
				verifyRegistrationKey();
			break;

			default:
				throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			break;
		}
	}
	else
	{
		require 'view/frontend/registrationView.php';
	}

												//FUNCTIONS

	function registration()
	{
		$recaptcha = new \ReCaptcha\ReCaptcha('6LfRh20UAAAAAIR3yJLwr3fZCFybqe6tpklXVixw');
		$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
		if ($resp->isSuccess())
		{
			if (isset($_POST['pseudo'], $_POST['password'], $_POST['passwordVerify'], $_POST['email']))
			{
				if ($_POST['pseudo']!='' AND $_POST['password']!='' AND $_POST['passwordVerify']!='' AND $_POST['email']!='')
				{
					$pseudo = strip_tags($_POST['pseudo']);
					$password = strip_tags($_POST['password']);
					$email = strip_tags($_POST['email']);

					$user = new User([
						'pseudo' => $pseudo,
						'password' => $password,
						'email' => $email,
						'confirm' => 0,
						'admin' => 0
					]);

					$usersManager = new UsersManager();	

					if (!$usersManager->isExist($user->getPseudo()))
					{
						if ($user->getPassword()==$_POST['passwordVerify'])
						{
							if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $user->getPassword()))
							{
								if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $user->getEmail()))
								{
									if (!$usersManager->isExist($user->getEmail()))
									{
										$banned = new Banned(['email' => $user->getEmail()]);
										$bannedManager = new BannedManager();

										if (!$bannedManager->checkBanned($banned))
										{
											$pass_hash = password_hash($user->getPassword(), PASSWORD_DEFAULT);
											$user->setPassword($pass_hash);
											$user->setNewRegistrationKey();

											$usersManager->addUser($user);
											$user->sendRegistrationKey();

											setcookie('pseudo', $user->getPseudo(), time()+120, null, null, false, true);
											$path = 'Location: http://127.0.0.1/blog/index.php?link=signin';
											header($path);
										}
										else
										{
										throw new Exception('<p>L\'adresse e-mail renseignée fait l\'objet d\'un bannissement sur ce site. Merci d\'en indiqué une autre.<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
										}
									}
									else
									{
										throw new Exception('<p>L\'adresse e-mail renseignée existe déjà sur un autre compte. Merci d\'en indiqué une autre.<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
									}
								}
								else
								{
									throw new Exception('<p>L\'adresse e-mail n\'est pas valide.<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
								}
							}
							else
							{
								throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
							}					
						}
						else
						{
							throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>Le pseudo indiqué existe déjà. Merci d\'en choisir un autre.<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Vous devez renseigné tous les champs.<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
				}
			}
			else
			{
			    throw new Exception('<p>Vous devez renseigné tous les champs.<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Le reCAPTCHA est obligatoire !<br/>Retour à la page d\'<a href="index.php?link=registration" title="Page d\'inscription" class="alert-link">inscription</a></p>');
		}
	}

	function verifyRegistrationKey()
	{
		if (isset($_GET['key']) AND $_GET['key']!='')
		{
			$key = strip_tags($_GET['key']);
			$user = new User(['registration_key' => $key]);
			$userManager = new UsersManager();

			if ($userManager->isExist($user->getRegistrationKey()))
			{
				$userManager->updateConfirm($user);
				require 'view/frontend/confirmedRegistrationView.php';
			}
			else
			{
				throw new Exception('<p>Impossible de confirmer votre inscription pour le moment. Merci de prendre contact avec nous afin de vous apporter une solution.<br/>Retour à la page de <a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}			
		}
		else
		{
			throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page de <a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
		}
	}