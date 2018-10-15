<?php
	
	require 'controller/controller.php';

	$url = new Router();
	$url->loadCtrl();

	/*

	require ('controller/controller.php');
	require ('controller/homeController.php');
	require ('controller/postController.php');
	require ('controller/registrationController.php');
	require ('controller/signinController.php');
	require ('controller/adminController.php');
	require ('controller/crudController.php');
	require ('controller/warningController.php');
	require ('controller/accountController.php');
	require ('controller/contactController.php');
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
			elseif ($_GET['link']=='contact')
			{
				contactLink();
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
			else
			{
				throw new Exception('<p>Cette page n\'existe pas !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}

																				//FRONTEND :

		//Vérifications pour l'affichage d'un post et de ses commentaires
		elseif (isset($_GET['post']) AND $_GET['post']!= '')
		{
			$_GET['post'] = (int) $_GET['post'];
			$postId = ($_GET['post']);

			post($postId);
		}

		//Vérifications pour l'ajout d'un commentaire
		elseif (isset($_POST['comment'], $_POST['postId'], $_POST['pseudo'], $_POST['email']))
		{
			if ($_POST['comment']!='' AND $_POST['postId']!='' AND $_POST['pseudo']!='' AND $_POST['email']!='')
			{
				$_POST['postId'] = (int) $_POST['postId'];
				$postId = ($_POST['postId']);
				$pseudo = strip_tags($_POST['pseudo']);
				$email = strip_tags($_POST['email']);
				$comment = strip_tags($_POST['comment']);

				insertComment($postId, $pseudo, $email, $comment);
			}
			else
			{
				throw new Exception('<p>Impossible d\'ajouter de commentaire pour le moment !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}

		//Vérifications pour modifier un commentaire
		elseif (isset($_POST['up_comment'], $_POST['commentId'], $_POST['id_post']))
		{
			if ($_POST['up_comment']!='' AND $_POST['commentId']!='' AND $_POST['id_post']!='')
			{
				$comment = strip_tags($_POST['up_comment']);
				$_POST['commentId'] = (int) $_POST['commentId'];
				$commentId = ($_POST['commentId']);
				$_POST['id_post'] = (int) $_POST['id_post'];
				$id_post = ($_POST['id_post']);

				reComment($comment, $commentId, $id_post);
			}
			else
			{
				throw new Exception('<p>Impossible de modifier le commentaire pour le moment !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}

		//Vérifications pour signaler un commentaire
		elseif (isset($_GET['warnedId'], $_GET['informerId']))
		{
			if ($_GET['warnedId']!='' AND $_GET['informerId']!='')
			{
				$_GET['warnedId'] = (int)$_GET['warnedId'];
				$warnedId = ($_GET['warnedId']);
				$_GET['informerId'] = (int)$_GET['informerId'];
				$informerId = ($_GET['informerId']);

				if (!verifyWarning($warnedId, $informerId))
				{
					addWarnedComments($warnedId, $informerId);
				}
				else
				{
					throw new Exception('<p>Vous avez déjà signalé ce commentaire. Il sera traité dans les plus brefs délais !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Le système de signalement n\'est pas accessible pour le moment.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}

		//Sytème de vérification et d'insertion dans la BDD pour la page d'inscription
		elseif (isset($_POST['pseudo'], $_POST['password'], $_POST['passwordVerify'], $_POST['email']))
		{
			$recaptcha = new \ReCaptcha\ReCaptcha('6LfRh20UAAAAAIR3yJLwr3fZCFybqe6tpklXVixw');
			$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
			if ($resp->isSuccess())
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
										throw new Exception('<p>L\'adresse e-mail renseignée fait l\'objet d\'un bannissement sur ce site. Merci d\'en indiqué une autre.<br/>Retour à la page d\'<a href="index.php?link=inscription" title="Page d\'inscription" class="alert-link">inscription</a></p>');
										}
									}
									else
									{
										throw new Exception('<p>L\'adresse e-mail renseignée existe déjà sur un autre compte. Merci d\'en indiqué une autre.<br/>Retour à la page d\'<a href="index.php?link=inscription" title="Page d\'inscription" class="alert-link">inscription</a></p>');
									}
								}
								else
								{
									throw new Exception('<p>L\'adresse e-mail n\'est pas valide.<br/>Retour à la page d\'<a href="index.php?link=inscription" title="Page d\'inscription" class="alert-link">inscription</a></p>');
								}
							}
							else
							{
								throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à la page d\'<a href="index.php?link=inscription" title="Page d\'inscription" class="alert-link">inscription</a></p>');
							}					
						}
						else
						{
							throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à la page d\'<a href="index.php?link=inscription" title="Page d\'inscription" class="alert-link">inscription</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>Le pseudo indiqué existe déjà. Merci d\'en choisir un autre.<br/>Retour à la page d\'<a href="index.php?link=inscription" title="Page d\'inscription" class="alert-link">inscription</a></p>');
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
				throw new Exception('<p>Impossible de confirmer votre inscription pour le moment. Merci de prendre contact avec nous afin de vous apporter une solution.<br/>Retour à la page de <a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}

		//Système de vérification et de création de session pour la page de connexion + redirection interface admin
		elseif (isset($_POST['id_connect'], $_POST['pass_connect']))
		{

			if ($_POST['id_connect']!='' AND $_POST['pass_connect']!='')
			{
				$id_connect = strip_tags($_POST['id_connect']);
				$pass_connect = strip_tags($_POST['pass_connect']);
				$isTokenPresence = verifyToken($id_connect);
				$connect = verifyConnect($id_connect);
				$isConfirmCorrect = verifyConfirm($id_connect);

				if ($isTokenPresence['token_pass']== NULL)
				{
					if ($isConfirmCorrect['confirm']==1)
					{
						if (password_verify($pass_connect, $connect['password']))
						{
							if ($connect['admin']==1)
							{
								session_start();
						        $_SESSION['id'] = $connect['id'];
						        $_SESSION['pseudo'] = $connect['pseudo'];
						        $_SESSION['email'] = $connect['email'];
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
						        $_SESSION['email'] = $connect['email'];

						        if ($_POST['auto_connect'] == 'checked')
								{
									setcookie('id_user', $connect['pseudo'], time()+60*60*24*30, null, null, false, true);
								}
						        header('Location: index.php');
							}
						}
						else
						{
							throw new Exception('<p>Mauvais identifiant ou mot de passe :/<br/>Retour à la page de <a href="index.php?link=connexion" title="Page de connexion" class="alert-link">connexion</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>Vous devez d\'abord confirmer votre inscription avant de vous connecter.<br/>Retour à la page de <a href="index.php?link=connexion" title="Page de connexion" class="alert-link">connexion</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Vous avez effectué une demande de réinitialisation de mot de passe. Tant que la réinitialisation ne sera pas effectuée, vous ne pourrez pas vous connecter.<br/>Retour à la page de <a href="index.php?link=connexion" title="Page de connexion" class="alert-link">connexion</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Vous devez renseigner votre pseudo et votre mot de passe pour vous connecter.<br/>Retour à la page de <a href="index.php?link=connexion" title="Page de connexion" class="alert-link">connexion</a></p>');
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
					$id = verifyEmail($email);
					$token = newTokenPassword($email);

					sendNewPassword($email, $id['id'], $token);
				}
				else
				{
					throw new Exception('<p>L\'adresse e-mail renseignée est inconnue.<br/>Retour à la page de <a href="index.php?link=connexion" title="Page de connexion" class="alert-link">connexion</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Veuillez saisir une adresse e-mail valide.<br/>Retour à la page de <a href="index.php?link=connexion" title="Page de connexion" class="alert-link">connexion</a></p>');
			}
		}

		//Vérifications pour afficher la page de réinitialisation de mot de passe
		elseif (isset($_GET['id'], $_GET['token']))
		{
			if ($_GET['id']!='' AND $_GET['token']!='')
			{
				$_GET['id'] = (int) $_GET['id'];
				$id = ($_GET['id']);
				$token = $_GET['token'];
				if (verifyTokenPassword($id, $token))
				{
					changePasswordLink();
				}
				else
				{
				throw new Exception('<p>Le temps limite est dépassé. Merci de renouveler votre demande de réinitialisation de mot de passe<br/>Retour à la page de <a href="index.php?link=connexion" title="Page de connexion" class="alert-link">connexion</a></p>');
				}
			}
			else
			{
			throw new Exception('<p>Vous n\'avez pas le droit d\'accéder à cette page.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			}
		}

		//Vérifications pour réinitialiser son mot de passe
		elseif (isset($_POST['reset_password'], $_POST['confirm_reset_password'], $_POST['email']))
		{
			if ($_POST['reset_password']!='' AND $_POST['confirm_reset_password']!='' AND $_POST['email']!='')
			{
				if ($_POST['reset_password'] == $_POST['confirm_reset_password'])
				{
					$reset_password = strip_tags($_POST['reset_password']);
					$email = strip_tags($_POST['email']);

					if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $reset_password))
					{
						$pass_hash = password_hash($reset_password, PASSWORD_DEFAULT);

						deleteToken($email);
						resetPassword($pass_hash, $email);
					}
					else
					{
						throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à la page de <a href="index.php?link=change_password" title="Page de réinitialisation" class="alert-link">réinitialisation</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à la page de <a href="index.php?link=change_password" title="Page de réinitialisation" class="alert-link">réinitialisation</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Veuillez saisir un mot de passe.<br/>Retour à la page de <a href="index.php?link=change_password" title="Page de réinitialisation" class="alert-link">réinitialisation</a></p>');
			}
		}

		//Vréifications pour contacter l'admin
		elseif (isset($_POST['subject'], $_POST['email'], $_POST['message']))
		{
			$recaptcha = new \ReCaptcha\ReCaptcha('6LfRh20UAAAAAIR3yJLwr3fZCFybqe6tpklXVixw');
			$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
			if ($resp->isSuccess())
			{
				if ($_POST['subject']!='' AND $_POST['email']!='' AND $_POST['message']!='')
				{
					$contact_subject = strip_tags($_POST['subject']);
					$contact_email = strip_tags($_POST['email']);
					$contact_message = strip_tags($_POST['message']);

					if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $contact_email))
					{
						contact($contact_subject, $contact_email, $contact_message);
					}
					else
					{
						throw new Exception('<p>L\'adresse e-mail n\'est pas valide.<br/>Retour à la page de <a href="index.php?link=contact" title="Page de contact" class="alert-link">contact</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Vous devez remplir tous les champs.<br/>Retour à la page de <a href="index.php?link=contact" title="Page de contact" class="alert-link">contact</a></p>');
				}
			}
			else
			{
			    $errors = $resp->getErrorCodes();
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
		elseif (isset($_POST['add_title'], $_POST['add_content'], $_POST['description'], $_FILES['image']))
		{
			if ($_POST['add_title']!='' AND $_POST['add_content']!='' AND $_POST['description']!='' AND !empty($_FILES['image']))
			{
				if ($_FILES['image']['error'] == 0)
				{
					if ($_FILES['image']['size']<=500000)
					{
						$data_files = pathinfo($_FILES['image']['name']);
						$extension_upload = $data_files['extension'];
						$authorized_extensions = array('jpg', 'jpeg', 'png');

						if (in_array($extension_upload, $authorized_extensions))
						{
							$description = strip_tags($_POST['description']);
							$title = strip_tags($_POST['add_title']);
							$content = strip_tags($_POST['add_content']);

							addPost($title, $content, $description, $extension_upload);
							$lastId = lastId();
							$id = $lastId->fetch();
							move_uploaded_file($_FILES['image']['tmp_name'], 'public/images/cover/' . $id['last'] . '.' . $extension_upload);

							$path = 'Location: http://127.0.0.1/blog/index.php?link=admin';
							header($path);
						}
						else
						{
							throw new Exception('<p>Le format de l\'image n\'est pas conforme. Pour rappel, vous devez transmettre une image au format "JPG", "JPEG" ou "PNG".<br/>Retour à l\' <a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>L\'image est trop volumineuse. Pour rappel, elle ne doit pas dépasser 500Ko.<br/>Retour à l\' <a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Une erreur est survenue lors du téléchargement.<br/>Retour à l\' <a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Vous devez renseigné tous les champs !<br/>Retour à l\'<a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour l'affichage d'un post (administrateur)
		elseif (isset($_GET['read']))
		{
			if ($_GET['read']!='')
			{
				$_GET['read'] = (int) $_GET['read'];
				$postId = ($_GET['read']);

				readPost($postId);
			}
			else
			{
				throw new Exception('<p>Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour l'affichage d'un post à modifier (administrateur)
		elseif (isset($_GET['update']))
		{
			if ($_GET['update']!='')
			{
				$_GET['update'] = (int) $_GET['update'];
				$postId = ($_GET['update']);

				changePost($postId);
			}
			else
			{
				throw new Exception('<p>Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour modifier un post
		elseif (isset($_POST['up_title'], $_POST['up_content'], $_POST['id']))
		{
			if ($_POST['up_title']!='' AND $_POST['up_content']!='' AND $_POST['id']!='')
			{
				$title = strip_tags($_POST['up_title']);
				$content = strip_tags($_POST['up_content']);
				$_POST['id'] = (int) $_POST['id'];
				$id = $_POST['id'];

				rePost($title, $content, $id);
			}
			else
			{
				throw new Exception('<p>Impossible de modifier le billet pour le moment.<br/>Retour à l\'<a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour changer d'illustration
		elseif (isset($_POST['description'], $_FILES['image'], $_POST['id']))
		{
			if ($_POST['description']!='' AND !empty($_FILES['image']) AND $_POST['id']!='')
			{
				if ($_FILES['image']['error'] == 0)
				{
					if ($_FILES['image']['size']<=500000)
					{
						$description = strip_tags($_POST['description']);
						$_POST['id'] = (int) $_POST['id'];
						$id = ($_POST['id']);

						$data_files = pathinfo($_FILES['image']['name']);
						$extension_upload = $data_files['extension'];
						$authorized_extensions = array('jpg', 'jpeg', 'png');

						if (in_array($extension_upload, $authorized_extensions))
						{
							move_uploaded_file($_FILES['image']['tmp_name'], 'public/images/cover/' . $id . '.' . $extension_upload);
							changeImage($description, $extension_upload, $id);
						}
						else
						{
							throw new Exception('<p>Le format de l\'image n\'est pas conforme. Pour rappel, vous devez transmettre une image au format "JPG", "JPEG" ou "PNG".<br/>Retour à l\' <a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>L\'image est trop volumineuse. Pour rappel, elle ne doit pas dépasser 500Ko.<br/>Retour à l\' <a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Une erreur est survenue lors du téléchargement.<br/>Retour à l\' <a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
				}
			}
			else
			{
				throw new Exception('<p>Vous devez renseigné tous les champs !<br/>Retour à l\' <a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
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
				throw new Exception('<p>Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour suppression du post
		elseif (isset($_POST['delete'], $_POST['id'], $_POST['extension']))
		{
			if ($_POST['delete']=='confirm' AND $_POST['id']!='' AND $_POST['extension']!='')
			{
				$_POST['id'] = (int) $_POST['id'];
				$id = ($_POST['id']);
				$extension = strip_tags($_POST['extension']);
				eraseImage($id, $extension);
				erasePost($id);
			}
			elseif ($_POST['delete']=='cancel' AND $_POST['id']!='')
			{
				listPostsAdmin();
			}
			else
			{
				throw new Exception('<p>Vous n\'avez pas renseigné votre choix. Prenez votre temps pour peser le pour et le contre ;)<br/>Retour à l\'<a href="index.php?link=admin" title="Page d\'administration" class="alert-link">interface d\'administration</a></p>');
			}
		}

		//Vérifications pour supprimer un commentaire signalé
		elseif (isset($_GET['eraseComment']))
		{
			if ($_GET['eraseComment']!='')
			{
				$eraseComment = strip_tags($_GET['eraseComment']);

				eraseWarnedComment($eraseComment);
			}
			else
			{
				throw new Exception('<p>Le système de suppression des commentaires signalés n\'est pas disponible pour le moment.<br/>Retour à la page de <a href="index.php?link=moderate" title="Page de modération" class="alert-link">modération</a></p>');
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
				throw new Exception('<p>Le système de suppression des commentaires signalés n\'est pas disponible pour le moment.<br/>Retour à la page de <a href="index.php?link=moderate" title="Page de modération" class="alert-link">modération</a></p>');
			}
		}

																				//PROFIL:
		//Vérifications pour changer de pseudo
		elseif (isset($_POST['new_pseudo'], $_POST['password'], $_POST['id']))
		{
			if ($_POST['new_pseudo']!='' AND $_POST['password']!='' AND $_POST['id']!='')
			{
				$new_pseudo = strip_tags($_POST['new_pseudo']);
				$password = strip_tags($_POST['password']);
				$_POST['id'] = (int) $_POST['id'];
				$id = ($_POST['id']);

				$isPassCorrect = verifyConnect($id);

				if (password_verify($password, $isPassCorrect['password']))
				{
					if (!verifyPseudo($_POST['new_pseudo']))
					{
						session_start();
						$_SESSION['pseudo'] = $new_pseudo;

						newPseudo($_SESSION['pseudo'], $isPassCorrect['pseudo']);
					}
					else
					{
						throw new Exception('<p>Le pseudo indiqué existe déjà. Merci d\'en choisir un autre.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué n\'est pas correct.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
				}
			}
		}

		//Vérifications pour changer d'adresse e-mail
		elseif (isset($_POST['new_email'], $_POST['password'], $_POST['id']))
		{
			if ($_POST['new_email']!='' AND $_POST['password']!='' AND $_POST['id']!='')
			{
				$new_email = strip_tags($_POST['new_email']);
				$password = strip_tags($_POST['password']);
				$_POST['id'] = (int) $_POST['id'];
				$id = ($_POST['id']);

				$isPassCorrect = verifyConnect($id);

				if (password_verify($password, $isPassCorrect['password']))
				{
					if (!verifyEmail($new_email))
					{
						newEmail($new_email, $id);
					}
					else
					{
						throw new Exception('<p>L\'adresse e-mail indiqué existe déjà. Merci d\'en choisir une autre.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué n\'est pas correct.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
				}
			}
		}

		//Vérifications pour changer de mot de passe
		elseif (isset($_POST['old_password'], $_POST['change_password'], $_POST['confirm_change_password'], $_POST['id']))
		{
			if ($_POST['old_password']!='' AND $_POST['change_password']!='' AND $_POST['confirm_change_password']!='' AND $_POST['id']!='')
			{
				$old_password = strip_tags($_POST['old_password']);
				$new_password = strip_tags($_POST['change_password']);
				$confirm_new_password = strip_tags($_POST['confirm_change_password']);
				$_POST['id'] = (int) $_POST['id'];
				$id = ($_POST['id']);

				$isPassCorrect = verifyConnect($id);

				if (password_verify($old_password, $isPassCorrect['password']))
				{
					if ($new_password==$confirm_new_password)
					{
						if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $new_password))
						{
							$pass_hash = password_hash($new_password, PASSWORD_DEFAULT);

							newPassword($pass_hash, $id);
						}
						else
						{
							throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
						}
					}
					else
					{
						throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué comme étant votre ancien mot de passe n\'est pas correct.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
				}
			}
		}

		//Vérifications pour supprimer un compte utilisateur (admin)
		elseif (isset($_POST['user_pseudo'], $_POST['reasons_suppression'], $_POST['password'], $_POST['id']))
		{
			if ($_POST['user_pseudo']!='' AND $_POST['reasons_suppression']!='' AND $_POST['password']!='' AND $_POST['id']!='')
			{
				$user_pseudo = strip_tags($_POST['user_pseudo']);
				$reasons = strip_tags($_POST['reasons_suppression']);
				$password = strip_tags($_POST['password']);
				$_POST['id'] = (int) $_POST['id'];
				$id = ($_POST['id']);
				$isPassCorrect = verifyConnect($id);

				if (password_verify($password, $isPassCorrect['password']))
				{
					if (verifyPseudo($user_pseudo))
					{
						$email = selectEmail($user_pseudo);

						bannedUser($user_pseudo, $email['email'], $reasonspseudo);
					}
					else
					{
						throw new Exception('<p>Le pseudo renseigné n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
					}
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué n\'est pas correct.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
				}
			}
		}

		//Vérifications pour afficher la demande de suppression du compte
		elseif (isset($_POST['password'], $_POST['id']))
		{
			if ($_POST['password']!='' AND $_POST['id']!='')
			{
				$password = strip_tags($_POST['password']);
				$_POST['id'] = (int) $_POST['id'];
				$isPassCorrect = verifyConnect($_POST['id']);

				if (password_verify($password, $isPassCorrect['password']))
				{
					confirmDeleteAccount();
				}
				else
				{
					throw new Exception('<p>Le mot de passe indiqué n\'est pas correct.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
				}
			}
		}

		//Vérifications pour supprimer son compte
		elseif (isset($_POST['delete_account'], $_POST['pseudo'], $_POST['id']))
		{
			if ($_POST['delete_account']=='confirm' AND $_POST['pseudo']!='' AND $_POST['id']!='')
			{
				$pseudo = strip_tags($_POST['pseudo']);
				$_POST['id'] = (int) $_POST['id'];
				$id = ($_POST['id']);
				eraseAccount($pseudo, $id);
			}
			elseif ($_POST['delete_account']=='cancel' AND $_POST['pseudo']!='' AND $_POST['id']!='')
			{
				$path = 'Location: http://127.0.0.1/blog/index.php';
				header($path);
			}
			else
			{
				throw new Exception('<p>Vous n\'avez pas renseigné votre choix. Prenez votre temps pour peser le pour et le contre ;)<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
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
*/