<div class="display contacts">

{include file="bitpackage:contacts/contact_header.tpl"}
{include file="bitpackage:contacts/contact_date_bar.tpl"}
{include file="bitpackage:contacts/contact_display.tpl"}
{if $print_page ne 'y'}
	{include file="bitpackage:contacts/contact_action_bar.tpl"}
{/if}
</div> {* end .contacts *}
