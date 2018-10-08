<?php

	require_once('model/Posts.php');
	require_once('model/Comments.php');
	require_once('model/Users.php');
	require_once('model/AdminManager.php');
	require_once('model/Warning.php');
	require_once('model/Banned.php');

	use \Eric\Blog\Model\Posts\Posts;
	use \Eric\Blog\Model\Comments\Comments;
	use \Eric\Blog\Model\Users\Users;
	use \Eric\Blog\Model\Admin\AdminManager;
	use \Eric\Blog\Model\Warning\Warning;
	use \Eric\Blog\Model\Banned\Banned;

																					//FRONTEND :

	//Affichage des posts + pagination pour listPostsView
	function listPosts()
	{
		$count = new Posts();
		$postManager = new Posts();

		$max_nb_post = 5;
		$req = $count->countPosts();
		$total_post = $req->fetch();
		$req->closeCursor();
		$nb_post = $total_post['nb_post'];
		$nb_page = ceil($nb_post/$max_nb_post);

		if (isset($_GET['page']))
		{
			strip_tags($_GET['page']);
			$_GET['page'] = (int)$_GET['page'];
			$current_page = $_GET['page'];
			if ($current_page == 0)
			{
				$current_page = 1;
			}
			elseif ($current_page > $nb_page)
			{
				$current_page = $nb_page;
			}
		}
		else
		{
			$current_page = 1;
		}

		$first_post = ($current_page-1)*$max_nb_post;

		$req = $postManager->getPosts($first_post, $max_nb_post);

		require('view/frontend/listPostsView.php');
	}

	//Liens vers les pages du menu

	function registrationLink()
	{
		require('view/frontend/registrationView.php');
	}
	function signinLink()
	{
		require('view/frontend/signInView.php');
	}
	function contactLink()
	{
		require('view/frontend/contactView.php');
	}
	function newPasswordLink()
	{
		require('view/frontend/newPasswordView.php');
	}
	function changePasswordLink()
	{
		require('view/frontend/changePasswordView.php');
	}
	function signoutLink()
	{
		require('view/frontend/signOutView.php');
	}
	function confirmLink()
	{
		require('view/frontend/confirmedRegistrationView.php');
	}

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

	//Vérifications pour l'insciption d'un utilisateur + inscription et confirmation par e-mail
	function verifyPseudo($pseudo)
	{
		$verifyPseudo = new Users();
		$avaiblePseudo = $verifyPseudo->checkPseudo($pseudo);

		return $avaiblePseudo;
	}

	function verifyEmail($email)
	{
		$verifyEmail = new Users();
		$avaibleEmail = $verifyEmail->checkEmail($email);

		return $avaibleEmail;
	}

	function verifyBanned($email)
	{
		$verifyBanned = new Banned();
		$avaibleAccount = $verifyBanned->checkBanned($email);

		return $avaibleAccount;
	}

	function registration($pseudo, $pass_hash, $email)
	{
		$registration = new Users();

		$length = 10;
		$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$maxLength = strlen($string);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
		$randomString.= $string[rand(0, $maxLength - 1)];
		}
		$registration_key = $randomString;

		$to = $email;
		$subject = 'Confirmation d\'inscription';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Bienvenue parmi les membres du blog de Jean Forteroche !</h3>
						<p>Pour pouvoir vous connecter, merci de bien vouloir finaliser votre inscription en cliquant sur le lien ci-dessous:</p>
						<p><a href="127.0.0.1/blog/index.php?key=' . $registration_key . '" target="_blank">Confirmer mon inscription</a></p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		$confirm = 0;
		$admin = 0;
		$registration->addUser($pseudo, $pass_hash, $email, $registration_key, $confirm, $admin);
	}

	//Vérifications pour la connexion d'un utilisateur + envoi nouveau mot de passe
	function verifyConnect($id_connect)
	{
		$verifyConnect = new Users();
		$verifyId = $verifyConnect->checkConnect($id_connect);

		return $verifyId;
	}

	function verifyRegistrationKey($registration_key)
	{
		$verifyRegistrationKey = new Users();
		$isKeyExist = $verifyRegistrationKey->checkRegistrationKey($registration_key);

		return $isKeyExist;
	}

	function changeConfirm($registration_key)
	{
		$changeConfirm = new Users();
		$changeConfirm->updateConfirm($registration_key);
	}

	function verifyConfirm($id_connect)
	{
		$verifyConfirm = new Users();
		$isConfirm = $verifyConfirm->checkConfirm($id_connect);

		return $isConfirm;
	}

	function newTokenPassword($email)
	{
		$newToken = new Users();

		$length = 60;
		$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$maxLength = strlen($string);
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
		$randomString.= $string[rand(0, $maxLength - 1)];
		}
		$token_key = $randomString;

		$newToken->addTokenPassword($token_key, $email);
		return $token_key;
	}

	function sendNewPassword($email, $id, $token)
	{
		$to = $email;
		$subject = 'Réinitialisation du mot de passe';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Réinitialisation de votre mot de passe</h3>
						<p>Vous êtes actuellement sur le point de changer votre mot de passe !<br/>
						Cliquez <a href="127.0.0.1/blog/index.php?id=' . $id . '&amp;token=' . $token . '" target="_blank">ici</a> pour réinitialiser votre mot de passe.</p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		setcookie('email', $email, time()+60*15, null, null, false, true);
		require('view/frontend/signInView.php');
	}

	function verifyTokenPassword($id, $token)
	{
		$verifyToken = new Users();
		$avaibleToken = $verifyToken->checkTokenPassword($id, $token);

		return $avaibleToken;
	}

	function resetPassword($pass_hash, $email)
	{
		$resetPassword = new Users();
		$resetPassword->forgottenPassword($pass_hash, $email);
	}

	function contact($contact_subject, $contact_email, $contact_message)
	{
		$to = 'strady60@gmail.com';
		$subject = $contact_subject;
		$message = '
			<html>
				<head></head>
				<body>
					<p>' . $contact_message . '</p>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);
		$path = 'Location: http://127.0.0.1/blog/index.php';
		header($path);
	}

																					//BACKEND :

	//Affichage liste des posts + pagination pour adminView.php
	function listPostsAdmin()
	{
		$count = new Posts();
		$postManager = new Posts();

		$max_nb_post = 5;
		$req = $count->countPosts();
		$total_post = $req->fetch();
		$req->closeCursor();
		$nb_post = $total_post['nb_post'];
		$nb_page = ceil($nb_post/$max_nb_post);

		if (isset($_GET['show']))
		{
			strip_tags($_GET['show']);
			$_GET['show'] = (int)$_GET['show'];
			$current_page = $_GET['show'];
			if ($current_page == 0)
			{
				$current_page = 1;
			}
			elseif ($current_page > $nb_page)
			{
				$current_page = $nb_page;
			}
		}
		else
		{
			$current_page = 1;
		}

		$first_post = ($current_page-1)*$max_nb_post;

		$req = $postManager->getPosts($first_post, $max_nb_post);

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/adminView.php');
	}

	//Lien vers la création d'un post + insertion d'un post
	function newPost()
	{
		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/addPostView.php');
	}

	function addPost($title, $content)
	{
		$adminManager = new AdminManager();
		$adminManager->createPost($title, $content);
	}

	//Affichage d'un post + modification d'un post
	function readPost($postId)
	{
		$postsManager = new PostsManager();
		$post = $postsManager->getPost($postId);

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/readPostView.php');
	}

	function changePost($postId)
	{
		$postsManager = new Posts();
		$post = $postsManager->getPost($postId);

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require ('view/backend/updatePostView.php');
	}

	function rePost($title, $content, $id)
	{
		$adminManager = new AdminManager();
		$adminManager->updatePost($title, $content, $id);
	}

	function changeImage($description, $extension, $id)
	{
		$changeImage = new AdminManager();
		$changeImage->updateImage($description, $extension, $id);
	}

	//Affichage du formulaire de suppression + suppression d'un post
	function deleteForm()
	{
		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/deletePostView.php');
	}

	function erasePost($id)
	{
		$adminManager = new AdminManager();
		$adminManager->deletePost($id);
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

																					//PROFIL :

	//Lien vers la page du profil + paramétrages du compte (administrateur)
	function accountLink($email)
	{
		$searchGravatar = new Users();

		$size = 200;
		$gravatar = $searchGravatar->getGravatar($email, $size);

		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/accountView.php');
	}

	function newPseudo($new_pseudo, $pseudo)
	{
		$newPseudo = new Users();
		$newPseudo->changePseudo($new_pseudo, $pseudo);
	}

	function newEmail($new_email, $pseudo)
	{
		$newEmail = new Users();

		$to = 'strady60@gmail.com';
		$subject = 'Changement d\'adresse e-mail';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Un petit pas pour l\'homme mais un grand pas pour le numérique !</h3>
						<p>Bravo ! La modification de votre adresse e-mail a bien été prise en compte.</p>
						<p>Lors de votre prochaine connexion vous pourrez renseigner cette adresse e-mail comme identifiant ;)</p>
						<p>A bientôt sur le <a href="127.0.0.1/blog/index.php?link=connexion" target="_blank">blog de Jean Forteroche</a></p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		$newEmail->changeEmail($new_email, $pseudo);
	}

	function newPassword($pass_hash, $pseudo)
	{
		$newPassword = new Users();
		$newPassword->changePassword($pass_hash, $pseudo);
	}

	function selectEmail($id_user)
	{
		$selectEmail = new Users();
		$user_email = $selectEmail->getEmail($id_user);

		return $user_email;
	}

	function bannedUser($pseudo, $email, $reasons)
	{
		$bannedUser = new Banned();
		$deleteUser = new AdminManager();

		$bannedUser->addBanned($pseudo, $email, $reasons);

		$to = 'strady60@gmail.com';
		$subject = 'Suppression de votre compte utilisateur';
		$message = '
			<html>
				<head></head>
				<body>
					<div align="center">
						<h3>Suppression de votre compte !</h3>
						<p>Bonjour,<br/>
						Votre compte utilisateur sur le blog de Jean Forteroche a fait l\'objet d\'une suppression par l\'administrateur.</p>
						<p>En voici les raisons:<br/>
						"' . $reasons . '"</p>
					</div>
				</body>
			</html>
		';
		$header = "From: \"Jean Forteroche\"<test.coxus@gmail.com>\n";
		$header.= "Reply-to: \"Jean Forteroche\" <test.coxus@gmail.com>\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"UTF-8\"";
		$header.= "Content-Transfer-Encoding: 8bit";

		mail($to, $subject, $message, $header);

		$deleteUser->deleteUser($pseudo);
	}

	function confirmDeleteAccount()
	{
		$countWarning = new Warning();
		$count = $countWarning->countWarning();
		$nbWarning = $count->fetch();
		$count->closeCursor();

		require('view/backend/deleteAccountView.php');
	}

	function eraseAccount($pseudo, $id)
	{
		$eraseAccount = new Users();
		$deleteAsloComments = new Comments();

		$eraseAccount->deleteAccount($pseudo);
		$deleteAsloComments->deleteComments($pseudo);

		unlink('public/images/avatars/' . $id . '.png');
		unlink('public/images/thumbnails/' . $id . '.png');
	}