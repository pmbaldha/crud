<?php
require_once(__DIR__."/Model/ContactModel.php");
$obj_contact = new ContactModel();
include_once( __DIR__.'/views/contact_table/contact.php');