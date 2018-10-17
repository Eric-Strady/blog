<?php
	namespace Eric\Blog\Model\Users;
	require_once("model/Manager.php");

	class UsersManager extends \Eric\Blog\Model\Manager
	{
		public function isExist($infos)
		{
			$req = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE id = :infos OR pseudo = :infos OR email = :infos OR registration_key = :infos OR token_pass = :infos');
			$req->execute(array('infos' => $infos));
			
			return (bool) $req->fetchcolumn();
		}

		public function addUser(User $user)
        {
            $req = $this->_db->prepare('INSERT INTO  users( pseudo, password, email, registration_key, registration_date, confirm, admin) VALUES (:pseudo, :password, :email, :key, NOW(), :confirm, :admin)');
			$req->execute(array(
				'pseudo' => $user->getPseudo(),
				'password' => $user->getPassword(),
				'email' => $user->getEmail(),
				'key' => $user->getRegistrationKey(),
				'confirm' => $user->getConfirm(),
				'admin' => $user->getAdmin()
			));
            
            $user->hydrate([
                'id' => $this->_db->lastInsertId()
            ]);
        }

        public function updateConfirm($key)
        {
        	$req = $this->_db->prepare('UPDATE users SET confirm = 1 WHERE registration_key = :key');
        	$req->execute(array('key' => $key));
        }
        
        public function findUser($id_connect)
        {            
            $req = $this->_db->prepare('SELECT id, pseudo, password, email, confirm, admin, token_pass, token_pass_date FROM users WHERE pseudo = :id_connect OR email = :id_connect OR id = :id_connect');
            $req->execute(array('id_connect' => $id_connect));
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            return new User($data);
        }

        public function updateTokenPass($token, $id)
        {
        	$req = $this->_db->prepare('UPDATE users SET token_pass = :token, token_pass_date = NOW() WHERE id = :id');
        	$req->execute(array('token' => $token, 'id' => $id));
        }

        public function checkTokenDate($id, $token)
        {
        	$req = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE id = :id AND token_pass = :token AND token_pass_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)');
        	$req->execute(array('id' => $id, 'token' => $token));

        	return (bool) $req->fetchcolumn();
        }

        public function updatePassword($newPass, $id)
        {
        	$req = $this->_db->prepare('UPDATE users SET password = :newPass WHERE id = :id');
        	$req->execute(array('newPass' => $newPass, 'id' => $id));
        }

        public function resetTokenPass($id)
        {
        	$req = $this->_db->prepare('UPDATE users SET token_pass = NULL WHERE id = :id');
        	$req->execute(array('id' => $id));
        }
        
        /*
		public function addUser($pseudo, $pass_hash, $email, $registration_key, $confirm, $admin)
		{
			$addUser = $this->getDB()->prepare('INSERT INTO users( pseudo, password, email, registration_date, registration_key, confirm, admin) VALUES (:pseudo, :password, :email, NOW(), :key, :confirm, :admin)');
			$addUser->execute(array('pseudo' => $pseudo, 'password' => $pass_hash, 'email' => $email, 'key' => $registration_key, 'confirm' => $confirm, 'admin' => $admin));

			setcookie('pseudo', $pseudo, time()+120, null, null, false, true);
			$path = 'Location: http://127.0.0.1/blog/index.php?link=connexion';
			header($path);
		}

		public function checkConnect($id_connect)
		{
			$req = $this->getDB()->prepare('SELECT id, pseudo, password, admin, email FROM users WHERE pseudo = :pseudo OR email = :email OR id = :id');
			$req->execute(array('pseudo' => $id_connect, 'email' => $id_connect, 'id' => $id_connect));
			$checkConnect = $req->fetch();

			return $checkConnect;
		}

		public function checkRegistrationKey($registration_key)
		{
			$checkRegistrationKey = $this->getDB()->prepare('SELECT registration_key FROM users WHERE registration_key = :registration_key');
			$checkRegistrationKey->execute(array('registration_key' => $registration_key));
			$isSame = $checkRegistrationKey->fetch();

			return $isSame;
		}

		public function updateConfirm($registration_key)
		{
			$updateConfirm = $this->getDB()->prepare('UPDATE users SET confirm = 1 WHERE registration_key = :registration_key');
			$updateConfirm->execute(array('registration_key' => $registration_key));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=confirmed';
			header($path);
		}

		public function checkConfirm($id_connect)
		{
			$checkConfirm = $this->getDB()->prepare('SELECT confirm FROM users WHERE pseudo = :pseudo OR email = :email');
			$checkConfirm->execute(array('pseudo' => $id_connect, 'email' => $id_connect));
			$isOne = $checkConfirm->fetch();

			return $isOne;
		}

		public function checkTokenPresence($id_connect)
		{
			$checkTokenPresence = $this->getDB()->prepare('SELECT token_pass FROM users WHERE pseudo = :pseudo OR email = :email');
			$checkTokenPresence->execute(array('pseudo' => $id_connect, 'email' => $id_connect));

			$presence = $checkTokenPresence->fetch();

			return $presence;
		}

		public function addTokenPassword($token_key, $email)
		{
			$addToken = $this->getDB()->prepare('UPDATE users SET token_pass = :token_key, token_pass_date = NOW() WHERE email = :email');
			$addToken->execute(array('token_key' => $token_key, 'email' => $email));
		}

		public function checkTokenPassword($id, $token)
		{
			$checkTokenPassword = $this->getDB()->prepare('SELECT id FROM users WHERE id = :id AND token_pass = :token AND token_pass_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)');
			$checkTokenPassword->execute(array('id' => $id, 'token' => $token));
			$isInTime = $checkTokenPassword->fetch();

			return $isInTime;
		}

		public function deleteTokenPassword($email)
		{
			$changePassword = $this->getDB()->prepare('UPDATE users SET token_pass = NULL WHERE email = :email');
			$changePassword->execute(array('email' => $email));
		}

		public function forgottenPassword($password, $email)
		{
			$changePassword = $this->getDB()->prepare('UPDATE users SET password = :password WHERE email = :email');
			$changePassword->execute(array('password' => $password, 'email' => $email));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=connexion';
			header($path);
		}

		public function changePseudo($new_pseudo, $pseudo)
		{
			$changePseudo = $this->getDB()->prepare('UPDATE users, comments SET pseudo = :new_pseudo, author = :new_pseudo WHERE pseudo = :pseudo AND author = :pseudo');
			$changePseudo->execute(array('new_pseudo' => $new_pseudo, 'pseudo' => $pseudo));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=account';
			header($path);
		}

		public function changeEmail($new_email, $id)
		{
			$changePseudo = $this->getDB()->prepare('UPDATE users SET email = :new_email WHERE id = :id');
			$changePseudo->execute(array('new_email' => $new_email, 'id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=email';
			header($path);
		}

		public function changePassword($pass_hash, $id)
		{
			$changePassword = $this->getDB()->prepare('UPDATE users SET password = :pass_hash WHERE id = :id');
			$changePassword->execute(array('pass_hash' => $pass_hash, 'id' => $id));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=account&success=password';
			header($path);
		}

		public function getEmail($id_user)
		{
			$req = $this->getDB()->prepare('SELECT email FROM users WHERE pseudo = :pseudo OR id = :id');
			$req->execute(array('pseudo' => $id_user, 'id' => $id_user));
			$getEmail = $req->fetch();

			return $getEmail;
		}

		public function deleteAccount($pseudo)
		{
			$deleteAccount = $this->getDB()->prepare('DELETE FROM users WHERE pseudo = :pseudo');
			$deleteAccount->execute(array('pseudo' => $pseudo));

			$path = 'Location: http://127.0.0.1/blog/index.php?link=deconnexion';
			header($path);
		}
		*/
	}