<?php

	require_once('model/Posts.php');
	require_once('model/Comments.php');
	require_once('model/Comments.php');

	use \Eric\Blog\Model\Posts\Posts;
	use \Eric\Blog\Model\Comments\Comments;
	use \Eric\Blog\Model\Warning\Warning;

	//Affichage du post selectionné et de ses commentaires + ajout de commentaire + modification de commentaire
	function post($postId)
	{
		$postsManager = new Posts();
		$commentsManager = new Comments();

		$post = $postsManager->getPost($postId);

		if (!empty($postId))
		{
			$comments = $commentsManager->getComments($postId);

			require('view/frontend/postView.php');
		}
		else
		{
			throw new Exception('Le billet auquel vous souhaitez accéder n\'existe pas !');
		}
	}

	function insertComment($postId, $pseudo, $email, $comment)
	{
		$commentsManager = new Comments();
		$commentsManager->addComment($postId, $pseudo, $email, $comment);
	}

	function reComment($comment, $commentId, $id_post)
	{
		$commentsManager = new Comments();
		$commentsManager->updateComment($comment, $commentId, $id_post);
	}

	//Commentaires signalés
	function addWarnedComments($id)
	{
		$commentsManager = new Comments();
		$warningManager = new Warning();

		$careComment = $commentsManager->getComment($id);
		$warnedComment = $careComment->fetch();

		$warningManager->insertWarnedComment($warnedComment['id'], $warnedComment['author'], $warnedComment['comment'], $warnedComment['id_post']);
	}

	function verifyWarning($id)
	{
		$warningManager = new Warning();
		$verifyWarning = $warningManager->checkWarning($id);

		return $verifyWarning;
	}