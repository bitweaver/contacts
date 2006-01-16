<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_contacts/edit.php,v 1.4 2006/01/16 15:52:27 lsces Exp $
 *
 * Copyright (c) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * @package contacts
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

//include_once( LIBERTY_PKG_PATH.'edit_help_inc.php' );
include_once( CONTACTS_PKG_PATH.'Contacts.php' );

$gBitSystem->verifyPackage( 'contacts' );
$gBitSystem->isPackageActive('contacts', TRUE);
$gContent = new Contacts();

if( !empty( $_REQUEST['content_id'] ) ) {
	$gContent->load($_REQUEST['content_id']);
}

// Get plugins with descriptions
global $gLibertySystem;

//if( $gContent->isLocked() ) {
//	$gBitSystem->fatalError( 'Cannot edit page because it is locked' );
//}

if( !empty( $gContent->mInfo ) ) {
	$formInfo = $gContent->mInfo;
	$formInfo['edit'] = !empty( $gContent->mInfo['data'] ) ? $gContent->mInfo['data'] : '';
}

if(isset($_REQUEST["edit"])) {
	$formInfo['edit'] = $_REQUEST["edit"];
}
if(isset($_REQUEST['title'])) {
	$formInfo['title'] = $_REQUEST['title'];
}
if(isset($_REQUEST["description"])) {
	$formInfo['description'] = $_REQUEST["description"];
}
if (isset($_REQUEST["comment"])) {
	$formInfo['comment'] = $_REQUEST["comment"];
}

$cat_type = BITPAGE_CONTENT_TYPE_GUID;
if(isset($_REQUEST["preview"])) {

	// get files from all packages that process this data further
	foreach( $gBitSystem->getPackageIntegrationFiles( 'form_processor_inc.php', TRUE ) as $package => $file ) {
		if( $gBitSystem->isPackageActive( $package ) ) {
			include_once( $file );
		}
	}

	$gBitSmarty->assign('preview',1);
	$gBitSmarty->assign('title',$_REQUEST["title"]);

	$parsed = $gContent->parseData($formInfo['edit'], (!empty( $_REQUEST['format_guid'] ) ? $_REQUEST['format_guid'] :
		( isset($gContent->mInfo['format_guid']) ? $gContent->mInfo['format_guid'] : 'tikiwiki' ) ) );
	/* SPELLCHECKING INITIAL ATTEMPT */
	//This nice function does all the job!
	if ($wiki_spellcheck == 'y') {
		if (isset($_REQUEST["spellcheck"]) && $_REQUEST["spellcheck"] == 'on') {
			$parsed = $gBitSystem->spellcheckreplace($edit_data, $parsed, $gBitLanguage->mLanguage, 'editwiki');
			$gBitSmarty->assign('spellcheck', 'y');
		} else {
			$gBitSmarty->assign('spellcheck', 'n');
		}
	}
	$gBitSmarty->assign_by_ref('parsed', $parsed);
	$gContent->invokeServices( 'content_preview_function' );
} else {
	$gContent->invokeServices( 'content_edit_function' );
}

function htmldecode($string) {
   $string = strtr($string, array_flip(get_html_translation_table(HTML_ENTITIES)));
   $string = preg_replace("/&#([0-9]+);/me", "chr('\\1')", $string);
   return $string;
}

function parse_output(&$obj, &$parts,$i) {
	if( !empty( $obj->parts ) ) {
		for($i=0; $i<count($obj->parts); $i++) {
			parse_output($obj->parts[$i], $parts,$i);
		}
	} else {
		$ctype = $obj->ctype_primary.'/'.$obj->ctype_secondary;
		switch($ctype) {
			case 'application/x-tikiwiki':
				$aux["body"] = $obj->body;
				$ccc=$obj->headers["content-type"];
				$items = split(';',$ccc);
				foreach($items as $item) {
					$portions = split('=',$item);
					if(isset($portions[0])&&isset($portions[1])) {
						$aux[trim($portions[0])]=trim($portions[1]);
					}
				}
				$parts[]=$aux;
		}
	}
}

// Pro
// Check if the page has changed
if (isset($_REQUEST["fCancel"])) {
	if( !empty( $gContent->mContentId ) ) {
		header("Location: ".$gContent->getDisplayUrl() );
	} else {
		header("Location: ".CONTACTS_PKG_URL );
	}
	die;
} elseif (isset($_REQUEST["fSavePage"])) {
	// Check if all Request values are delivered, and if not, set them
	// to avoid error messages. This can happen if some features are
	// disabled
	if( $gContent->store( $_REQUEST ) ) {
		if ( $gBitSystem->isFeatureActive( 'contact_watch_author' ) ) {
			$gBitUser->storeWatch( "contact_entry_changed", $gContent->mContentId, $gContent->mContentTypeGuid, $_REQUEST['title'], $gContent->getDisplayUrl() );
		}
		header("Location: ".$gContent->getDisplayUrl() );
	} else {
		$formInfo = $_REQUEST;
		$formInfo['data'] = &$_REQUEST['edit'];
	}
} elseif( !empty( $_REQUEST['edit'] ) ) {
	// perhaps we have a javascript non-saving form submit
	$formInfo = $_REQUEST;
	$formInfo['data'] = &$_REQUEST['edit'];
}

// Configure quicktags list
if ($gBitSystem->isPackageActive( 'quicktags' ) ) {
	include_once( QUICKTAGS_PKG_PATH.'quicktags_inc.php' );
}

if ($gBitSystem->isFeatureActive( 'feature_theme_control' ) ) {
	include( THEMES_PKG_PATH.'tc_inc.php' );
}

// Flag for 'page bar' that currently 'Edit' mode active
// so no need to show comments & attachments, but need
// to show 'wiki quick help'
$gBitSmarty->assign('edit_page', 'y');

// WYSIWYG and Quicktag variable
$gBitSmarty->assign( 'textarea_id', 'editwiki' );

// formInfo might be set due to a error on submit
if( empty( $formInfo ) ) {
	$formInfo = &$gContent->mInfo;
}
$formInfo['contact_type'] = $gContent->getContactsTypeList();

$gBitSmarty->assign_by_ref( 'contentInfo', $formInfo );
$gBitSmarty->assign_by_ref( 'errors', $gContent->mErrors );
$gBitSmarty->assign( (!empty( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : 'body').'TabSelect', 'tdefault' );
$gBitSmarty->assign('show_page_bar', 'y');

$gBitSystem->display( 'bitpackage:contacts/edit.tpl', 'Edit: ' );
?>
