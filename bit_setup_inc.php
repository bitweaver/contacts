<?php
global $gBitSystem, $gBitSmarty;
$registerHash = array(
	'package_name' => 'contacts',
	'package_path' => dirname( __FILE__ ).'/',
	'homeable' => TRUE,
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'contacts' ) ) {
	$menuHash = array(
		'package_name'  => CONTACTS_PKG_NAME,
		'index_url'     => CONTACTS_PKG_URL.'index.php',
		'menu_template' => 'bitpackage:contacts/menu_contacts.tpl',
	);
	$gBitSystem->registerAppMenu( $menuHash );
}

?>
