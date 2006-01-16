<?php

// $Header: /cvsroot/bitweaver/_bit_contacts/admin/Attic/admin_contact_inc.php,v 1.2 2006/01/16 15:09:19 lsces Exp $

// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

include_once( CONTACT_PKG_PATH.'Contact.php' );

$formContactListFeatures = array(
	"contact_list_title" => array(
		'label' => 'IR Title and Number',
	),
	"contact_list_created" => array(
		'label' => 'Created By',
	),
	"contact_list_lastmodif" => array(
		'label' => 'Last Modified By',
	),
	"contact_list_name" => array(
		'label' => 'Closed By',
	),
	"contact_list_notes" => array(
		'label' => 'Notes',
	),
);
$gBitSmarty->assign( 'formContactListFeatures',$formContactListFeatures );

if (isset($_REQUEST["contactlistfeatures"])) {
	
	foreach( $formContactListFeatures as $item => $data ) {
		simple_set_toggle( $item );
	}
}

?>
