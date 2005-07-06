<?php
/**
* $Header: /cvsroot/bitweaver/_bit_contacts/Attic/BitContacts.php,v 1.1 2005/07/06 10:41:50 bitweaver Exp $
*
* Adapted from tiki_sample to form tiki_contacts but Lester Caine
* Copyright (c) 2004 bitweaver.org
* Copyright (c) 2003 tikwiki.org
* Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
* All Rights Reserved. See copyright.txt for details and a complete list of authors.
* Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
*
* $Id: BitContacts.php,v 1.1 2005/07/06 10:41:50 bitweaver Exp $
*/
/**
* Sample class to illustrate best practices when creating a new bitweaver package that
* builds on core bitweaver functionality, such as the Liberty CMS engine
*
* @date created 2004/8/15
*
* @author lscesuk <lester@lsces.co.uk>
*
* @version $Revision: 1.1 $ $Date: 2005/07/06 10:41:50 $ $Author: bitweaver $
*
* @class BitContacts
*/


require_once( LIBERTY_PKG_PATH.'LibertyAttachable.php' );
//require_once( POSTCODE_PKG_PATH.'AddPostcode.php' );
// International address module will be required

define('CONTACTS_CONTENT_TYPE_GUID', 'contacts' );

class BitContacts extends LibertyAttachable {
    /**
    * Primary key for our mythical Sample class object & table
    * @public
    */
	var $mContactId;
	var $mPostcode;

    /**
    * During initialisation, be sure to call our base constructors
	**/
	function BitContacts( $pContactId=NULL, $pContentId=NULL ) {
		LibertyAttachable::LibertyAttachable();
		$this->registerContentType( CONTACTS_CONTENT_TYPE_GUID, array(
				'content_type_guid' => CONTACTS_CONTENT_TYPE_GUID,
				'content_description' => 'Contact Record',
				'handler_class' => 'BitContacts',
				'handler_package' => 'contacts',
				'handler_file' => 'BitContacts.php',
				'maintainer_url' => 'http://home.lsces.co.uk'
			) );
		$this->mContactId = $pContactId;
	}
	
	
    /**
    * Any method named Store inherently implies data will be written to the database
    * @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	**/
	function store( &$pParamHash ) {
		if( $this->verify( $pParamHash ) && LibertyAttachable::store( $pParamHash ) ) {

			$table = BIT_DB_PREFIX."tiki_contacts";
			if( $this->mContactId ) {
				$locId = array ( "name" => "content_id", "value" => $pParamHash['content_id'] );
				$result = $this->associateUpdate( $table, $pParamHash['contact_store'], $locId );
			} else {
				$pParamHash['contact_store']['contact_id'] = $pParamHash['content_id'];
				$pParamHash['contact_store']['content_id'] = $pParamHash['content_id'];
				$this->mContactId = $pParamHash['content_id'];
				$this->mDb->StartTrans();
				$result = $this->associateInsert( $table, $pParamHash['contact_store'] );
			}
			$this->mDb->CompleteTrans();
		}
		return( count( $this->mErrors ) == 0 );
	}

    /**
    * Make sure the data is safe to store
    * @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	**/
	function verify( &$pParamHash ) {

		$pParamHash['content_type_guid'] = CONTACTS_CONTENT_TYPE_GUID;
		if( isset( $pParamHash['description'] ) ) {
			// insure we don't have column overflow, etc.
			$pParamHash['description'] = substr( $pParamHash['description'], 0, 160 );
		}
		$pParamHash['title'] = $pParamHash['surname'].','.$pParamHash['forename'];
		$pParamHash['contact_store']['contact_id'] = $this->mContactId;
		$pParamHash['contact_store']['content_id'] = $this->mContactId;
		$pParamHash['contact_store']['description'] = $pParamHash['description'];
		$pParamHash['contact_store']['forename'] = $pParamHash['forename'];
		$pParamHash['contact_store']['surname'] = $pParamHash['surname'];
		$pParamHash['contact_store']['address1'] = $pParamHash['address1'];
		$pParamHash['contact_store']['address2'] = $pParamHash['address2'];
		$pParamHash['contact_store']['address3'] = $pParamHash['address3'];
		$pParamHash['contact_store']['town'] = $pParamHash['town'];
		$pParamHash['contact_store']['county'] = $pParamHash['county'];
		$pParamHash['contact_store']['postcode'] = $pParamHash['postcode'];
		$pParamHash['contact_store']['home_phone'] = $pParamHash['home_phone'];
		$pParamHash['contact_store']['mobile_phone'] = $pParamHash['mobile_phone'];
		$pParamHash['contact_store']['email_address'] = $pParamHash['email_address'];

		return( count( $this->mErrors ) == 0 );
	}
	
    /**
    * Load the data from the database
    * @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	**/
	function load() {
		if( $this->mContactId ) {
			// LibertyContent::load() assumes you have joined already, and will not execute any sql!
			// This is a significant performance optimization
			$query = "SELECT s.*, tc.* FROM `".BIT_DB_PREFIX."tiki_contacts` s, `".BIT_DB_PREFIX."tiki_content` tc WHERE s.`content_id`=tc.`content_id` AND s.`content_id`=?";
			$result = $this->query( $query, array( $this->mContactId ) );
			if ( $result && $result->numRows() ) {
				$ret = $result->numRows();
				$this->mInfo = $result->fields;
				$this->mContentId = $result->fields['content_id'];
				LibertyAttachable::load();
			}
		}
		return( count( $this->mInfo ) == 0 );
	}
	
    /**
    * This function generates a list of records from the tiki_content database for use in a list page
	**/
	function getList( &$pParamHash ) {
		
		LibertyContent::prepGetList( $pParamHash );
		
		$find = $pParamHash['find'];
		$sort_mode = $pParamHash['sort_mode'];
		if ($sort_mode == 'description_desc') {
			$sort_mode = 'data_desc';
		}

		if ($sort_mode == 'description_asc') {
			$sort_mode = 'data_asc';
		}

		if ( is_array($find) ) { // you can use an array of pages
			$mid = " WHERE tc.`title` IN (".implode(',',array_fill(0,count($find),'?')).")";
			$bindvars = $find;
		} elseif ( is_string($find) and $find != '' ) { // or a string
			$mid = " WHERE UPPER(tc.`title`) like ? ";
			$bindvars = array('%' . strtoupper( $find ) . '%');
		} elseif( !empty( $pUserId ) ) { // or a string
			$mid = " WHERE tc.`creator_user_id` = ? ";
			$bindvars = array( $pUserId );
		} else {
			$mid = "";
			$bindvars = array();
		}

		$query = "SELECT tc.`content_id`, tc.`title`, s.`home_phone`, s.`mobile_phone`, s.`email_address`, " .
				 "s.`address1` || ',' || s.`address2` || ',' || s.`address3` as `pcdetail`, " .
				 "s.`town`, s.`county`, " .
				 "s.`postcode`, s.`description`, tc.`data` " .
				 "FROM `".BIT_DB_PREFIX."tiki_content` tc " .
				 "LEFT JOIN `".BIT_DB_PREFIX."tiki_contacts` s ON s.`content_id` = tc.`content_id` " .
				 (!empty( $mid ) ? $mid.' AND ' : ' WHERE ')." tc.`content_type_guid` = '".CONTACTS_CONTENT_TYPE_GUID .
				 "' ORDER BY ".$this->convert_sortmode($pParamHash['sort_mode']);

		$query_cant = "select count(*) from `".BIT_DB_PREFIX."tiki_content` tc ".(!empty( $mid ) ? $mid.' AND ' : ' WHERE ')." tc.`content_type_guid` = '".CONTACTS_CONTENT_TYPE_GUID."'";
		$result = $this->query($query,$bindvars,$pParamHash['max_records'],$pParamHash['offset']);
		$ret = array();
		while ($res = $result->fetchRow()) {
			$ret[] = $res;
		}
		$pParamHash["data"] = $ret;

		$pParamHash["cant"] = $this->getOne($query_cant,$bindvars);

		LibertyContent::postGetList( $pParamHash );
	}

    /**
    * Generates the URL to the contact page
    * @param pExistsHash the hash that was returned by LibertyContent::pageExists
    * @return the link to display the page.
    */
	function getDisplayUrl() {
		$ret = NULL;
		if( !empty( $this->mContactId ) ) {
			$ret = CONTACTS_PKG_URL."index.php?content_id=".$this->mContactId;
		}
		return $ret;
	}
	
}

?>
