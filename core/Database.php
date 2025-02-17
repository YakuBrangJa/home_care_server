<?php

Trait Database
{
  protected $host = DBHOST;
  protected $port = DBPORT;
  protected $dbname = DBNAME;
  protected $user = DBUSER;
  protected $pass = DBPASS;
  protected $charset = 'utf8mb4';

  protected $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
  ];

	private static function connect()
	{
    try {
      $con = new PDO("pgsql:host=". DBHOST .";port=". DBPORT .";dbname=".DBNAME, DBUSER, DBPASS, [
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES   => false,
      ]);
      
      // $con = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->dbname",$this->user, $this->pass, $this->options);
      return $con;
    } 
    catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
	}

	public static function query($query, $data = [])
	{

		$con = self::connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check)
		{
			// $result = $stm->fetchAll(PDO::FETCH_OBJ);
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);
			if(is_array($result) && count($result))
			{
				return $result;
			}
		}

		return false;
	}

	public function get_row($query, $data = [])
	{

		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check)
		{
			$result = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($result) && count($result))
			{
				return $result[0];
			}
		}

		return false;
	}
	
}