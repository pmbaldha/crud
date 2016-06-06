<?php
class BaseModel {
	
	protected $conn;
	public function __construct() {
		$servername = "localhost";
		$username = "root";
		$password = "";		
		$this->conn = mysqli_connect($servername,$username,$password);
		
		if($this->conn->connect_error)
		{
			die("Connection failed: ".$this->conn->connect_error);
		}		
		mysqli_select_db($this->conn,"crud") or die("error to select db");
	}
	
	private function query($sql) {
		$q = mysqli_query($this->conn, $sql);
		if( !$q ) {
			echo 'query have error<br/>';
			echo $sql.'<br/>';
			echo("Error description: " . mysqli_error($this->conn));
			die;	
		}
		return $q;
		
	}
	
	public function insert_by_tbl($table_name, $arr_data = array()) {
		$arr_sql_field = array_keys($arr_data);
		$arr_sql_val = array_values($arr_data);
		
		$sql  = "INSERT INTO ".$table_name." (".implode(",",$arr_sql_field).") VALUES('".implode("','",$arr_sql_val)."')";
		return $this->query($sql);		
	}
	
	public function update_by_tbl($table_name, $arr_data = array(), $wh_query) {
		$arr_sql_set = array();
		foreach($arr_data as $field_name=>$field_val)
		{
			$arr_sql_set[] = $field_name."='".$field_val."'";
		}
		$sql  = "UPDATE ".$table_name." SET ".implode(",",$arr_sql_set)." WHERE 1 ".$wh_query;
		return $this->query($sql);		
	}
	public function get_by_tbl($table_name, $wh_query="" , $select_field = "*")	{
		$sql  = "SELECT ".$select_field." FROM  ".$table_name." WHERE 1 ";		
		if(!empty($wh_query))
		{
			$sql .= $wh_query;
		}
		$res =  $this->query($sql);
		
		return $arr_data = mysqli_fetch_all($res,MYSQLI_ASSOC);
	}
	
	public function view_by_tbl($table_name, $wh_query="" , $select_field = "*", $paged= 1, $page_size = 2)	{

		$sql  = "SELECT count(*) AS cnt FROM  ".$table_name." WHERE 1 ";		
		if(!empty($wh_query)) {
			$sql .= $wh_query;
		}
		$q = $this->query( $sql );
		$row_cnt = mysqli_fetch_assoc( $q ); 		
				
		$ret['cnt'] = $row_cnt['cnt'];

		$sql  = "SELECT ".$select_field." FROM  ".$table_name." WHERE 1 ";		
		if(!empty($wh_query)) {
			$sql .= $wh_query;
		}
		
		$offset = ($paged - 1) * $page_size ;
		$limit = $page_size;
		
		$sql .= ' LIMIT '.$limit.' OFFSET '.$offset;
		
		$res =  $this->query($sql);
		
		$ret['res'] = mysqli_fetch_all($res,MYSQLI_ASSOC);
		return $ret; 
	}
	
	public function delete_by_tbl($table_name, $wh_query="") {
		$sql  = "DELETE  FROM  ".$table_name." WHERE 1 ";		
		if(!empty($wh_query))
		{
			$sql .= $wh_query;
		}
		return $this->query($sql);
	}
	
	
	public function get() {
		return self::get_by_tbl($this->tbl);
	}
	public function view($wh_query="", $select_field = "*", $paged= 1, $page_size = 2) {
		return self::view_by_tbl($this->tbl, $wh_query , $select_field, $paged, $page_size)	;
	}
	public function insert_update($data, $pk = '') {
		foreach( $data as $key=>$val ) {
			if( !in_array($key, $this->fields) ) {
				unset( $data[$key] );	
			}
		}
		if( isset($pk) && intval( $pk ) > 0)
			return self::update_by_tbl( $this->tbl , $data , ' AND '.$this->pk.'='.$pk );
		else
			return self::insert_by_tbl( $this->tbl , $data );
	}
	public function delete($id)	{
		return self::delete_by_tbl( $this->tbl , ' AND '.$this->pk.'='.$id );
	}
	public function get_by_pk($id) {
		$rs =  self::get_by_tbl( $this->tbl , ' AND '.$this->pk.'='.$id );
		return $rs[0];
	}		
}


if( !function_exists('mysqli_fetch_all') ) {
	function mysqli_fetch_all($result, $type) {
		$data = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
}