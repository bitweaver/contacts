<?php
/**
 * @version $Header$
 *
 * Copyright ( c ) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 *
 * @package contacts
 */

/**
 * required setup
 */
require_once( LIBERTY_PKG_PATH.'LibertyContent.php' );		// Address base class

/**
 * @package contacts
 */
class Address extends LibertyContent {
		var $mAddressId;

	function Address( $pAddressId ) {
	LibertyContent::LibertyContent();
		if( is_numeric( $pAddressId ) ) {
			$this->mAddressId = $pAddressId;
		}
	}

	/**
	 * Returns title of an Contact object
	 *
	 * @return string Text for the title description
	 */
	function isValid() {
		return( !empty( $this->mAddressId ) && is_numeric( $this->mAddressId ) );
	}

	/**
	 * Load an Address content Item
	 *
	 * (Describe address object here )
	 */
	function load( $pAddressId, $pSecure = TRUE ) {
		$ret = NULL;
		if( is_numeric( $pAddressId ) && (!$pSecure || ($pSecure && $this->isValid())) ) {
			$bindVars = array( $pAddressId );
			$whereSql = '';
			if( $pSecure ) {
				$whereSql = " AND `customers_id`=?";
				array_push( $bindVars, $this->mCustomerId );
			}
			$query = "SELECT * FROM `".BIT_DB_PREFIX."address_book` WHERE `address_book_id`=? $whereSql";
			if( $rs = $this->mDb->query( $query, $bindVars ) ) {
				$ret = $rs->fields;
			}
		}
		return( $ret );
	}

	/**
	* verify, clean up and prepare data to be stored
	* @param $pParamHash all information that is being stored. will update $pParamHash by reference with fixed array of itmes
	* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
	* @access private
	**/
	function verify( &$pParamHash, &$errorHash ) {
		global $gBitUser;
		if( empty( $pParamHash['customers_id'] ) || !is_numeric( $pParamHash['customers_id'] ) ) {
			if( $this->isValid() ) {
				$pParamHash['address_store']['customers_id'] = $this->mCustomerId;
			} else {
				$errorHash['customers_id'] = tra( 'Your must be registered to save addresses' );
			}
		} else {
			$pParamHash['address_store']['customers_id'] = $pParamHash['customers_id'];
		}
			if( empty( $pParamHash['firstname'] ) || strlen( $pParamHash['firstname'] ) < ENTRY_FIRST_NAME_MIN_LENGTH ) {
			$errorHash['firstname'] = tra( 'Your First Name must contain a minimum of ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.' );
		} else {
			$pParamHash['address_store']['entry_firstname'] = $pParamHash['firstname'];
		}
			if( empty( $pParamHash['lastname'] ) || strlen( $pParamHash['lastname'] ) < ENTRY_LAST_NAME_MIN_LENGTH ) {
			$errorHash['lastname'] = tra( 'Your Last Name must contain a minimum of ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.' );
		} else {
			$pParamHash['address_store']['entry_lastname'] = $pParamHash['lastname'];
		}
			if( empty( $pParamHash['street_address'] ) || strlen( $pParamHash['street_address'] ) < ENTRY_STREET_ADDRESS_MIN_LENGTH ) {
			$errorHash['street_address'] = tra( 'Your Street Address must contain a minimum of ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.' );
		} else {
			$pParamHash['address_store']['entry_street_address'] = $pParamHash['street_address'];
		}
			if( empty( $pParamHash['postcode'] ) || strlen( $pParamHash['street_address'] ) < ENTRY_POSTCODE_MIN_LENGTH ) {
			$errorHash['postcode'] = tra( 'Your Post Code must contain a minimum of ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.' );
		} else {
			$pParamHash['address_store']['entry_postcode'] = $pParamHash['postcode'];
		}
			if( empty( $pParamHash['city'] ) || strlen( $pParamHash['city'] ) < ENTRY_CITY_MIN_LENGTH ) {
			$errorHash['city'] = tra( 'Your City must contain a minimum of ' . ENTRY_CITY_MIN_LENGTH . ' characters.' );
		} else {
			$pParamHash['address_store']['entry_city'] = $pParamHash['city'];
		}
			if( !empty( $pParamHash['telephone'] ) && strlen( $pParamHash['telephone'] ) < ENTRY_TELEPHONE_MIN_LENGTH ) {
			$errorHash['telephone'] = tra( 'Your telephone number must contain a minimum of ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.' );
		} elseif( !empty( $pParamHash['telephone'] ) ) {
			$pParamHash['address_store']['entry_telephone'] = $pParamHash['telephone'];
		} else {
			$pParamHash['address_store']['entry_telephone'] = NULL;
		}
			if( ACCOUNT_GENDER == 'true' && !empty( $pParamHash['gender'] ) ) {
			$pParamHash['address_store']['entry_gender'] = $pParamHash['gender'];
		}
			if( ACCOUNT_COMPANY == 'true' && !empty( $pParamHash['company'] ) ) {
			$pParamHash['address_store']['entry_company'] = $pParamHash['company'];
		}
			if( ACCOUNT_SUBURB == 'true' && !empty( $pParamHash['suburb'] ) ) {
			$pParamHash['address_store']['entry_suburb'] = $pParamHash['suburb'];
		}
			if( empty( $pParamHash['country_id'] ) || !is_numeric( $pParamHash['country_id'] ) || ($pParamHash['country_id'] < 1) ) {
			$errorHash['country_id'] = tra( 'You must select a country from the Countries pull down menu.' );
		} else {
			$pParamHash['address_store']['entry_country_id'] = $pParamHash['country_id'];
			if (ACCOUNT_STATE == 'true') {
				if( $this->getZoneCount( $pParamHash['country_id'] ) ) {
					if( $zoneId = $this->getZoneId( $pParamHash['state'], $pParamHash['country_id'] ) ) {
						$pParamHash['address_store']['entry_state'] = $pParamHash['state'];
						$pParamHash['address_store']['entry_zone_id'] = $zoneId;
					} else {
						$errorHash['state'] = tra( 'Please select a state from the States pull down menu.' );
					}
				} elseif( empty( $pParamHash['state'] ) || strlen( $pParamHash['state'] ) < ENTRY_STATE_MIN_LENGTH ) {
					$errorHash['state'] = tra( 'Your State must contain a minimum of ' . ENTRY_STATE_MIN_LENGTH . ' characters.' );
				} else {
					$pParamHash['address_store']['entry_state'] = $pParamHash['state'];
				}
			}
		}
			return( count( $errorHash ) == 0 );
	}

	/**
	* Store an address
	* @param $pParamHash contains all data to store the address
	* @param $pParamHash[title] title for the address
	* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
	**/
	function store( &$pParamHash ) {
		global $current_page_base, $language_page_directory, $template;
			$directory_array = $template->get_template_part($language_page_directory, '/^'.$current_page_base . '/');
		while(list ($key, $value) = each($directory_array)) {
			require_once($language_page_directory . $value);
		}
		if( $this->verify( $pParamHash, $this->mErrors ) ) {
			$process = true;
			if( empty( $pParamHash['address'] ) ) {
				$pParamHash['address'] = $this->mDb->GenID( 'bit_contact_id_seq');
				$this->mDb->associateInsert(`".BIT_DB_PREFIX."address_book`, $pParamHash['address_store']);
			} else {
				if( !empty( $pParamHash['force_history'] ) || ( empty( $pParamHash['minor'] ) && !empty( $this->mInfo['version'] ) && $pParamHash['field_changed'] )) {
					if( empty( $pParamHash['has_no_history'] ) ) {
						$query = "insert into `".BIT_DB_PREFIX."tiki_history`( `page_id`, `version`, `last_modified`, `user_id`, `ip`, `comment`, `data`, `description`, `format_guid`) values(?,?,?,?,?,?,?,?,?)";
 						$result = $this->mDb->query( $query, array( $this->mPageId, (int)$this->mInfo['version'], (int)$this->mInfo['last_modified'] , $this->mInfo['modifier_user_id'], $this->mInfo['ip'], $this->mInfo['comment'], $this->mInfo['data'], $this->mInfo['description'], $this->mInfo['format_guid'] ) );
					}
//					$action = "Created";
//					$mailEvents = 'wiki_page_changes';
				}
				$this->mDb->associateUpdate(`".BIT_DB_PREFIX."address_book`, $pParamHash['address_store'], array( 'address_book_id'=>$pParamHash['address'] ) );
			}
			if( !$this->getDefaultAddress() || !empty( $pParamHash['primary'] ) ) {
				$this->setDefaultAddress( $pParamHash['address'] );
			}
		// process the selected shipping destination
		}
		return( count( $this->mErrors ) == 0 );
	}

/*		function getDefaultAddress() {
		$ret = NULL;
			if( $this->isValid() ) {
				if( empty( $this->mInfo ) ) {
					$this->load();
				}
				if( !empty( $this->mInfo['customers_default_address_id'] ) && $this->addressExists( $this->mInfo['customers_default_address_id'] ) ) {
					$ret = $this->mInfo['customers_default_address_id'];
				} elseif( !empty( $this->mInfo['customers_default_address_id'] ) ) {
					// somehow we lost our default address - let's be sure to clean this up
					$this->setDefaultAddress( NULL );
					unset( $this->mInfo['customers_default_address_id'] );
				}
			}
			return( $ret );
		}

		function setDefaultAddress( $pAddressId ) {
			$ret = NULL;
			if( $this->isValid() && ( is_numeric( $pAddressId ) || is_null( $pAddressId ) ) ) {
				$query = "UPDATE " . TABLE_CUSTOMERS . " SET `customers_default_address_id`=? WHERE `customers_id`=?";
				$this->mDb->query( $query, array( $pAddressId, $this->mCustomerId ) );
				$this->mInfo['customers_default_address_id'] = $pAddressId;
				$ret = TRUE;
			}
			return( $ret );
		}
*/

	/**
	 * Returns list of contract entries
	 *
	 * @param integer AddressId
	 * @return string Text for the title description
	 */
	function addressExists( $pAddressId ) {
		global $gBitDb;
		$ret = FALSE;
		if( is_numeric( $pAddressId ) ) {
			$query = "SELECT count(*) FROM `".BIT_DB_PREFIX."address_book` WHERE `address_book_id`=?";
			$ret = $gBitDb->GetOne( $query, array( $pAddressId ) );
		}
		return $ret;
	}

	/**
	 * Returns list of contract entries
	 *
	 * @param integer AddressId
	 * @return string Text for the title description
	 */
	function isValidAddress( $pAddressId ) {
		$ret = FALSE;
		$errors = array();
		if( !($ret = $this->verifyAddress( $pAddressId, $errors ) ) ) {
			unset( $errors['customers_id'] );
			unset( $errors['gender'] );
			if( !count( $errors ) ) {
				$ret = TRUE;
			}
		}
		return $ret;
	}

	/**
	 * Returns list of contract entries
	 *
	 * @param integer AddressId
	 * @return string Text for the title description
	 */
	function isAddressOwner( $pAddressId ) {
		$ret = FALSE;
		if( is_numeric( $pAddressId ) ) {
			$query = "select count(*) as `total` from `".BIT_DB_PREFIX."address_book`
					  where `customers_id` = ? and `address_book_id` = ?";
			$ret = $this->mDb->getOne( $query, array( $this->mCustomerId, $pAddressId ) );
		}
		return $ret;
	}

	/**
	 * Returns list of addresses
	 *
	 * @param integer CustomerId
	 * @return array List of addresses for the supplied CustomerId
	 */
	function getAddresses( $pCustomerId ) {
		$ret = NULL;
		if( is_numeric( $pCustomerId ) ) {
			$query = "select `address_book_id`, `entry_firstname` as `firstname`, `entry_lastname` as `lastname`,
								`entry_company` as `company`, `entry_street_address` as `street_address`,
								`entry_suburb` as `suburb`, `entry_city` as `city`, `entry_postcode` as `postcode`,
								`entry_state` as `state`, `entry_zone_id` as `zone_id`,
								`entry_country_id` as `country_id`, c.*
						from `".BIT_DB_PREFIX."address_book` ab INNER JOIN `".BIT_DB_PREFIX."countries` c ON( ab.`entry_country_id`=c.`countries_id` )
						where `customers_id` = ?";
				if( $rs = $this->mDb->query( $query, array( $pCustomerId ) ) ) {
				$ret = $rs->GetRows();
			}
		}
		return $ret;
	}

	/**
	 * Returns list of zones for a selected CountryId
	 *
	 * @param integer CountryId
	 * @return array List of zone names
	 */
	function getCountryZones( $pCountryId ) {
		global $gBitDb;
		$ret = array();
		if( is_numeric( $pCountryId ) ) {
			$query = "SELECT `zone_name` from `".BIT_DB_PREFIX."zones` WHERE `zone_country_id` = ? ORDER BY `zone_name`";
			if( $rs = $this->mDb->query($query, array( $pCountryId ) ) ) {
				while (!$rs->EOF) {
					$ret[] = array('id' => $rs->fields['zone_name'], 'text' => $rs->fields['zone_name']);
					$rs->MoveNext();
				}
			}
		}
		return( $ret );
	}

	/**
	 * Returns list of zones for a selected CountryId
	 *
	 * @param integer CountryId
	 * @return integer Number of zones defined for the supplied CountryId
	 */
	function getZoneCount( $pCountryId ) {
		$query = "SELECT count(*) as `total` from `".BIT_DB_PREFIX."zones` WHERE `zone_country_id` = ?";
		return( $this->mDb->getOne( $query, array( $pCountryId ) ) );
	}

	/**
	 * Returns list of zones for a selected CountryId
	 *
	 * @param string Zone Name
	 * @param integer CountryId
	 * @return integer ZoneId for the zone name
	 */
	function getZoneId( $pZone, $pCountryId ) {
		$zone_query =  "SELECT distinct `zone_id`
						FROM `".BIT_DB_PREFIX."zones`
						WHERE `zone_country_id` = ? AND (UPPER(`zone_name`) = ? OR UPPER(`zone_code`) = ?)";
		return( $this->mDb->getOne( $zone_query, array( $pCountryId, strtoupper( $pZone ), strtoupper( $pZone ) ) ) );
	}

	// *********  History functions for the address ********** //
	/**
	* Get count of the number of historic records for the page
	* @return count
	*/
	function getHistoryCount() {
		$ret = NULL;
		if( $this->isValid() ) {
			$query = "SELECT COUNT(*) AS `count`
					FROM `".BIT_DB_PREFIX."tiki_history`
					WHERE `page_id` = ?";
			$rs = $this->mDb->query($query, array($this->mPageId));
			$ret = $rs->fields['count'];
		}
		return $ret;
	}

	/**
	* Get complete set of historical data in order to display a given wiki page version
	* @param pExistsHash the hash that was returned by LibertyContent::pageExists
	* @return array of mInfo data
	*/
	function getHistory( $pVersion=NULL, $pUserId=NULL, $pOffset = 0, $maxRecords = -1 ) {
		$ret = NULL;
		if( $this->isValid() ) {
			global $gBitSystem;
			$versionSql = '';
			if( @BitBase::verifyId( $pUserId ) ) {
				$bindVars = array( $pUserId );
				$whereSql = ' th.`user_id`=? ';
			} else {
				$bindVars = array( $this->mPageId );
				$whereSql = ' th.`page_id`=? ';
			}
			if( !empty( $pVersion ) ) {
				array_push( $bindVars, $pVersion );
				$versionSql = ' AND th.`version`=? ';
			}
			$query = "SELECT tc.`title`, th.*,
				uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name,
				uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name
				FROM `".BIT_DB_PREFIX."tiki_history` th INNER JOIN `".BIT_DB_PREFIX."tiki_pages` tp ON (tp.`page_id` = th.`page_id`) INNER JOIN `".BIT_DB_PREFIX."tiki_content` tc ON (tc.`content_id` = tp.`content_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON (uue.`user_id` = th.`user_id`)
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON (uuc.`user_id` = tc.`user_id`)
				WHERE $whereSql $versionSql order by th.`version` desc";

			$result = $this->mDb->query( $query, $bindVars, $maxRecords, $pOffset );
			$ret = array();
			while( !$result->EOF ) {
				$aux = $result->fields;
				$aux['creator'] = (isset( $aux['creator_real_name'] ) ? $aux['creator_real_name'] : $aux['creator_user'] );
				$aux['editor'] = (isset( $aux['modifier_real_name'] ) ? $aux['modifier_real_name'] : $aux['modifier_user'] );
				array_push( $ret, $aux );
				$result->MoveNext();
			}
		}
		return $ret;
	}

	/**
	 * Roll back to a specific version of a page
	 * @param pVersion Version number to roll back to
	 * @param comment Comment text to be added to the action log
	 * @return TRUE if completed successfully
	 */
	function rollbackVersion( $pVersion, $comment = '' ) {
		$ret = FALSE;
		if( $this->isValid() ) {
			global $gBitUser,$gBitSystem;
			$this->mDb->StartTrans();
			// JHT - cache invalidation appears to be handled by store function - so don't need to do it here
			$query = "select *, `user_id` AS modifier_user_id, `data` AS `edit` from `".BIT_DB_PREFIX."tiki_history` where `page_id`=? and `version`=?";
			$result = $this->mDb->query($query,array( $this->mPageId, $pVersion ) );
			if( $result->numRows() ) {
				$res = $result->fetchRow();
				$res['comment'] = 'Rollback to version '.$pVersion.' by '.$gBitUser->getDisplayName();
				// JHT 2005-06-19_15:22:18
				// set ['force_history'] to
				// make sure we don't destory current content without leaving a copy in history
				// if rollback can destroy the current page version, it can be used
				// maliciously
				$res['force_history'] = 1;
				// JHT 2005-10-16_22:21:10
				// title must be set or store fails
				// we use current page name
				$res['title'] = $this->mPageName;
				if( $this->store( $res ) ) {
					$action = "Changed actual version to $pVersion";
					$t = $gBitSystem->getUTCTime();
					$query = "insert into `".BIT_DB_PREFIX."tiki_actionlog`(`action`,`page_id`,`last_modified`,`user_id`,`ip`,`comment`) values(?,?,?,?,?,?)";
					$result = $this->mDb->query($query,array($action,$this->mPageId,$t,ROOT_USER_ID,$_SERVER["REMOTE_ADDR"],$comment));
					$ret = TRUE;
				}
				$this->mDb->CompleteTrans();
			} else {
				$this->mDb->RollbackTrans();
			}
		}
		return $ret;
	}

	/**
	 * Removes a specific version of a page
	 * @param pVersion Version number to roll back to
	 * @param comment Comment text to be added to the action log
	 * @return TRUE if completed successfully
	 */
	function expungeVersion( $pVersion=NULL, $comment = '' ) {
		$ret = FALSE;
		if( $this->isValid() ) {
			$this->mDb->StartTrans();
			$bindVars = array( $this->mPageId );
			$versionSql = '';
			if( $pVersion ) {
				$versionSql = " and `version`=? ";
				array_push( $bindVars, $pVersion );
			}
			$hasRows = $this->mDb->getOne( "SELECT COUNT(`version`) FROM `".BIT_DB_PREFIX."tiki_history` WHERE `page_id`=? $versionSql ", $bindVars );
			$query = "delete from `".BIT_DB_PREFIX."tiki_history` where `page_id`=? $versionSql ";
			$result = $this->mDb->query( $query, $bindVars );
			if( $hasRows ) {
				global $gBitSystem;
				$action = "Removed version $pVersion";
				$t = $gBitSystem->getUTCTime();
				$query = "insert into `".BIT_DB_PREFIX."tiki_actionlog`(`action`,`page_id`,`last_modified`,`user_id`,`ip`,`comment`) values(?,?,?,?,?,?)";
				$result = $this->mDb->query($query,array($action,$this->mPageId,$t,ROOT_USER_ID,$_SERVER["REMOTE_ADDR"],$comment));
				$ret = TRUE;
			}
			$this->mDb->CompleteTrans();
		}
		return $ret;
	}


}
?>
