<?php
require_once(__DIR__."/Model/ContactModel.php");
$obj_contact = new ContactModel();

$action = $_POST['action'];
$ret = array();
if( $action == 'add_edit'  ) {
	$obj_contact->insert_update($_POST,	$_POST['id'] );
	$ret['success'] = '1';	
}
elseif( $action == 'delete'  ) {
	$obj_contact->delete( $_POST['id'] );
	$ret['success'] = '1';	
}
elseif( $action == 'edit_form'  ) {
	$ret['row'] = $obj_contact->get_by_pk( $_POST['id'] );
	$ret['success'] = '1';	
}
elseif( $action == 'refresh_list') {
	$ret['success'] = '1';	
}

$ret['action'] = $_POST['action'];

if($action != 'edit'  ) {
	ob_start();
	include_once(__DIR__.'/views/contact_table/list.php');
	$html = ob_get_clean();
	$ret['html'] = $html;
}

echo json_encode( $ret );
?>