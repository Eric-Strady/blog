<?php
	namespace Eric\Blog\Model\Manager\Banned;
	require_once("model/Manager/Manager.php");
	use \Eric\Blog\Model\Banned\Banned;

	class BannedManager extends \Eric\Blog\Model\Manager\Manager
	{
		public function checkBanned(Banned $banned)
		{
			$req = $this->_db->prepare('SELECT COUNT(*) FROM banned WHERE email = :email ');
			$req->execute(array('email' => $banned->getEmail()));
			
			return (bool) $req->fetchcolumn();
		}

		public function addBanned(Banned $banned)
		{
			$req = $this->_db->prepare('INSERT INTO banned(email, reasons, banned_date) VALUES(:email, :reasons , NOW())');
			$req->execute(array('email' => $banned->getEmail(), 'reasons' => $banned->getReasons()));
		}
	}