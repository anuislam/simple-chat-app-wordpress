<?php
require_once(__DIR__.'/config.php');
/**
* simple pdo crud
*/
class as_database
{
	protected $dbname;
	protected $dbusername;
	protected $dbpassword;
	protected $dbhost;
	protected $db;
	function __construct()
	{
		$this->dbname 		= dbname;
		$this->dbusername 	= dbusername;
		$this->dbpassword 	= dbpassword;
		$this->dbhost 		= dbhost;
		try {
			$this->db = new pdo('mysql:host='.$this->dbhost.';dbname='.$this->dbname, $this->dbusername, $this->dbpassword);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die('Database error');
		}
	}

	public function as_insert($tablename, $val){
		$val = (array)$val;
		$fieldname = '';
		$valueitems = '';
		if (is_array($val) === true) {
			foreach ($val as $valkey => $valvalue) {
				$fieldname[] 	= $valkey;
			}
		}
		$field  = '`';
		$field .= implode('`, `', $fieldname);			
		$field .= '`';
		$items  = ":";
		$items .= implode(", :", $fieldname);
		$mydb = $this->db->prepare( "INSERT INTO `$tablename` ( $field ) VALUES ( $items ) ");
		if (is_array($val) === true) {
			foreach ($val as $valkey => $valvalue) {				
				if (is_numeric($valvalue) === true) {
					$mydb->bindValue( ":$valkey", $valvalue, PDO::PARAM_INT);
				}else{
					$mydb->bindValue( ":$valkey", $valvalue, PDO::PARAM_STR);
				}
			}
		}
		$mydb->execute();
	}
	public function as_delete($tablename, $whereval){
		$whereval = (array)$whereval;
		$a1 = 0;
		$query = "DELETE FROM `$tablename` WHERE ";
		if (is_array($whereval) === true) {
			foreach ($whereval as $whkey => $whvalue) {
				$andop = ($a1 > 0)? " AND " : null;
				$query .= "$andop `$whkey` = :$whkey";
				$a1++;
			}
		}
		$dldb = $this->db->prepare( $query );
		if (is_array($whereval) === true) {
			foreach ($whereval as $whkey => $whvalue) {
				if (is_numeric($whvalue) === true) {
					$dldb->bindValue( ":$whkey", $whvalue, PDO::PARAM_INT);
				}else{
					$dldb->bindValue(  ":$whkey", $whvalue, PDO::PARAM_STR);
				}
			}
		}

		$dldb->execute();
	}
	public function as_update($tblname, $data, $tblwhere){
		$query = "UPDATE `$tblname` SET ";
		$a1 = 0;		
		if (is_array( $data)) {
			foreach ( $data as $key => $value) {
				$datarcomma = ($a1 > 0) ? ", " : null ;
				$query .= "$datarcomma `$key` = :$key";
				$a1++;
			}			
		}	
		$query .= " WHERE ";
		$a2 = 0;
		if (is_array( $tblwhere)) {
			foreach ( $tblwhere as $tblwhkey => $tblwhvalue) {
				$whrcomma = ($a2 > 0) ? " AND " : null ;
				$query .= "$whrcomma `$tblwhkey` = :$tblwhkey";
				$a2++;
			}			
		}
		$updb = $this->db->prepare( $query );	
		if (is_array( $data)) {
			foreach ( $data as $key => $value) {
				if (is_numeric($value) === true) {
					$updb->bindValue( ":$key", $value, PDO::PARAM_INT);
				}else{
					$updb->bindValue(  ":$key", $value, PDO::PARAM_STR);
				}
			}			
		}
		if (is_array( $tblwhere)) {
			foreach ( $tblwhere as $tblwhkey => $tblwhvalue) {
				if (is_numeric($tblwhvalue) === true) {
					$updb->bindValue( ":$tblwhkey", $tblwhvalue, PDO::PARAM_INT);
				}else{
					$updb->bindValue(  ":$tblwhkey", $tblwhvalue, PDO::PARAM_STR);
				};
			}			
		}

		$updb->execute();
	}

	public function as_getdata($tblname, $whereval = null, $opj = false, $offser = '', $limit = ''){
		$query 	= "SELECT * FROM `$tblname`";
		if (is_array($whereval) === true) {
			$a1 = 0;
			$query 	.= "WHERE";
			foreach ($whereval as $key => $value) {
				$andval = ($a1 > 0) ? "AND" : null ;
				$query 	.= " $andval $key = :$key";
				$a1++;
			}
		}
		$getdb 	= $this->db->prepare( $query );	
		if (is_array($whereval) === true) {
			foreach ($whereval as $key => $value) {
				if (is_numeric($value) === true) {
					$getdb->bindValue( ":$key", $value, PDO::PARAM_INT);
				}else{
					$getdb->bindValue(  ":$key", $value, PDO::PARAM_STR);
				};
				
			}
		}
		
		$getdb->execute();
		if ($opj == true) {
			return $getdb->fetchAll(PDO::FETCH_CLASS);
		}else{
			return $getdb->fetchAll(PDO::FETCH_ASSOC);
		}
		
	}

	public function as_is_unique($tblname, $fieldname, $data){
		$query 	= "SELECT * FROM `$tblname` WHERE `$fieldname` = :$fieldname";
		$undb 	= $this->db->prepare( $query );
		if (is_numeric($data) === true) {
			$undb->bindValue( ":$fieldname", $data, PDO::PARAM_INT);
		}else{
			$undb->bindValue(  ":$fieldname", $data, PDO::PARAM_STR);
		};
		$undb->execute();
		return ($undb->rowCount() > 0) ? true : false ;
	}

	public function as_get_return_val($tblname, $field, $where){
		$query = "SELECT ";
		if (is_array($field)) {
			$fieldname = '`';
			$fieldname .= implode('`, `',  $field);
			$fieldname .= '` ';
		}else{
			$fieldname = '`';
			$fieldname .= $field;
			$fieldname .= '` ';
		}
		if (is_array($where)) {
			$a1 = 0;
			$whval = '';
			foreach ($where as $key => $value) {
				$andval = ($a1 > 0)? "AND ": null;
				$whval .= "$andval `$key` = '$value'";
				$a1++;
			}
		}

		$query .= $fieldname;
		$query .= "FROM ";
		$query .= "`$tblname`";
		$query .= " WHERE";
		$query .= $whval;
		$rtdb 	= $this->db->query( $query );
		$data 	= $rtdb->fetch(PDO::FETCH_ASSOC); 
		return (count($data) > 0) ? $data : false ;
	}

	public function query($query){
		$rtdb 	= $this->db->query( $query );
		$data 	= $rtdb->fetchAll(PDO::FETCH_ASSOC);
		return (count($data) > 0) ? $data : false ;
	}
}

?>