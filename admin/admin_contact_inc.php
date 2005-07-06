<?php
// $Header: /cvsroot/bitweaver/_bit_contacts/admin/Attic/admin_contact_inc.php,v 1.1 2005/07/06 10:41:50 bitweaver Exp $
// Adapted from tiki_sample to form tiki_contacts but Lester Caine
// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
if (isset($_REQUEST["contactset"]) && isset($_REQUEST["homeContact"])) {
	$gBitSystem->storePreference("home_contact", $_REQUEST["homeContact"]);
	$smarty->assign('home_contact', $_REQUEST["homeContact"]);
}

require_once( CONTACTS_PKG_PATH.'BitContacts.php' );

$contact = new BitContacts( 0 );
$contacts = $contact->getContacts();
$smarty->assign_by_ref('contacts', $contacts);

?>
