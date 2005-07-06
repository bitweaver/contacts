<?php
global $gBitSystem, $smarty;
$gBitSystem->registerPackage( 'contacts', dirname( __FILE__).'/' );

if( $gBitSystem->isPackageActive( 'contacts' ) ) {
	$gBitSystem->registerAppMenu( 'contacts', 'Contact', CONTACTS_PKG_URL.'index.php', 'bitpackage:contacts/menu_contact.tpl', 'contacts');
}

?>
