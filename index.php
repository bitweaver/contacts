<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_contacts/index.php,v 1.9 2009/10/01 14:16:59 wjames5 Exp $
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
 *
 * @package contacts
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

include_once( CONTACTS_PKG_PATH.'Contacts.php' );

$gBitSystem->isPackageActive('contacts', TRUE);

$gContent = new Contacts();

if( !empty( $_REQUEST['content_id'] ) ) {
	$gContent->load($_REQUEST['content_id']);
}

// Comments engine!
if( $gBitSystem->isFeatureActive( 'feature_contacts_comments' ) ) {
	$comments_vars = Array('page');
	$comments_prefix_var='contact note:';
	$comments_object_var='page';
	$commentsParentId = $gContent->mContentId;
	$comments_return_url = CONTENT_PKG_URL.'index.php?content_id='.$gContent->mContentId;
	include_once( LIBERTY_PKG_PATH.'comments_inc.php' );
}

$displayHash = array( 'perm_name' => 'p_contacts_view' );
//$gContent->invokeServices( 'content_display_function', $displayHash );

//$pdata = $gContent->parseData();
//$gBitSmarty->assign_by_ref('parsed',$pdata);
$gBitSmarty->assign_by_ref( 'contactInfo', $gContent->mInfo );
if ( $gContent->isValid() ) {
	$gBitSystem->setBrowserTitle("Content List Item");
	$gBitSystem->display( 'bitpackage:contacts/show_contact.tpl', NULL, array( 'display_mode' => 'display' ));
} else {
	header ("location: ".CONTACTS_PKG_URL."list.php");
	die;
}
?>
