<?php
	namespace Eric\Blog\Model\Manager\Users;
	require_once("model/Manager/Manager.php");
    use \Eric\Blog\Model\Users\User;

	class UsersManager extends \Eric\Blog\Model\Manager\Manager
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

        public function updateConfirm(User $user)
        {
        	$req = $this->_db->prepare('UPDATE users SET confirm = 1 WHERE registration_key = :key');
        	$req->execute(array('key' => $user->getRegistrationKey()));
        }
        
        public function findUser($id_connect)
        {            
            $req = $this->_db->prepare('SELECT id, pseudo, password, email, confirm, admin, token_pass, token_pass_date FROM users WHERE pseudo = :id_connect OR email = :id_connect OR id = :id_connect');
            $req->execute(array('id_connect' => $id_connect));
            $data = $req->fetch(\PDO::FETCH_ASSOC);
            return new User($data);
        }

        public function updateTokenPass(User $user)
        {
        	$req = $this->_db->prepare('UPDATE users SET token_pass = :token, token_pass_date = NOW() WHERE id = :id');
        	$req->execute(array('token' => $user->getTokenPass(), 'id' => $user->getId()));
        }

        public function checkTokenDate(User $user)
        {
        	$req = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE id = :id AND token_pass = :token AND token_pass_date > DATE_SUB(NOW(), INTERVAL 15 MINUTE)');
        	$req->execute(array('id' => $user->getId(), 'token' => $user->getTokenPass()));

        	return (bool) $req->fetchcolumn();
        }

        public function updatePassword(User $user)
        {
        	$req = $this->_db->prepare('UPDATE users SET password = :newPass WHERE id = :id');
        	$req->execute(array('newPass' => $user->getPassword(), 'id' => $user->getId()));
        }

        public function resetTokenPass(User $user)
        {
        	$req = $this->_db->prepare('UPDATE users SET token_pass = NULL WHERE id = :id');
        	$req->execute(array('id' => $user->getId()));
        }

        public function updatePseudo(User $user)
        {
        	$req = $this->_db->prepare('UPDATE users SET pseudo = :new_pseudo WHERE id = :id');
        	$req->execute(array('new_pseudo' => $user->getPseudo(), 'id' => $user->getId()));
        }
        
        public function updateEmail(User $user)
        {
        	$req = $this->_db->prepare('UPDATE users SET email = :new_email WHERE id = :id');
        	$req->execute(array('new_email' => $user->getEmail(), 'id' => $user->getId()));
        }

        public function deleteAccount(User $user)
        {
        	$req = $this->_db->prepare('DELETE FROM users WHERE id = :id');
        	$req->execute(array('id' => $user->getId()));
        }
    }