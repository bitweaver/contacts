<?php
global $gBitSystem, $gBitSmarty;
$gBitSystem->registerPackage( 'contacts', dirname( __FILE__).'/' );

define('CONTACTS_CONTENT_TYPE_GUID', 'contacts' );

if( $gBitSystem->isPackageActive( 'contacts' ) ) {
	$gBitSystem->registerAppMenu( 'contacts', 'Contacts', CONTACTS_PKG_URL.'index.php', 'bitpackage:contacts/menu_contact.tpl', 'contacts');
}

?>
