<?php

	require_once('model/Warning.php');
	require_once('model/WarningManager.php');

	use \Eric\Blog\Model\Warning\Warning;
	use \Eric\Blog\Model\Warning\WarningManager;

												//DEFINE ACTION

	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	{
		if (isset($_GET['action']) AND !empty($_GET['action']))
		{
			$action = strip_tags($_GET['action']);
			switch ($action)
			{
				case 'list':
					listWarned();
				break;

				default:
					throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
				break;
			}
		}
		else
		{
			throw new Exception('<p>Cette page n\'existe pas.<br/>Retour à l\'<a href="index.php?link=admin" title="Interface d\'administration" class="alert-link">interface d\'administration</a></p>');
		}

												//FUNCTIONS

		function listWarned()
		{
			require 'view/backend/warningCommentsView.php';
		}
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	}