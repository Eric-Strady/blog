<?php

require ('recaptcha/autoload.php');

//Sytème de vérification et d'insertion dans la BDD pour la page d'inscription

if (isset($_POST['g-recaptcha-response']))
{
	$recaptcha = new \ReCaptcha\ReCaptcha('6LfRh20UAAAAAIR3yJLwr3fZCFybqe6tpklXVixw');
	$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
	if ($resp->isSuccess())
	{
		if (isset($_POST['pseudo']) AND isset($_POST['password']) AND isset($_POST['passwordVerify']) AND isset($_POST['email']) )
		{

			if ($_POST['pseudo']!='' AND $_POST['password']!='' AND $_POST['passwordVerify']!='' AND $_POST['email']!='')
			{
				try
				{
					$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
				}
				catch (Exception $e)
				{
					die('Erreur: ' . $e->getMessage());
				}

				$pseudo = strip_tags($_POST['pseudo']);
				$password = strip_tags($_POST['password']);
				$email = strip_tags($_POST['email']);

				$req = $db->prepare('SELECT pseudo FROM users WHERE pseudo = :pseudo ');
				$req->execute(array('pseudo' => $pseudo));
				$verifyPseudo = $req->fetch();

				if (!$verifyPseudo)
				{
					$req->closeCursor();

					if ($password==$_POST['passwordVerify'])
					{
						if (preg_match("#((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,255})#", $password))
						{
							if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
							{
								$req = $db->prepare('SELECT email FROM users WHERE email = :email ');
								$req->execute(array('email' => $email));
								$verifyEmail = $req->fetch();

								if(!$verifyEmail)
								{
									$req->closeCursor();

									$pass_hash = password_hash($password, PASSWORD_DEFAULT);

									$registration = $db->prepare('INSERT INTO users( pseudo, password, email, registration_date) VALUES (:pseudo, :password, :email, NOW())');
									$registration->execute(array('pseudo' => $pseudo, 'password' => $pass_hash, 'email' => $email));

									$redirection = 'Location: http://127.0.0.1/blog/signin.php?pseudo=' . $pseudo;
									header($redirection);
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

if (isset($_POST['id_connect']) AND isset($_POST['pass_connect']))
{
	if ($_POST['id_connect']!='' AND $_POST['pass_connect']!='')
	{
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
		}
		catch (Exception $e)
		{
			die('Erreur: ' . $e->getMessage());
		}

		$id_connect = strip_tags($_POST['id_connect']);
		$pass_connect = strip_tags($_POST['pass_connect']);


		$req = $db->prepare('SELECT id, pseudo, password FROM users WHERE pseudo = :pseudo OR email = :email');
		$req->execute(array('pseudo' => $id_connect, 'email' => $id_connect));
		$verifyConnect = $req->fetch();

		if (password_verify($pass_connect, $verifyConnect['password']))
		{
			session_start();
	        $_SESSION['id'] = $verifyConnect['id'];
	        $_SESSION['pseudo'] = $verifyConnect['pseudo'];

	        header('Location: index.php');
		}
		else
		{
			echo 'Mauvais identifiant ou mot de passe :/<br/>';
			echo 'Retour à la page de <a href="signin.php">connexion</a>';
		}	
	}
}