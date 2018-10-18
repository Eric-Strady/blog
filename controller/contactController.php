<?php

	require ('recaptcha/autoload.php');
	require_once('model/Contact.php');

	use \Eric\Blog\Model\Contact\Contact;

												//DEFINE ACTION

	if (isset($_GET['action']) AND !empty($_GET['action']))
	{
		$action = strip_tags($_GET['action']);
		switch ($action)
		{
			case 'message':
				contact();
			break;

			default:
				throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
			break;
		}
	}
	else
	{
		require 'view/frontend/contactView.php';
	}

												//FUNCTIONS

	function contact()
	{
		$recaptcha = new \ReCaptcha\ReCaptcha('6LfRh20UAAAAAIR3yJLwr3fZCFybqe6tpklXVixw');
		$resp = $recaptcha->verify($_POST['g-recaptcha-response']);
		if ($resp->isSuccess())
		{
			if (isset($_POST['email'], $_POST['subject'], $_POST['message']))
			{
				if ($_POST['email']!='' AND $_POST['subject']!='' AND $_POST['message']!='')
				{
					$email = strip_tags($_POST['email']);
					$subject = strip_tags($_POST['subject']);
					$message = strip_tags($_POST['message']);

					$contact = new Contact(['email' => $email, 'subject' => $subject, 'message' => $message]);
					$contact->sendMessage();

					$path = 'Location: http://127.0.0.1/blog/index.php?link=contact&send=message';
					header($path);
				}
				else
				{
					throw new Exception('<p>Vous devez renseigné tous les champs.<br/>Retour à la page de <a href="index.php?link=contact" title="Page de contact" class="alert-link">contact</a></p>');
				}
			}
			else
			{
			    throw new Exception('<p>Vous devez renseigné tous les champs.<br/>Retour à la page de <a href="index.php?link=contact" title="Page de contact" class="alert-link">contact</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Le reCAPTCHA est obligatoire !<br/>Retour à la page de <a href="index.php?link=contact" title="Page de contact" class="alert-link">contact</a></p>');
		}
	}