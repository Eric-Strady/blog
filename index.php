<?php
	require ('controller/controller.php');
	require ('recaptcha/autoload.php');

	try
	{
		if (isset($_GET['link']) AND $_GET['link']!= '')
		{
			
			if ($_GET['link']=='inscription')
			{
				registrationLink();
			}
			elseif ($_GET['link']=='connexion')
			{
				signinLink();
			}
			elseif ($_GET['link']=='confirmed')
			{
				confirmLink();
			}
			elseif ($_GET['link']=='new_password')
			{
				newPasswordLink();
			}
			elseif ($_GET['link']=='change_password')
			{
				changePasswordLink();
			}
			elseif ($_GET['link']=='admin')
			{
				listPostsAdmin();
			}
			elseif ($_GET['link']=='create')
			{
				newPost();
			}
			elseif ($_GET['link']=='moderate')
			{
				listWarnedComments();
			}
			elseif ($_GET['link']=='account')
			{
				accountLink();
			}
			elseif ($_GET['link']=='deconnexion')
			{
				signOutLink();
			}
		}

																				//FRONTEND :

		//Vérifications pour l'affichage d'un post et de ses commentaires
		elseif (isset($_GET['post']) AND $_GET['post']!= '')
		{
			$postId = strip_tags($_GET['post']);
			post($postId);
		}

		//Vérifications pour l'ajout d'un commentaire
		elseif (isset($_POST['comment']))
		{
			if ($_POST['comment']!='')
			{
				$comment = strip_tags($_POST['comment']);
				insertComment($_POST['postId'], $_POST['pseudo'], $comment);
			}
			else
			{
				throw new Exception('<p>Impossible d\'ajouter de commentaire pour le moment !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
			}
		}

		//Vérifications pour modifier un commentaire
		elseif (isset($_POST['up_comment']))
		{
			if ($_POST['up_comment']!='')
			{
				$comment = strip_tags($_POST['up_comment']);
				reComment($comment, $_POST['commentId'], $_POST['id_post']);
			}
			else
			{
				throw new Exception('<p>Impossible de modifier le commentaire pour le moment !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
			}
		}

		//Sytème de vérification et d'insertion dans la BDD pour la page d'inscription
		elseif (isset($_POST['g-recaptcha-response']))
		{
			$recaptcha = new \ReCaptcha\ReCaptcha('6LfRh20UAAAAAIR3yJLwr3fZCFybqe6tpklXVixw');
			$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
			if ($resp->isSuccess())
			{
				if (isset($_POST['pseudo']) AND isset($_POST['password']) AND isset($_POST['passwordVerify']) AND isset($_POST['email']) )
				{
					if ($_POST['pseudo']!='' AND $_POST['password']!='' AND $_POST['passwordVerify']!='' AND $_POST['email']!='')
					{
						$pseudo = strip_tags($_POST['pseudo']);
						$password = strip_tags($_POST['password']);
						$email = strip_tags($_POST['email']);

						if (!verifyPseudo($pseudo))
						{
							if ($password==$_POST['passwordVerify'])
							{
								if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $password))
								{
									if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
									{
										if (!verifyEmail($email))
										{
											if (!verifyBanned($email))
											{
												$pass_hash = password_hash($password, PASSWORD_DEFAULT);

												registration($pseudo, $pass_hash, $email);
											}
											else
											{
											throw new Exception('<p>L\'adresse e-mail renseignée fait l\'objet d\'un bannissement sur ce site. Merci d\'en indiqué une autre.<br/>Retour à la page d\'<a href="index.php?link=inscription">inscription</a></p>');
											}
										}
										else
										{
											throw new Exception('<p>L\'adresse e-mail renseignée existe déjà sur un autre compte. Merci d\'en indiqué une autre.<br/>Retour à la page d\'<a href="index.php?link=inscription">inscription</a></p>');
										}
									}
									else
									{
										throw new Exception('<p>L\'adresse e-mail n\'est pas valide.<br/>Retour à la page d\'<a href="index.php?link=inscription">inscription</a></p>');
									}
								}
								else
								{
									throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à la page d\'<a href="index.php?link=inscription">inscription</a></p>');
								}					
							}
							else
							{
								throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à la page d\'<a href="index.php?link=inscription">inscription</a></p>');
							}
						}
						else
						{
							throw new Exception('<p>Le pseudo indiqué existe déjà. Merci d\'en choisir un autre.<br/>Retour à la page d\'<a href="index.php?link=inscription">inscription</a></p>');
						}
					}
				}
			}
			else
			{
			    $errors = $resp->getErrorCodes();
			}
		}

		//Vérifications pour confirmer une inscription
		elseif (isset($_GET['key']) AND $_GET['key']!='')
		{
			$registration_key = strip_tags($_GET['key']);
			$isRegistrationKeyCorrect = verifyRegistrationKey($registration_key);
			
			if ($isRegistrationKeyCorrect['registration_key']==$registration_key)
			{
				changeConfirm($registration_key);
			}
			else
			{
				throw new Exception('<p>Impossible de confirmer votre inscription pour le moment. Merci de prendre contact avec nous afin de vous apporter une solution.<br/>Retour à la page de <a href="index.php">accueil</a></p>');
			}
		}

		//Système de vérification et de création de session pour la page de connexion + redirection interface admin
		elseif (isset($_POST['id_connect'], $_POST['pass_connect']))
		{
			if ($_POST['id_connect']!='' AND $_POST['pass_connect']!='')
			{
				$id_connect = strip_tags($_POST['id_connect']);
				$pass_connect = strip_tags($_POST['pass_connect']);
				$connect = verifyConnect($id_connect);
				$isConfirmCorrect = verifyConfirm($id_connect);

				if ($isConfirmCorrect['confirm']==1)
				{
					if (password_verify($pass_connect, $connect['password']))
					{
						if ($connect['admin']==1)
						{
							session_start();
					        $_SESSION['id'] = $connect['id'];
					        $_SESSION['pseudo'] = $connect['pseudo'];
					        $_SESSION['admin'] = 'ok';

					        if ($_POST['auto_connect'] == 'checked')
							{
								setcookie('id_user', $connect['pseudo'], time()+60*60*24*30, null, null, false, true);
							}
					        $path = 'Location: http://127.0.0.1/blog/index.php?link=admin';
							header($path);
						}
						else
						{
							session_start();
					        $_SESSION['id'] = $connect['id'];
					        $_SESSION['pseudo'] = $connect['pseudo'];

					        if ($_POST['auto_connect'] == 'checked')
							{
								setcookie('id_user', $connect['pseudo'], time()+60*60*24*30, null, null, false, true);
							}
					        header('Location: index.php');
						}
					}
					else
					{
						throw new Exception('<p>Mauvais identifiant ou mot de passe :/<br/>Retour à la page de <a href="index.php?link=connexion">connexion</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Vous devez d\'abord confirmer votre inscription avant de vous connecter.<br/>Retour à la page de <a href="index.php?link=connexion">connexion</a></p>');
				}
			}
		}

		//Vérifications pour envoi nouveau mot de passe
		elseif (isset($_POST['get_email']))
		{
			if ($_POST['get_email']!='')
			{
				$email = strip_tags($_POST['get_email']);
				if (verifyEmail($email))
				{
					addTokenPassword($email);
					sendNewPassword($email);
				}
				else
				{
					throw new Exception('<p>L\'adresse e-mail renseignée est inconnue.<br/>Retour à la page de <a href="index.php?link=connexion">connexion</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Veuillez saisir une adresse e-mail valide.<br/>Retour à la page de <a href="index.php?link=connexion">connexion</a></p>');
			}
		}

		//Vérifications pour réinitialiser son mot de passe
		elseif (isset($_POST['reset_password'], $_POST['confirm_reset_password'], $_POST['email']))
		{
			if ($_POST['reset_password']!='' AND $_POST['confirm_reset_password']!='')
			{
				if ($_POST['reset_password'] == $_POST['confirm_reset_password'])
				{
					$reset_password = strip_tags($_POST['reset_password']);
					$email = $_POST['email'];

					if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $reset_password))
					{
						$pass_hash = password_hash($reset_password, PASSWORD_DEFAULT);

						resetPassword($pass_hash, $email);
					}
					else
					{
						throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à la page de <a href="index.php?link=change_password">réinitialisation</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Veuillez saisir un mot de passe.<br/>Retour à la page de <a href="index.php?link=change_password">réinitialisation</a></p>');
			}
		}

		//Vérifications pour signaler un commentaire
		elseif (isset($_GET['warnedId']))
		{
			if ($_GET['warnedId']!='')
			{
				$_GET['warnedId'] = (int)$_GET['warnedId'];
				$warnedId = strip_tags($_GET['warnedId']);

				if (!verifyWarning($warnedId))
				{
					addWarnedComments($warnedId);
				}
				else
				{
					throw new Exception('<p>Ce commentaire a déjà été signalé et sera traité dans les plus brefs délais !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Le système de signalement n\'est pas accessible pour le moment.<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
			}
		}

																				//BACKEND :

		//Vérifications pour une pagination dans l'interface d'administration
		elseif (isset($_GET['show']))
		{
			if ($_GET['show']!='')
			{
				listPostsAdmin();
			}
		}

		//Vérifications pour ajouter un post (Crud)
		elseif (isset($_POST['add_title']) AND isset($_POST['add_content']))
		{
			if ($_POST['add_title']!='' AND $_POST['add_content']!='')
			{
				$title = strip_tags($_POST['add_title']);
				$content = strip_tags($_POST['add_content']);

				addPost($title, $content);
			}
			else
			{
				throw new Exception('<p>Impossible de créer de billet pour le moment.<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour l'affichage d'un post (administrateur)
		elseif (isset($_GET['read']))
		{
			if ($_GET['read']!='')
			{
				$postId = strip_tags($_GET['read']);

				readPost($postId);
			}
			else
			{
				throw new Exception('<p>Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour l'affichage d'un post à modifier (administrateur)
		elseif (isset($_GET['update']))
		{
			if ($_GET['update']!='')
			{
				$postId = strip_tags($_GET['update']);

				readPost($postId);
			}
			else
			{
				throw new Exception('<p>Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour modifier un post
		elseif (isset($_POST['up_title']) AND isset($_POST['up_content']))
		{
			if ($_POST['up_title']!='' AND $_POST['up_content']!='')
			{
				$title = strip_tags($_POST['up_title']);
				$content = ($_POST['up_content']);
				$id = $_POST['id'];

				rePost($title, $content, $id);
			}
			else
			{
				throw new Exception('<p>Impossible de modifier le billet pour le moment.<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour afficher la demande de suppression d'un post
		elseif (isset($_GET['delete']))
		{
			if ($_GET['delete']!='')
			{
				deleteForm();
			}
			else
			{
				throw new Exception('<p>Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour suppression du post
		elseif (isset($_POST['delete']) AND isset($_POST['id']))
		{
			if ($_POST['delete']=='confirm')
			{
				$id = strip_tags($_POST['id']);

				erasePost($id);
			}
			elseif ($_POST['delete']=='cancel')
			{
				listPostsAdmin();
			}
			else
			{
				throw new Exception('<p>Vous n\'avez pas renseigné votre choix. Prenez votre temps pour peser le pour et le contre ;)<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour supprimer un commentaire signalé
		elseif (isset($_GET['eraseComment']) AND isset($_GET['eraseWarning']))
		{
			if ($_GET['eraseComment']!='' AND $_GET['eraseWarning']!='')
			{
				$eraseComment = strip_tags($_GET['eraseComment']);
				$eraseWarning = strip_tags($_GET['eraseWarning']);

				eraseWarnedComment($eraseComment, $eraseWarning);
			}
			else
			{
				throw new Exception('<p>Le système de suppression des commentaires signalés n\'est pas disponible pour le moment.<br/>Retour à la page de <a href="index.php?link=moderate">modération</a></p>');
			}
		}

		//Vérifications pour conserver un commentaire signalé
		elseif (isset($_GET['conserve']))
		{
			if ($_GET['conserve']!='')
			{
				$conserveWarning = strip_tags($_GET['conserve']);

				justDeleteWarning($conserveWarning);
			}
			else
			{
				throw new Exception('<p>Le système de suppression des commentaires signalés n\'est pas disponible pour le moment.<br/>Retour à la page de <a href="index.php?link=moderate">modération</a></p>');
			}
		}

																				//PROFIL:
		//Vérifications pour changer de pseudo
		elseif (isset($_POST['new_pseudo'], $_POST['password'], $_POST['pseudo']))
		{
			if ($_POST['new_pseudo']!='' AND $_POST['password']!='')
			{
				$new_pseudo = strip_tags($_POST['new_pseudo']);
				$password = strip_tags($_POST['password']);
				$pseudo = $_POST['pseudo'];

				$isPassCorrect = verifyConnect($pseudo);

				if (password_verify($password, $isPassCorrect['password']))
				{
					if (!verifyPseudo($_POST['new_pseudo']))
					{
						session_start();
						$_SESSION['pseudo'] = $new_pseudo;

						newPseudo($_SESSION['pseudo'], $pseudo);
					}
					else
					{
						throw new Exception('<p>Le pseudo indiqué existe déjà. Merci d\'en choisir un autre.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué n\'est pas correct.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
				}
			}
		}

		//Vérifications pour changer d'avatar
		elseif (isset($_FILES['avatar'], $_POST['id']))
		{
			if ($_FILES['avatar']['error'] == 0)
			{
				if ($_FILES['avatar']['size']<=300000)
				{
					$data_files = pathinfo($_FILES['avatar']['name']);
					$extension_upload = $data_files['extension'];

					$id = $_POST['id'];

					if ($extension_upload=='png')
					{
						session_start();
						$_SESSION['id'] = $id;

						move_uploaded_file($_FILES['avatar']['tmp_name'], 'public/images/avatars/' . $id . '.' . $extension_upload);
						thumbNails($id, $extension_upload);
					}
					else
					{
						throw new Exception('<p>Le format de l\'image n\'est pas conforme. Pour rappel, vous devez transmettre une image au format "JPG" ou "PNG".<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>L\'image est trop volumineuse. Pour rappel, elle ne doit pas dépasser 200Ko.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Une erreur est survenue lors du téléchargement.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
			}
		}

		//Vérifications pour changer d'adresse e-mail
		elseif (isset($_POST['new_email'], $_POST['password'], $_POST['pseudo']))
		{
			if ($_POST['new_email']!='' AND $_POST['password']!='')
			{
				$new_email = strip_tags($_POST['new_email']);
				$password = strip_tags($_POST['password']);
				$pseudo = $_POST['pseudo'];

				$isPassCorrect = verifyConnect($pseudo);

				if (password_verify($password, $isPassCorrect['password']))
				{
					if (!verifyEmail($new_email))
					{
						newEmail($new_email, $pseudo);
					}
					else
					{
						throw new Exception('<p>L\'adresse e-mail indiqué existe déjà. Merci d\'en choisir une autre.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué n\'est pas correct.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
				}
			}
		}

		//Vérifications pour changer de mot de passe
		elseif (isset($_POST['old_password'], $_POST['change_password'], $_POST['confirm_change_password'], $_POST['pseudo']))
		{
			if ($_POST['old_password']!='' AND $_POST['change_password']!='' AND $_POST['confirm_change_password']!='')
			{
				$old_password = strip_tags($_POST['old_password']);
				$new_password = strip_tags($_POST['change_password']);
				$confirm_new_password = strip_tags($_POST['confirm_change_password']);
				$pseudo = $_POST['pseudo'];

				$isPassCorrect = verifyConnect($pseudo);

				if (password_verify($old_password, $isPassCorrect['password']))
				{
					if ($new_password==$confirm_new_password)
					{
						if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $new_password))
						{
							$pass_hash = password_hash($new_password, PASSWORD_DEFAULT);

							newPassword($pass_hash, $pseudo);
						}
						else
						{
							throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué comme étant votre ancien mot de passe n\'est pas correct.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
				}
			}
		}

		//Vérifications pour supprimer un compte utilisateur (admin)
		elseif (isset($_POST['user_pseudo'], $_POST['reasons_suppression'], $_POST['password'], $_POST['pseudo']))
		{
			if ($_POST['user_pseudo']!='' AND $_POST['reasons_suppression']!='' AND $_POST['password']!='')
			{
				$user_pseudo = strip_tags($_POST['user_pseudo']);
				$reasons = strip_tags($_POST['reasons_suppression']);
				$password = strip_tags($_POST['password']);
				$pseudo = $_POST['pseudo'];
				$isPassCorrect = verifyConnect($pseudo);

				if (password_verify($password, $isPassCorrect['password']))
				{
					if (verifyPseudo($user_pseudo))
					{
						$email = selectEmail($user_pseudo);

						bannedUser($user_pseudo, $email['email'], $reasons);
					}
					else
					{
						throw new Exception('<p>Le pseudo renseigné n\'existe pas.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué n\'est pas correct.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
				}
			}
		}

		//Vérifications pour afficher la demande de suppression du compte
		elseif (isset($_POST['password'], $_POST['pseudo']))
		{
			if ($_POST['password']!='' AND $_POST['pseudo']!='')
			{
				$password = strip_tags($_POST['password']);
				$isPassCorrect = verifyConnect($_POST['pseudo']);

				if (password_verify($password, $isPassCorrect['password']))
				{
					confirmDeleteAccount();
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué n\'est pas correct.<br/>Retour à votre <a href="index.php?link=account">profil</a></p>');
				}
			}
		}

		//Vérifications pour supprimer son compte
		elseif (isset($_POST['delete_account'], $_POST['pseudo'], $_POST['id']))
		{
			if ($_POST['delete_account']=='confirm')
			{
				eraseAccount($_POST['pseudo'], $_POST['id']);
			}
			elseif ($_POST['delete_account']=='cancel')
			{
				adminAccountLink();
			}
			else
			{
				throw new Exception('<p>Vous n\'avez pas renseigné votre choix. Prenez votre temps pour peser le pour et le contre ;)<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
			}
		}
		
//SI RIEN NE CORRESPOND :

		//Affichage par défaut (page d'accueil)
		else
		{
			listPosts();
		}
	}
	catch(Exception $e)
	{
    	$errorMessage =  $e->getMessage();

    	require ('view/frontend/errorView.php');
	}