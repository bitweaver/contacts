<?php

$tables = array(

'tiki_contacts' => "
  contact_id I4 PRIMARY,
  content_id I4 NOTNULL,
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
  description C(160)
",

);

global $gBitInstaller;

$gBitInstaller->makePackageHomeable('contacts');

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( CONTACTS_PKG_DIR, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( CONTACTS_PKG_DIR, array(
	'description' => "Contact package handing client contact information",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
	'version' => '0.1',
	'state' => 'beta',
	'dependencies' => '',
) );

// ### Indexes
$indices = array (
	'tiki_contact_contact_id_idx' => array( 'table' => 'tiki_contacts', 'cols' => 'contact_id', 'opts' => NULL ),
);
$gBitInstaller->registerSchemaIndexes( CONTACTS_PKG_DIR, $indices );

// ### Sequences
$sequences = array (
	'tiki_contact_id_seq' => array( 'start' => 1 ) 
);
$gBitInstaller->registerSchemaSequences( CONTACTS_PKG_DIR, $sequences );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( CONTACTS_PKG_DIR, array(
	array('bit_p_create_contact', 'Can create a contact', 'registered', 'contacts'),
	array('bit_p_edit_contact', 'Can edit any contact', 'editors', 'contacts'),
	array('bit_p_contact_admin', 'Can admin contact', 'admin', 'contacts'),
	array('bit_p_read_contact', 'Can read contact', 'basic', 'contacts'),
	array('bit_p_remove_contact', 'Can remove contact', 'editors', 'contacts')
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( CONTACTS_PKG_DIR, array(
	array('contacts', 'contact_default_ordering','title_desc'),
	array('contacts', 'contact_list_content_id','y'),
	array('contacts', 'contact_list_title','y'),
	array('contacts', 'contact_list_description','y'),

	array('', 'feature_contact_comments','y'),
	array('', 'feature_contact_attachments','y'),
	array('', 'feature_listContacts','y')
) );

$gBitInstaller->registerSchemaDefault( CONTACTS_PKG_DIR, array(
	"DELETE FROM `".BIT_DB_PREFIX."tiki_content` WHERE `content_type_guid` = 'contacts'"
) );
?>
