<?php
	namespace Eric\Blog\Model\Users;
	require_once("model/Manager.php");

	class UsersManager extends \Eric\Blog\Model\Manager
	{
		public function checkPseudo($pseudo)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT pseudo FROM users WHERE pseudo = :pseudo ');
			$req->execute(array('pseudo' => $pseudo));
			$checkPseudo = $req->fetch();

			return $checkPseudo;
		}

		public function checkEmail($email)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT id, email FROM users WHERE email = :email ');
			$req->execute(array('email' => $email));
			$checkEmail = $req->fetch();

			return $checkEmail;
		}

		public function addUser($pseudo, $pass_hash, $email, $registration_key, $confirm, $admin)
		{
			$db = $this->dbConnect();

			$addUser = $db->prepare('INSERT INTO users( pseudo, password, email, registration_date, registration_key, confirm, admin) VALUES (:pseudo, :password, :email, NOW(), :key, :confirm, :admin)');
			$addUser->execute(array('pseudo' => $pseudo, 'password' => $pass_hash, 'email' => $email, 'key' => $registration_key, 'confirm' => $confirm, 'admin' => $admin));

			setcookie('pseudo', $pseudo, time()+120, null, null, false, true);
			$path = 'Location: http://127.0.0.1/blog/index.php?link=connexion';
			header($path);
		}

		public function checkConnect($id_connect)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT id, pseudo, password, admin, email FROM users WHERE pseudo = :pseudo OR email = :email');
			$req->execute(array('pseudo' => $id_connect, 'email' => $id_connect));
			$checkConnect = $req->fetch();

			return $checkConnect;
		}

		public function checkRegistrationKey($registration_key)
		{
			$db = $this->dbConnect();

			$checkRegistrationKey = $db->prepare('SELECT registration_key FROM users WHERE registration_key = :registration_key');
			$checkRegistrationKey->execute(array('registration_key' => $registration_key));
			$isSame = $checkRegistrationKey->fetch();

			return $isSame;
		}

		public function updateConfirm($registration_key)
		{
			$db = $this->dbConnect();

			$updateConfirm = $db->prepare('UPDATE users SET confirm = 1 WHERE registration_key = :registration_key');
			$updateConfirm->execute(array('registration_key' => $registration_key));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=confirmed';
			header($path);
		}

		public function checkConfirm($id_connect)
		{
			$db = $this->dbConnect();

			$checkConfirm = $db->prepare('SELECT confirm FROM users WHERE pseudo = :pseudo OR email = :email');
			$checkConfirm->execute(array('pseudo' => $id_connect, 'email' => $id_connect));
			$isOne = $checkConfirm->fetch();

			return $isOne;
		}

		public function checkTokenPresence($id_connect)
		{
			$db = $this->dbConnect();

			$checkTokenPresence = $db->prepare('SELECT token_pass FROM users WHERE pseudo = :pseudo OR email = :email');
			$checkTokenPresence->execute(array('pseudo' => $id_connect, 'email' => $id_connect));

			$presence = $checkTokenPresence->fetch();

			return $presence;
		}

		public function addTokenPassword($token_key, $email)
		{
			$db = $this->dbConnect();

			$addToken = $db->prepare('UPDATE users SET token_pass = :token_key, token_pass_date = NOW() WHERE email = :email');
			$addToken->execute(array('token_key' => $token_key, 'email' => $email));
		}

		public function checkTokenPassword($id, $token)
		{
			$db = $this->dbConnect();

			$checkTokenPassword = $db->prepare('SELECT id FROM users WHERE id = :id AND token_pass = :token AND token_pass_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)');
			$checkTokenPassword->execute(array('id' => $id, 'token' => $token));
			$isInTime = $checkTokenPassword->fetch();

			return $isInTime;
		}

		public function deleteTokenPassword($email)
		{
			$db = $this->dbConnect();

			$changePassword = $db->prepare('UPDATE users SET token_pass = NULL WHERE email = :email');
			$changePassword->execute(array('email' => $email));
		}

		public function forgottenPassword($password, $email)
		{
			$db = $this->dbConnect();

			$changePassword = $db->prepare('UPDATE users SET password = :password WHERE email = :email');
			$changePassword->execute(array('password' => $password, 'email' => $email));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=connexion';
			header($path);
		}

		public function changePseudo($new_pseudo, $pseudo)
		{
			$db = $this->dbConnect();

			$changePseudo = $db->prepare('UPDATE users SET pseudo = :new_pseudo WHERE pseudo = :pseudo');
			$changePseudo->execute(array('new_pseudo' => $new_pseudo, 'pseudo' => $pseudo));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=account';
			header($path);
		}

		public function changeEmail($new_email, $pseudo)
		{
			$db = $this->dbConnect();

			$changePseudo = $db->prepare('UPDATE users SET email = :new_email WHERE pseudo = :pseudo');
			$changePseudo->execute(array('new_email' => $new_email, 'pseudo' => $pseudo));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=email';
			header($path);
		}

		public function changePassword($pass_hash, $pseudo)
		{
			$db = $this->dbConnect();

			$changePassword = $db->prepare('UPDATE users SET password = :pass_hash WHERE pseudo = :pseudo');
			$changePassword->execute(array('pass_hash' => $pass_hash, 'pseudo' => $pseudo));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=password';
			header($path);
		}

		public function getEmail($id_user)
		{
			$db = $this->dbConnect();

			$req = $db->prepare('SELECT email FROM users WHERE pseudo = :pseudo OR id = :id');
			$req->execute(array('pseudo' => $id_user, 'id' => $id_user));
			$getEmail = $req->fetch();

			return $getEmail;
		}

		public function getGravatar($email, $size)
		{
			$db = $this->dbConnect();

			$url = 'https://www.gravatar.com/avatar/';
			$url .= md5(strtolower(trim($email)));
			$url .= '?s=' . $size . '&d=retro&r=g';

			return $url;
		}

		public function deleteAccount($pseudo)
		{
			$db = $this->dbConnect();

			$deleteAccount = $db->prepare('DELETE FROM users WHERE pseudo = :pseudo');
			$deleteAccount->execute(array('pseudo' => $pseudo));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=deconnexion';
			header($path);
		}
	}