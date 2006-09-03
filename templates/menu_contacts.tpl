{strip}
<ul>
	<li><a class="item" href="{$smarty.const.CONTACTS_PKG_URL}list.php">{tr}List Contacts{/tr}</a></li>
	{if $gBitUser->isAdmin() or $gBitUser->hasPermission( 'bit_p_edit_irlist' ) }
		<li><a class="item" href="{$smarty.const.CONTACTS_PKG_URL}edit.php">{biticon ipackage="icons" iname="document-new" iexplain="create contact" iforce="icon"} {tr}Create/Edit a Contact{/tr}</a></li>
	{/if}
	{if $gBitUser->hasPermission('bit_p_contact_admin')}
		<li><a class="item" href="{$smarty.const.CONTACTS_PKG_URL}list_contacts.php">{tr}Admin contacts{/tr}</a></li>
	{/if}
</ul>
{/strip}