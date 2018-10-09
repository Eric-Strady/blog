<?php

	require_once('model/Comments.php');
	require_once('model/Warning.php');

	use \Eric\Blog\Model\Comments\Comments;
	use \Eric\Blog\Model\Warning\Warning;

	//Commentaires signalés
	function listWarnedComments()
	{
		$warningManager = new Warning();
		$listWarnedComments = $warningManager->getWarningComments();

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/warningCommentsView.php');
	}

	function eraseWarnedComment($id_comment)
	{
		$commentsManager = new Comments();
		$warningManager = new Warning();

		$commentsManager->deleteComment($id_comment);
		$warningManager->deleteWarning($id_comment);

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();
	}

	function justDeleteWarning($id_comment)
	{
		$warningManager = new Warning();
		$warningManager->deleteWarning($id_comment);

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();
	}