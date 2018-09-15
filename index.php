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
			elseif ($_GET['link'] == 'deconnexion')
			{
				signOutLink();
			}
		}
		//Vérifications pour l'affichage d'un post et de ses commentaires
		elseif (isset($_GET['post']) AND $_GET['post']!= '')
		{
			$postId = $_GET['post'];
			post($postId);
		}

		//Vérifications pour l'ajout d'un commentaire
		elseif (isset($_POST['comment']))
		{
			if ($_POST['comment']!='')
			{
				insertComment($_POST['postId'], $_POST['pseudo'], $_POST['comment']);
			}
		}

		//Vérifications pour modifier un commentaire
		elseif (isset($_POST['up_comment']) AND isset($_POST['id']))
		{
			if ($_POST['up_comment']!='' AND $_POST['id']!='')
			{
				reComment($_POST['up_comment'], $_POST['id']);
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
						verifyPseudo($pseudo);

						if (!verifyPseudo($pseudo))
						{
							if ($password==$_POST['passwordVerify'])
							{
								if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $password))
								{
									if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
									{
										verifyEmail($email);

										if(!verifyEmail($email))
										{
											$pass_hash = password_hash($password, PASSWORD_DEFAULT);

											registration($pseudo, $pass_hash, $email);
										}
										else
										{
											throw new Exception('<p>L\'adresse e-mail renseigné existe déjà sur un autre compte. Merci d\'en indiqué une autre.<br/>Retour à la page d\'<a href="view/frontend/registration.php">inscription</a></p>');
										}
									}
									else
									{
										throw new Exception('<p>L\'adresse e-mail n\'est pas valide.<br/>Retour à la page d\'<a href="view/frontend/registration.php">inscription</a></p>');
									}
								}
								else
								{
									throw new Exception('<p>Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>Retour à la page d\'<a href="view/frontend/registration.php">inscription</a></p>');
								}					
							}
							else
							{
								throw new Exception('<p>Le mot de passe ne correspond pas à celui renseigné.<br/>Retour à la page d\'<a href="view/frontend/registration.php">inscription</a></p>');
							}
						}
						else
						{
							throw new Exception('<p>Le pseudo indiqué existe déjà. Merci d\'en choisir un autre.<br/>Retour à la page d\'<a href="view/frontend/registration.php">inscription</a></p>');
						}
						
					}
				}
			}
			else
			{
			    $errors = $resp->getErrorCodes();
			}
		}

		//Système de vérification et de création de session pour la page de connexion
		elseif (isset($_POST['id_connect']) AND isset($_POST['pass_connect']))
		{
			if ($_POST['id_connect']!='' AND $_POST['pass_connect']!='')
			{
				$id_connect = strip_tags($_POST['id_connect']);
				$pass_connect = strip_tags($_POST['pass_connect']);
				$isPassCorrect = verifyConnect($id_connect);

				if (password_verify($pass_connect, $isPassCorrect['password']))
				{
					session_start();
			        $_SESSION['id'] = $isPassCorrect['id'];
			        $_SESSION['pseudo'] = $isPassCorrect['pseudo'];

			        header('Location: index.php');
				}
				else
				{
					throw new Exception('<p>Mauvais identifiant ou mot de passe :/<br/>Retour à la page de <a href="signInView.php">connexion</a></p>');
				}	
			}
		}

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