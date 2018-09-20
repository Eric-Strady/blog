<?php
	require ('controller/controller.php');
	require ('recaptcha/autoload.php');

	try
	{
		if (isset($_GET['link']) AND $_GET['link']!= '')
		{
			if ($_GET['link'] == 'inscription')
			{
				registrationLink();
			}
			elseif ($_GET['link'] == 'connexion')
			{
				signinLink();
			}
			elseif ($_GET['link'] == 'confirmed')
			{
				confirmLink();
			}
			elseif ($_GET['link'] == 'new_password')
			{
				newPasswordLink();
			}
			elseif ($_GET['link'] == 'admin')
			{
				listPostsAdmin();
			}
			elseif ($_GET['link'] == 'create')
			{
				newPost();
			}
			elseif ($_GET['link'] == 'moderate')
			{
				listWarnedComments();
			}
			elseif ($_GET['link'] == 'admin_account')
			{
				adminAccountLink();
			}
			elseif ($_GET['link'] == 'deconnexion')
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
				throw new Exception('Impossible d\'ajouter de commentaire pour le moment !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
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
				throw new Exception('Impossible de modifier le commentaire pour le moment !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
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
										if(!verifyEmail($email))
										{
											$pass_hash = password_hash($password, PASSWORD_DEFAULT);

											registration($pseudo, $pass_hash, $email);
										}
										else
										{
											throw new Exception('<p>L\'adresse e-mail renseigné existe déjà sur un autre compte. Merci d\'en indiqué une autre.<br/>Retour à la page d\'<a href="index.php?link=inscription">inscription</a></p>');
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
		elseif (isset($_POST['id_connect']) AND isset($_POST['pass_connect']))
		{
			if ($_POST['id_connect']!='' AND $_POST['pass_connect']!='')
			{
				$id_connect = strip_tags($_POST['id_connect']);
				$pass_connect = strip_tags($_POST['pass_connect']);
				$isPassCorrect = verifyConnect($id_connect);
				$isConfirmCorrect = verifyConfirm($id_connect);

				if ($isConfirmCorrect['confirm']==1)
				{
					if (password_verify($pass_connect, $isPassCorrect['password']))
					{
						if ($_POST['id_connect']=='Coxus' OR $_POST['id_connect']=='coxus' OR $_POST['id_connect']=='coxus@gmail.com')
						{
							session_start();
					        $_SESSION['id'] = $isPassCorrect['id'];
					        $_SESSION['pseudo'] = $isPassCorrect['pseudo'];

					        listPostsAdmin();
						}
						else
						{
							session_start();
					        $_SESSION['id'] = $isPassCorrect['id'];
					        $_SESSION['pseudo'] = $isPassCorrect['pseudo'];

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
		elseif (isset($_POST['new_password']) AND $_POST['new_password']!='')
		{
			$email = strip_tags($_POST['new_password']);
			if (verifyEmail($email))
			{
				sendNewPassword($email);
			}
			else
			{
				throw new Exception('Le système de signalement de réinitialisation de mot de passe n\'est pas accessible pour le moment.<br/>Retour à la page de <a href="index.php">accueil</a></p>');
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
					throw new Exception('Ce commentaire a déjà été signalé et sera traité dans les plus brefs délais !<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
				}
			}
			else
			{
				throw new Exception('Le système de signalement n\'est pas accessible pour le moment.<br/>Retour à la page d\'<a href="index.php">accueil</a></p>');
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
				throw new Exception('Impossible de créer de billet pour le moment.<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
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
				throw new Exception('Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
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
				throw new Exception('Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
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
				throw new Exception('Impossible de modifier le billet pour le moment.<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
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
				throw new Exception('Le billet auquel vous souhaitez accéder n\'existe pas !<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
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
				throw new Exception('Vous n\'avez pas renseigné votre choix. Prenez votre temps pour peser le pour et le contre ;)<br/>Retour à l\'<a href="index.php?link=admin">interface d\'administration</a></p>');
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
				throw new Exception('Le système de suppression des commentaires signalés n\'est pas disponible pour le moment.<br/>Retour à la page de <a href="index.php?link=moderate">modération</a></p>');
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
				throw new Exception('Le système de suppression des commentaires signalés n\'est pas disponible pour le moment.<br/>Retour à la page de <a href="index.php?link=moderate">modération</a></p>');
			}
		}

		//Vérifications pour changer de pseudo
		elseif (isset($_POST['new_pseudo']) AND isset($_POST['pseudo']))
		{
			if ($_POST['new_pseudo']!='')
			{
				if (!verifyPseudo($_POST['new_pseudo']))
				{
					$new_pseudo = strip_tags($_POST['new_pseudo']);
					$pseudo = $_POST['pseudo'];

					session_start();
					$_SESSION['pseudo'] = $new_pseudo;

					newPseudo($_SESSION['pseudo'], $pseudo);
				}
				else
				{
					throw new Exception('<p>Le pseudo indiqué existe déjà. Merci d\'en choisir un autre.<br/>Retour à votre <a href="index.php?link=admin_account">profil</a></p>');
				}
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