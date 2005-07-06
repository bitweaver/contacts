<?php
// $Header: /cvsroot/bitweaver/_bit_contacts/list_contacts.php,v 1.1 2005/07/06 10:41:50 bitweaver Exp $
// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// Initialization
require_once( '../bit_setup_inc.php' );
require_once( CONTACTS_PKG_PATH.'BitContacts.php' );

$gBitSystem->isPackageActive('contacts', TRUE);

// Now check permissions to access this page
$gBitSystem->verifyPermission('bit_p_read_contact');

$contact = new BitContacts( 0 );

if ( empty( $_REQUEST["sort_mode"] ) ) {
	$sort_mode = 'title_asc';
}

// Get a list of Contacts 
$contact->getList( $_REQUEST );

$smarty->assign_by_ref('control', $_REQUEST["control"]);
$smarty->assign_by_ref('list', $_REQUEST["data"]);


// Display the template
$gBitSystem->display( 'bitpackage:contacts/list_contacts.tpl');
?>
