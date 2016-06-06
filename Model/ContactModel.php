<?php
require_once(__DIR__."/BaseModel.php");

class ContactModel Extends BaseModel{	
	public function __construct() {
		$this->tbl = 'tbl_contact';
		$this->pk = 'id';
		$this->fields = array(
		'name',
		'mobile',
		'city', );
		parent::__construct();
	}
	
}
