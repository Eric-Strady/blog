<?php

	require_once('model/User.php');
	require_once('model/UsersManager.php');
	require_once('model/Banned.php');
	require_once('model/BannedManager.php');

	use \Eric\Blog\Model\Users\User;
	use \Eric\Blog\Model\Users\UsersManager;
	use \Eric\blog\Model\Banned\Banned;
	use \Eric\Blog\Model\Banned\BannedManager;

												//DEFINE ACTION

	if (isset($_GET['action']) AND !empty($_GET['action']))
	{
		$action = strip_tags($_GET['action']);
		switch ($action)
		{
			case 'pseudo':
				changePseudo();
			break;

			case 'email':
				changeEmail();
			break;

			case 'password':
				changePassword();
			break;

			case 'delete':
				confirmDelete();
			break;

			case 'delete_account':
				deleteAccount();
			break;

			case 'delete_user':
				deleteUserAccount();
			break;

			default:
				throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			break;
		}
	}
	else
	{
		require 'view/backend/accountView.php';
	}

											//FUNCTIONS

	function changePseudo()
	{
		if (isset($_POST['new_pseudo'], $_POST['password'], $_SESSION['id']))
		{
			if ($_POST['new_pseudo']!='' AND $_POST['password']!='' AND $_SESSION['id']!='')
			{
				$new_pseudo = strip_tags($_POST['new_pseudo']);
				$password = strip_tags($_POST['password']);
				$id = $_SESSION['id'];

				$user = new User(['id' => $id]);
				$usersManager = new UsersManager();
				$user = $usersManager->findUser($user->getId());

				if (password_verify($password, $user->getPassword()))
				{
					$user->setPseudo($new_pseudo);

					if (!$usersManager->isExist($user->getPseudo()))
					{
						$usersManager->updatePseudo($user);
						$_SESSION['pseudo'] = $user->getPseudo();

						require 'view/backend/accountView.php';
					}
					else
					{
						throw new Exception('<p>Ce pseudo est déjà pris. Merci d\'en choisir un autre.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe n\'est pas correct !<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
				}	
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
		}
	}

	function changeEmail()
	{
		if (isset($_POST['new_email'], $_POST['password'], $_SESSION['id']))
		{
			if ($_POST['new_email']!='' AND $_POST['password']!='' AND $_SESSION['id']!='')
			{
				$new_email = strip_tags($_POST['new_email']);
				$password = strip_tags($_POST['password']);
				$id = $_SESSION['id'];

				$user = new User(['id' => $id]);
				$usersManager = new UsersManager();

				$banned = new Banned(['email' => $new_email]);
				$bannedManager = new BannedManager();

				$user = $usersManager->findUser($user->getId());

				if (password_verify($password, $user->getPassword()))
				{
					$user->setEmail($new_email);

					if (!$usersManager->isExist($user->getEmail()))
					{
						if (!$bannedManager->checkBanned($banned))
						{
							$usersManager->updateEmail($user);
							$user->sendUpdateEmail();

							$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=email';
							header($path);
						}
						else
						{
							throw new Exception('<p>L\'adresse e-mail renseignée fait l\'objet d\'un bannissement sur ce site. Merci d\'en indiqué une autre.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>L\'adresse e-mail renseignée existe déjà sur un autre compte. Merci d\'en indiqué une autre.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe n\'est pas correct !<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
				}			
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
		}
	}

	function changePassword()
	{
		if (isset($_POST['old_password'], $_POST['change_password'], $_POST['confirm_change_password'], $_SESSION['id']))
		{
			if ($_POST['old_password']!='' AND $_POST['change_password']!='' AND $_POST['confirm_change_password']!='' AND $_SESSION['id']!='')
			{
				$old_password = strip_tags($_POST['old_password']);
				$new_password = strip_tags($_POST['change_password']);
				$confirm_password = strip_tags($_POST['confirm_change_password']);
				$id = $_SESSION['id'];

				$user = new User(['id' => $id]);
				$usersManager = new UsersManager();

				$user = $usersManager->findUser($user->getId());

				if (password_verify($old_password, $user->getPassword()))
				{
					if ($new_password == $confirm_password)
					{
						if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $new_password))
						{
							$pass_hash = password_hash($new_password, PASSWORD_DEFAULT);
							$user->setPassword($pass_hash);

							$usersManager->updatePassword($user);

							$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=password';
							header($path);
						}
						else
						{
							throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
						}					
					}
					else
					{
						throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe n\'est pas correct !<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
				}			
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
		}
	}

	function confirmDelete()
	{
		if (isset($_POST['password'], $_SESSION['id']))
		{
			if ($_POST['password']!='' AND $_SESSION['id']!='')
			{
				$password = strip_tags($_POST['password']);
				$id = $_SESSION['id'];

				$user = new User(['id' => $id]);
				$usersManager = new UsersManager();

				$user = $usersManager->findUser($user->getId());

				if (password_verify($password, $user->getPassword()))
				{
					require 'view/backend/deleteAccountView.php';
				}
				else
				{
					throw new Exception('<p>Le mot de passe n\'est pas correct !<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
				}			
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
		}
	}

	function deleteAccount()
	{
		if (isset($_POST['delete'], $_SESSION['id']))
		{
			if ($_POST['delete']!='' AND $_SESSION['id']!='')
			{
				$choice = $_POST['delete'];
				
				if ($choice == 'confirm')
				{
					$id = $_SESSION['id'];
					$user = new User(['id' => $id]);
					$usersManager = new UsersManager();

					if ($usersManager->isExist($user->getId()))
					{
						$usersManager->deleteAccount($user);

						require 'view/frontend/signOutView.php';
					}
					else
					{
						throw new Exception('<p>Cet utilisateur n\'existe pas.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
					}
				}
				else
				{
					require 'view/backend/accountView.php';
				}			
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
		}
	}

	function deleteUserAccount()
	{
		if (isset($_POST['user_pseudo'], $_POST['reasons'], $_POST['password'], $_SESSION['id']))
		{
			if ($_POST['user_pseudo']!='' AND $_POST['reasons']!='' AND $_POST['password']!='' AND $_SESSION['id']!='')
			{
				$user_pseudo = strip_tags($_POST['user_pseudo']);
				$reasons = strip_tags($_POST['reasons']);
				$password = strip_tags($_POST['password']);
				$id = $_SESSION['id'];

				$user = new User(['id' => $id]);
				$usersManager = new UsersManager();
				$user = $usersManager->findUser($user->getId());

				if (password_verify($password, $user->getPassword()))
				{
					$userToDelete = new User(['pseudo' => $user_pseudo]);

					if ($usersManager->isExist($userToDelete->getPseudo()))
					{
						$userToDelete = $usersManager->findUser($userToDelete->getPseudo());
						$banned = new Banned(['email' => $userToDelete->getEmail(), 'reasons' => $reasons]);
						$bannedManager = new BannedManager();

						$usersManager->deleteAccount($userToDelete);
						$bannedManager->addBanned($banned);
						$banned->sendBannedEmail();

						$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=user_suppression';
						header($path);
					}
					else
					{
						throw new Exception('<p>Cet utilisateur n\'existe pas.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
					}					
				}
				else
				{
					throw new Exception('<p>Le mot de passe n\'est pas correct !<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
				}			
			}
			else
			{
				throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseignez tous les champs.<br/>Retour à votre <a href="index.php?link=account" title="Page du profil" class="alert-link">profil</a></p>');
		}
	}