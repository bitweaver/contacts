<?php
// $Header: /cvsroot/bitweaver/_bit_contacts/edit.php,v 1.1.1.1.2.1 2005/08/12 11:38:54 wolff_borg Exp $
// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// Initialization
require_once( '../bit_setup_inc.php' );
include_once( CONTACTS_PKG_PATH.'BitContacts.php');

$gBitSystem->isPackageActive('contacts', TRUE);
$gBitSystem->verifyPermission('bit_p_edit_contact');

$contactId = ( isset( $_REQUEST['content_id'] ) ? $_REQUEST['content_id'] : 0 );

$gContact = new BitContacts( $contactId );
$gContact->load();
/*
if(isset($gContact->mInfo['contact_cache']) && $gContact->mInfo['contact_cache']!=0) {
  $contact_cache = $gContact->mInfo['contact_cache'];
  $smarty->assign('contact_cache',$contact_cache);
}
*/

if (!$gBitUser->isAdmin()) {
	if (!$gBitUser->hasPermission('bit_p_use_HTML')) {
		$_REQUEST["allowhtml"] = 'off';
	}
}
//$smarty->assign('allowhtml','y');
$smarty->assign_by_ref('data', $gContact->mInfo);
if(isset($_REQUEST["edit"])) {
  if(isset($_REQUEST["allowhtml"]) && $_REQUEST["allowhtml"]=="on") {
    $edit_data = $_REQUEST["edit"];
  } else {
	$edit_data = htmlspecialchars($_REQUEST["edit"]);
  }
} else {
	if (isset($gContact->mInfo["data"])) {
		$edit_data = $gContact->mInfo["data"];
	} else {
		$edit_data = '';
	}
}

if (isset($gContact->mInfo["description"])) {
	$smarty->assign('description', $gContact->mInfo["description"]);
	$description = $gContact->mInfo["description"];
} else {
	$smarty->assign('description', '');
	$description = '';
}

if(isset($_REQUEST["description"])) {
  $smarty->assign_by_ref('description',$_REQUEST["description"]);
  $description = $_REQUEST["description"];
}

if(isset($_REQUEST["allowhtml"]) and $_REQUEST["allowhtml"] == "on") {
    $smarty->assign('allowhtml','y');
} else {
	$smarty->assign('allowhtml','n');
}

$smarty->assign_by_ref('parsed', $parsed);
$smarty->assign('preview',0);
// If we are in preview mode then preview it!
if(isset($_REQUEST["preview"])) {
  $smarty->assign('preview',1);
}
if(isset($_REQUEST['edit'])) {
  $smarty->assign('edit',$_REQUEST['edit']);
}

// Pro
// Check if the page has changed
if (isset($_REQUEST["fSavePage"])) {
	
	// Check if all Request values are delivered, and if not, set them
	// to avoid error messages. This can happen if some features are
	// disabled
	$cat_obj_type=BITCONTACT_CONTENT_TYPE_GUID;
	$cat_objid = $gContent->mContentId;
	$cat_desc = ($feature_wiki_description == 'y') ? substr($_REQUEST["description"],0,200) : '';
	$cat_name = $gContact->mContactId;
	$cat_href = CONTACTS_PKG_URL."index.php?content_id=".$cat_objid;
	if( $gContact->store( $_REQUEST ) ) {
		header("Location: ".$gContact->getDisplayUrl() );
        $gContact->load();
	} else {
		$smarty->assign_by_ref( 'errors', $gContact->mErrors );	
	}
}
$cat_obj_type=BITCONTACT_CONTENT_TYPE_GUID;
$cat_objid = $gContent->mContentId;

// WYSIWYG and Quicktag variable
$smarty->assign( 'textarea_id', 'editcontact' );

$smarty->assign('edit_page', 'y');



$smarty->assign_by_ref( 'contactInfo', $gContact->mInfo );

$smarty->assign('show_page_bar', 'y');

if ( isset($_REQUEST["cancel"]) ) {
  $gBitSystem->display( 'bitpackage:contacts/show_contact.tpl');
} else { 
  $gBitSystem->display( 'bitpackage:contacts/edit_contact.tpl');
}  
?>

