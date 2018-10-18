<?php

	require_once('model/Warning.php');
	require_once('model/WarningManager.php');
	require_once('model/CommentsManager.php');

	use \Eric\Blog\Model\Warning\Warning;
	use \Eric\Blog\Model\Warning\WarningManager;
	use \Eric\Blog\Model\Comments\CommentsManager;

												//DEFINE ACTION

	if (isset($_SESSION['admin']) AND $_SESSION['admin']=='ok')
	{
		if (isset($_GET['action']) AND !empty($_GET['action']))
		{
			$action = strip_tags($_GET['action']);
			switch ($action)
			{
				case 'list':
					showWarned();
				break;

				case 'delete_comment':
					eraseComment();
				break;

				case 'conserve_comment':
					eraseWarning();
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
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à aller sur cette page !<br/>Retour à la page d\'<a href="index.php" title="Page d\'accueil" class="alert-link">accueil</a></p>');
	}

												//FUNCTIONS

	function showWarned()
	{
		$warning = new Warning([]);
		$warningManager = new WarningManager();
		$warning = $warningManager->listWarned();
		
		require 'view/backend/warningCommentsView.php';
	}

	function eraseComment()
	{
		if (isset($_GET['id_comment']) AND $_GET['id_comment']!='')
		{
			$id_comment = $_GET['id_comment'];
			$warning = new Warning(['id_comment' => $id_comment]);
			$warningManager = new WarningManager();
			$commentsManager = new CommentsManager();

			if ($warningManager->isExist($warning->getIdComment()))
			{
				$commentsManager->deleteComment($warning->getIdComment());

				$path = 'Location: http://127.0.0.1/blog/index.php?link=moderate&action=list';
				header($path);
			}
			else
			{
				throw new Exception('<p>Ce commentaire n\'existe pas !<br/>Retour à la page de <a href="index.php?link=moderate&amp;action=list" title="Page de modération" class="alert-link">modération</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseigner l\'identifiant du comentaire.<br/>Retour à la page de <a href="index.php?link=moderate&amp;action=list" title="Page de modération" class="alert-link">modération</a></p>');
		}
	}

	function eraseWarning()
	{
		if (isset($_GET['id_comment']) AND $_GET['id_comment']!='')
		{
			$id_comment = $_GET['id_comment'];
			$warning = new Warning(['id_comment' => $id_comment]);
			$warningManager = new WarningManager();

			if ($warningManager->isExist($warning->getIdComment()))
			{
				$warningManager->deleteWarning($warning);
				
				$path = 'Location: http://127.0.0.1/blog/index.php?link=moderate&action=list';
				header($path);
			}
			else
			{
				throw new Exception('<p>Ce commentaire n\'existe pas !<br/>Retour à la page de <a href="index.php?link=moderate&amp;action=list" title="Page de modération" class="alert-link">modération</a></p>');
			}
		}
		else
		{
			throw new Exception('<p>Vous devez renseigner l\'identifiant du comentaire.<br/>Retour à la page de <a href="index.php?link=moderate&amp;action=list" title="Page de modération" class="alert-link">modération</a></p>');
		}
	}