<?php 
class DB_Class {

	private $db;

	private $dsn;
	private $user;
	private $pass;
	
	public function __construct($dsn, $user, $pass){
		$this->dsn = $dsn;
		$this->user = $user;
		$this->pass = $pass;		
	}
	
	public function connect()
	{		
		if(!isset($this->db))
		{
			try {
				$this->db = new PDO($this->dsn, $this->user, $this->pass);	
			} catch (PDOException $e) {
				echo 'Connection error: ' . $e->getMessage();
			} 
		}
		return $this->db;
	}
	
	public function selectAll($table, $fields='*', $where=null, $orderby = null, $limit = null, $join = null)
	{
		$sth = $this->select($table,$fields,$where,$orderby,$limit,$join);
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function selectOne($table, $fields='*', $where=null, $orderby = null, $limit = null, $join = null)
	{
		$sth = $this->select($table,$fields,$where,$orderby,$limit,$join);
		return $sth->fetch(PDO::FETCH_ASSOC);
	}
	
	private function select($table, $fields, $where, $orderby = null, $limit = null, $join = null)
	{
		$queryString = "SELECT $fields FROM $table";
		if(!empty($join))
		{
			$queryString.= " $join";
		}
		if(!empty($where))
		{
			$queryString.= " WHERE $where";
		}
		if(!empty($orderby))
		{
			$queryString.= " ORDER BY $orderby";
		}
		if(!empty($limit))
		{
			$queryString.= " LIMIT $limit";
		}
		return $this->db->query($queryString);
	}
	
	public function insert($table, $fields, $values)
	{		
		$queryString = "INSERT INTO $table SET ";
		for($i=0; $i<count($fields); $i++)
		{
			$values[$i] = str_replace("'","\'",$values[$i]);
			$queryString .= "$fields[$i] = '$values[$i]', ";
		}		
		$queryString = rtrim($queryString,", ");
		
		$sth = $this->db->prepare($queryString);
		if($sth->execute())
		{
			return $this->db->lastInsertId();
		}
		return false;
	}
	
	public function update($table, $fields, $values, $where)
	{
		$queryString = "UPDATE $table SET ";
		
		for($i=0; $i<count($fields); $i++)
		{
			$values[$i] = str_replace("'","\'",$values[$i]);
			$queryString .= "$fields[$i] = '$values[$i]', ";
		}
		$queryString = substr($queryString,0,strlen($queryString)-2);
		$queryString .= " WHERE $where";
		$sth = $this->db->prepare($queryString);
		return $sth->execute();
	}
	
	public function delete($table, $where = "1")
	{
		$queryString = "DELETE FROM $table WHERE $where";
		$sth = $this->db->prepare($queryString);
		return $sth->execute();
	}
}
?>