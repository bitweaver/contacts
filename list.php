<?php
/**
 * @version $Header$
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 *
 * @package contacts
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

include_once( CONTACTS_PKG_PATH.'Contacts.php' );

$gBitSystem->verifyPackage( 'contacts' );

$gBitSystem->verifyPermission( 'p_contacts_view' );

$gContent = new Contacts();
/*
if($feature_listContacts != 'y') {
  $gBitSmarty->assign('msg',tra("This feature is disabled"));
  $gBitSystem->display( 'error.tpl' , NULL, array( 'display_mode' => 'list' ));
  die;
}
*/

/*
// Now check permissions to access this page
if(!$gBitUser->( 'contact_p_view' )) {
  $gBitSmarty->assign('msg',tra("Permission denied you cannot view contacts"));
  $gBitSystem->display( 'error.tpl' , NULL, array( 'display_mode' => 'list' ));
  die;
}
*/

if( empty( $_REQUEST["sort_mode"] ) ) {
	$_REQUEST["sort_mode"] = 'surname_asc';
}

$contact_type = $gContent->getContactsTypeList();
$gBitSmarty->assign_by_ref('contact_type', $contact_type);

$listHash = $_REQUEST;
// Get a list of matching contact entries
$listcontacts = $gContent->getList( $listHash );
$gBitSmarty->assign_by_ref( 'listcontacts', $listcontacts );
$gBitSmarty->assign_by_ref( 'listInfo', $listHash['listInfo'] );

$gBitSystem->setBrowserTitle("View Contacts List");
// Display the template
$gBitSystem->display( 'bitpackage:contacts/list.tpl', NULL, array( 'display_mode' => 'list' ));

?>
