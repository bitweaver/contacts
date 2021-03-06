<?php
// $Header$
// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See below for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
// Initialization
require_once( '../kernel/setup_inc.php' );
require_once( CONTACTS_PKG_PATH.'Contacts.php' );

$gBitSystem->isPackageActive('contacts', TRUE);

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_contacts_view');

$contact = new Contacts( 0 );

if ( empty( $_REQUEST["sort_mode"] ) ) {
	$sort_mode = 'title_asc';
}

// Get a list of Contacts 
$contact->getList( $_REQUEST );

$smarty->assign_by_ref('listInfo', $_REQUEST['listInfo']);
$smarty->assign_by_ref('list', $_REQUEST["data"]);


// Display the template
$gBitSystem->display( 'bitpackage:contacts/list_contacts.tpl', NULL, array( 'display_mode' => 'list' ));
?>
