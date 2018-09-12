<?php
	require ('controller/controller.php');
	require ('recaptcha/autoload.php');

	try
	{
		if (isset($_GET['post']) AND $_GET['post']!= '')
		{
			$postId = $_GET['post'];
			post($postId);
		}
		elseif (isset($_POST['pseudo']) AND isset($_POST['comment']))
		{
			if ($_POST['pseudo']!='' AND $_POST['comment']!='')
			{
				insertComment($_POST['postId'], $_POST['pseudo'], $_POST['comment']);
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
											echo 'L\'adresse e-mail renseigné existe déjà sur un autre compte. Merci d\'en indiqué une autre.<br/>';
											echo 'Retour à la page d\'<a href="registration.php">inscription</a>';
										}
									}
									else
									{
										echo 'L\'adresse e-mail n\'est pas valide.<br/>';
										echo 'Retour à la page d\'<a href="registration.php">inscription</a>';
									}
								}
								else
								{
									echo 'Le mot de passe indiqué n\'est pas assez fort! Pour votre sécurité, merci d\'en saisir un autre.<br/>';
									echo 'Retour à la page d\'<a href="registration.php">inscription</a>';
								}					
							}
							else
							{
								echo 'Le mot de passe ne correspond pas à celui renseigné.<br/>';
								echo 'Retour à la page d\'<a href="registration.php">inscription</a>';
							}
						}
						else
						{
							echo 'Le pseudo indiqué existe déjà. Merci d\'en choisir un autre.<br/>';
							echo 'Retour à la page d\'<a href="registration.php">inscription</a>';
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
					echo 'Mauvais identifiant ou mot de passe :/<br/>';
					echo 'Retour à la page de <a href="signInView.php">connexion</a>';
				}	
			}
		}
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