<?php
namespace libs\classes;

use libs\classes\HttpException;

class DBAccess extends \mysqli
{
		public function __construct()
		{
				@parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
				if ($this->connect_errno) {
						$message = "Failed to connect to MySQL: (" . $this->connect_errno . ") " . $this->connect_error;
						throw new HttpException($message, 500);
				}
		}

		public function findOneById($tableName, $id)
		{

		}

		public function findAll($tableName, $id)
		{

		}
}

