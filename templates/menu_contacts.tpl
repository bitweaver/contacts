{strip}
{if $packageMenuTitle}<a class="dropdown-toggle" data-toggle="dropdown" href="#"> {tr}{$packageMenuTitle}{/tr} <b class="caret"></b></a>{/if}
<ul class="{$packageMenuClass}">
	<li><a class="item" href="{$smarty.const.CONTACTS_PKG_URL}list.php">{tr}List Contacts{/tr}</a></li>
	{if $gBitUser->isAdmin() or $gBitUser->hasPermission( 'p_contacts_update' ) }
		<li><a class="item" href="{$smarty.const.CONTACTS_PKG_URL}edit.php">{booticon iname="icon-file" ipackage="icons" iexplain="create contact" iforce="icon"} {tr}Create/Edit a Contact{/tr}</a></li>
	{/if}
	{if $gBitUser->hasPermission('p_contacts_admin')}
		<li><a class="item" href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page=contacts">{tr}Admin contacts{/tr}</a></li>
	{/if}
</ul>
{/strip}
