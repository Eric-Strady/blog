<?php

	require_once('model/Posts.php');
	require_once('model/Warning.php');

	use \Eric\Blog\Model\Posts\Posts;
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

	function eraseWarnedComment($id_comment, $id)
	{
		$commentsManager = new Comments();
		$warningManager = new Warning();

		$commentsManager->deleteComment($id_comment);
		$warningManager->deleteWarning($id);

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();
	}

	function justDeleteWarning($id)
	{
		$warningManager = new Warning();
		$warningManager->deleteWarning($id);

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();
	}