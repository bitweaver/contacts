<?php
// Initialization
require_once( '../bit_setup_inc.php' );
include_once( CONTACTS_PKG_PATH.'BitContacts.php');

$contactId = ( isset( $_REQUEST['content_id'] ) ? $_REQUEST['content_id'] : 0 );

$contact = new BitContacts( $contactId );
$contact->load();

$smarty->assign_by_ref( 'contactInfo', $contact->mInfo );

$gBitSystem->display('bitpackage:contacts/show_contact.tpl');

?>
