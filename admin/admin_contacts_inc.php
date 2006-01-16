<?php

// $Header$

// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

include_once( CONTACTS_PKG_PATH.'Contacts.php' );

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
		simple_set_toggle( $item, CONTACTS_PKG_NAME );
	}
}

?>
