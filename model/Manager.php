<?php
	namespace Eric\Blog\Model;

	class Manager
	{
		protected $_db;

		public function __CONSTRUCT()
		{
			$this->_db = new \PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
		}

		protected function getDb()
		{
			return $this->_db;
		}
	}