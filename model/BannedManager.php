<?php
	namespace Eric\Blog\Model\Banned;
	require_once("model/Manager.php");

	class BannedManager extends \Eric\Blog\Model\Manager
	{
		public function addBanned($pseudo, $email, $reasons)
		{
			$db = $this->dbConnect();

			$addBanned = $db->prepare('INSERT INTO banned(pseudo, email, reasons, suppression_date) VALUES( :pseudo, :email, :reasons , NOW())');
			$addBanned->execute(array('pseudo' => $pseudo, 'email' => $email, 'reasons' => $reasons));
		}
	}