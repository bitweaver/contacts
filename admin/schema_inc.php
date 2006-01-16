<?php
$tables = array(

'bit_contact' => "
  content_id I4 PRIMARY,
  parent_id I4 NOTNULL,
  surname C(32), 
  forename C(32),
  home_phone C(20),
  mobile_phone C(20),
  email_address C(128),
  address1 C(64),
  address2 C(64),
  address3 C(64),
  town C(32),
  county C(32),
  postcode C(10),
  description C(160),
  project_name	C(10),
  revision C(10),
  closed I4,
  closed_user_id I4,
  status C(5),
  priority I2
",

'bit_contact_type' => "
  contact_type_id I4 PRIMARY,
  type_name	C(64)
",

'bit_contact_type_map' => "
  content_id I4 PRIMARY,
  contact_type_id I4 PRIMARY,
  value	I4
",

);

global $gBitInstaller;

$gBitInstaller->makePackageHomeable('contacts');

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( CONTACTS_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( CONTACTS_PKG_NAME, array(
	'description' => "Base Contact management package with contact books and address books",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
	'version' => '0.1',
	'state' => 'beta',
	'dependencies' => '',
) );

// ### Indexes
$indices = array (
	'tiki_contact_contact_id_idx' => array( 'table' => 'tiki_contacts', 'cols' => 'contact_id', 'opts' => NULL ),
);
$gBitInstaller->registerSchemaIndexes( CONTACTS_PKG_NAME, $indices );

// ### Defaults

// ### Default User Permissions
$gBitInstaller->registerUserPermissions( CONTACTS_PKG_NAME, array(
	array('bit_p_view_contact', 'Can browse the Contacts List', 'basic', CONTACTS_PKG_NAME),
	array('bit_p_edit_contact', 'Can edit the Contacts List', 'registered', CONTACTS_PKG_NAME),
	array('bit_p_CONTACTS_admin', 'Can admin Contacts List', 'admin', 'contacts'),
	array('bit_p_remove_contact', 'Can remove a Contact entry', 'editors', 'contacts')
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( CONTACTS_PKG_NAME, array(
	array( CONTACTS_PKG_NAME, 'contacts_default_ordering','title_desc'),
	array( CONTACTS_PKG_NAME, 'contacts_list_created','y'),
	array( CONTACTS_PKG_NAME, 'contacts_list_lastmodif','y'),
	array( CONTACTS_PKG_NAME, 'contacts_list_notes','y'),
	array( CONTACTS_PKG_NAME, 'contacts_list_title','y'),
	array( CONTACTS_PKG_NAME, 'contacts_list_user','y'),
) );

$gBitInstaller->registerSchemaDefault( CONTACTS_PKG_NAME, array(
"INSERT INTO `".BIT_DB_PREFIX."bit_contact_type` VALUES (0, 'Personal')",
"INSERT INTO `".BIT_DB_PREFIX."bit_contact_type` VALUES (1, 'Business')",
"INSERT INTO `".BIT_DB_PREFIX."bit_contact_type` VALUES (2, 'Manufacturer')",
"INSERT INTO `".BIT_DB_PREFIX."bit_contact_type` VALUES (3, 'Distributor')",
"INSERT INTO `".BIT_DB_PREFIX."bit_contact_type` VALUES (4, 'Supplier')",
"INSERT INTO `".BIT_DB_PREFIX."bit_contact_type` VALUES (5, 'Record Company')",
"INSERT INTO `".BIT_DB_PREFIX."bit_contact_type` VALUES (6, 'Record Artist')",
"INSERT INTO `".BIT_DB_PREFIX."bit_contact_type` VALUES (7, 'Cartographer')",

) );


?>
