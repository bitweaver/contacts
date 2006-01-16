<?php
/**
 * $Header$
 *
 * Copyright ( c ) 2006 bitweaver.org
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * @package contact
 * @subpackage functions
 */

$contact_type = $gContent->getContactTypeList();
$gBitSmarty->assign_by_ref('contact_type', $contact_type);

$gBitSmarty->assign_by_ref('listcontacts', $listcontacts["data"]);
$section = 'contact';

?>