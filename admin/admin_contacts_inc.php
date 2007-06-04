<?php

// $Header$

// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

include_once( CONTACTS_PKG_PATH.'Contacts.php' );

$formContactListFeatures = array(
	"contacts_list_id" => array(
		'label' => 'Contact Number',
	),
	"contacts_list_forename" => array(
		'label' => 'Forname',
	),
	"contacts_list_surname" => array(
		'label' => 'Surname',
	),
	"contacts_list_home_phone" => array(
		'label' => 'Home Phone',
	),
	"contacts_list_mobile_phone" => array(
		'label' => 'Mobile Phone',
	),
	"contacts_list_email" => array(
		'label' => 'eMail Address',
		'help' => 'Primary contact email address - additional contact details can be found in the full record',
	),
	"contacts_list_edit_details" => array(
		'label' => 'Creation and editing details',
		'help' => 'Enable the record modification data in the contact list. Useful to allow checking when deatils were last changed.',
	),
	"contacts_list_last_modified" => array(
		'label' => 'Last Modified',
		'help' => 'Can be selected to enable filter button, without enabling the details section to allow fast checking of the last contact records that have been modified.',
	),
);
$gBitSmarty->assign( 'formContactListFeatures',$formContactListFeatures );

if (isset($_REQUEST["contactlistfeatures"])) {
	
	foreach( $formContactListFeatures as $item => $data ) {
		simple_set_toggle( $item, CONTACTS_PKG_NAME );
	}
}

?>
