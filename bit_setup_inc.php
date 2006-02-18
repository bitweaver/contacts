<?php
global $gBitSystem, $gBitSmarty;
$registerHash = array(
	'package_name' => 'contacts',
	'package_path' => dirname( __FILE__ ).'/',
);
$gBitSystem->registerPackage( $registerHash );

define('CONTACTS_CONTENT_TYPE_GUID', 'contacts' );

if( $gBitSystem->isPackageActive( 'contacts' ) ) {
	$gBitSystem->registerAppMenu( 'contacts', 'Contacts', CONTACTS_PKG_URL.'index.php', 'bitpackage:contacts/menu_contacts.tpl', 'contacts');
}

?>
