<?php

class Database extends PDO
{
	
	public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
	{
		parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS);
		
		//parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTIONS);
	}
	
	/**
	 * insert
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 *	$this->db->insert('users', array(
	 *		'login' => $data['login'],
	 *		'password' => Hash::create('md5', $data['password'], HASH_PASSWORD_KEY),
	 *		'role' => $data['role']
	 *	));
	 */
    
    public function query($query){
    	$sth = $query;
    	$sth->execute();
    }
    
	public function insert($table, $data)
	{
		ksort($data);
		$fieldNames = implode('`, `', array_keys($data));
		$fieldValues = ':' . implode(', :', array_keys($data));
		$sth = $this->prepare("INSERT INTO `$table` (`$fieldNames`) VALUES ($fieldValues)");
		// print_r($sth);
		// die();
		foreach ($data as $key => $value) {
			$sth->bindValue("$key", $value);
		}
		
		$sth->execute();
	}
	
	/**
	 * update
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 * @param string $where the WHERE query part
	 */
    
	public function update($table, $data, $where)
	{
		ksort($data);
		
		$fieldDetails = NULL;
		foreach($data as $key => $value) {
			$fieldDetails .= "`$key`=:$key,";
		}
		$fieldDetails = rtrim($fieldDetails, ',');
		
		$sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
		
		// echo '<pre>';
		// var_dump($sth);
		// echo '</pre>';
  //   	die();

		foreach ($data as $key => $value) {
			$sth->bindValue(":$key", $value);
		}
		
		$sth->execute();
	}
    
    //select
    //@param string $sql an sql string
    //@param array $array parameters to hold
    //@param constant $fetchMode a PDO fetch mode
    //@return mixed
    
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC){
        $sth = $this->prepare($sql);
        
        foreach ($array as $key => $value){
            $sth->bindValue("$key",$value);    // $data['key'] = value
        }
        
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }

    public function searching($sql,$array = array(),$fetchMode = PDO::FETCH_ASSOC){
    	$sth = $this->prepare($sql);
    	foreach($array as $key => $value){
    		$sth->bindValue("$key","%".$value."%");
    	}
    	// var_dump($sth);
    	// die();

    	$sth->execute();
    	return $sth->fetchAll();
    }
    
    //delete
    // @param string $table
    // @param string $where
    // @param string limit = 1 as default
    
    public function delete($table, $where, $limit = 1){
        return $this->exec("DELETE FROM `$table` WHERE $where LIMIT $limit");
    }
    
}