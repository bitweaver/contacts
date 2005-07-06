{strip}
<ul>
	{if $gBitUser->hasPermission('bit_p_read_contact')}
	<li><a class="item" href="{$gBitLoc.CONTACTS_PKG_URL}index.php">{tr}Recent Contacts{/tr}</a></li>
	<li><a class="item" href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php">{biticon ipackage=liberty iname=list iexplain="list contacts" iforce="icon"} {tr}List Contacts{/tr}</a></li>
	{/if}
	{if $gBitUser->hasPermission('bit_p_create_contact')}
		<li><a class="item" href="{$gBitLoc.CONTACTS_PKG_URL}edit.php">{biticon ipackage=liberty iname=new iexplain="create contact" iforce="icon"} {tr}Create/Edit a Contact{/tr}</a></li>
	{/if}
	{if $gBitUser->hasPermission('bit_p_contact_admin')}
		<li><a class="item" href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php">{tr}Admin contacts{/tr}</a></li>
	{/if}
</ul>
{/strip}
