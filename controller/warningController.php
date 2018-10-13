<?php

	require_once('model/CommentsManager.php');
	require_once('model/WarningManager.php');

	use \Eric\Blog\Model\Comments\CommentsManager;
	use \Eric\Blog\Model\Warning\WarningManager;

	//Commentaires signalés
	function listWarnedComments()
	{
		$warningManager = new WarningManager();
		$listWarnedComments = $warningManager->getWarningComments();

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/warningCommentsView.php');
	}

	function eraseWarnedComment($id_comment)
	{
		$commentsManager = new CommentsManager();
		$warningManager = new WarningManager();

		$commentsManager->deleteComment($id_comment);
		$warningManager->deleteWarning($id_comment);

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();
	}

	function justDeleteWarning($id_comment)
	{
		$warningManager = new WarningManager();
		$warningManager->deleteWarning($id_comment);

		$countWarning = new WarningManager();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();
	}