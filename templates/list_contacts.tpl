{* $Header: /cvsroot/bitweaver/_bit_contacts/templates/list_contacts.tpl,v 1.1 2005/07/06 10:41:50 bitweaver Exp $ *}
<div class="floaticon">
	{if $gBitUser->hasPermission('bit_p_contact_admin')}
		<a title="{tr}configure listing{/tr}" href="{$gBitLoc.KERNEL_PKG_URL}admin/index.php?page=contacts">{biticon ipackage=liberty iname="config" iexplain="configure"}</a>
	{/if}
	{bithelp}
</div>

<div class="admin wiki">
<div class="header">
<h1><a href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php">{tr}Contact Records{/tr}</a></h1>
</div>

<div class="body">

<table class="find">
<tr><td>{tr}Find{/tr}</td>
   <td>
   <form method="get" action="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php">
     <input type="text" name="find" value="{$control.find|escape}" />
     <input type="submit" name="search" value="{tr}find{/tr}" />
     <input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
   </form>
   </td>
</tr>
</table>

<form id="checkform" method="post" action="{$smarty.server.PHP_SELF}">
<input type="hidden" name="offset" value="{$control.offset|escape}" />
<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />
<table class="data">
<tr>
{*  at the moment, the only working option to use the checkboxes for is deleting pages. so for now the checkboxes are visible iff $bit_p_remove is set. Other applications make sense as well (categorize, convert to pdf, etc). Add necessary corresponding permission here: *}

{if $gBitUser->hasPermission('bit_p_remove_contact')}              {* ... "or $bit_p_other_sufficient_condition_for_checkboxes eq 'y'"  *}
  {assign var='checkboxes_on' value='y'}
{else}
  {assign var='checkboxes_on' value='n'}
{/if}
{if $checkboxes_on eq 'y'}
	<th>&nbsp;</th>{/if}
{if $contact_list_content_id eq 'y'}
	<th><a href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'content_id_desc'}content_id_asc{else}content_id_desc{/if}">{tr}Contact Id{/tr}</a></th>
{/if}{if $contact_list_title eq 'y'}
	<th><a href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'title_desc'}title_asc{else}title_desc{/if}">{tr}Title{/tr}</a></th>
	<th><a href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'town_desc'}town_asc{else}town_desc{/if}">{tr}Town{/tr}</a></th>
	<th><a href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'county_desc'}county_asc{else}county_desc{/if}">{tr}County{/tr}</a></th>
	<th><a href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'postcode_desc'}postcode_asc{else}postcode_desc{/if}">{tr}Postcode{/tr}</a></th>
{/if}{if $contact_list_description eq 'y'}
	<th><a href="{$gBitLoc.CONTACTS_PKG_URL}list_contacts.php?offset={$control.offset}&amp;sort_mode={if $control.sort_mode eq 'description_desc'}description_asc{else}description_desc{/if}">{tr}Description{/tr}</a></th>
{/if}
</tr>

{cycle values="even,odd" print=false}
{section name=changes loop=$list}
<tr class="{cycle}">
{if $checkboxes_on eq 'y'}
	<td><input type="checkbox" name="checked[]" value="{$list[changes].content_id|escape}" /></td>
{/if}
{if $contact_list_content_id eq 'y'}
	<td><a href="{$gBitLoc.CONTACTS_PKG_URL}index.php?content_id={$list[changes].content_id|escape:"url"}" title="{$list[changes].content_id}">{$list[changes].content_id|truncate:20:"...":true}</a>
		{if $gBitUser->hasPermission('bit_p_edit_contact')}
			<br />(<a href="{$gBitLoc.CONTACTS_PKG_URL}edit.php?content_id={$list[changes].content_id|escape:"url"}">{tr}edit{/tr}</a>)
		{/if}
	</td>
{/if}
{if $contact_list_title eq 'y'}
	<td style="text-align:center;">{$list[changes].title}</td>
	<td style="text-align:center;">{$list[changes].town}</td>
	<td style="text-align:center;">{$list[changes].county}</td>
	<td style="text-align:center;">{$list[changes].postcode}<br />
	{$list[changes].pcdetail}</td>
{/if}
{if $contact_list_description eq 'y'}
	<td style="text-align:center;">{$list[changes].data}</td>
{/if}
</tr>
{sectionelse}
	<tr class="norecords"><td colspan="16">
		{tr}No records found{/tr}
	</td></tr>
{/section}

{if $checkboxes_on eq 'y'}
<tr><td colspan="16">
  <script language="Javascript" type="text/javascript">
  <!--
  // check / uncheck all.
  // in the future, we could extend this to happen serverside as well for the convenience of people w/o javascript.
  document.write("<tr><td><input name=\"switcher\" type=\"checkbox\" onclick=\"switchCheckboxes(this.form.id,'checked[]','switcher')\" /></td>");
  document.write("<td colspan=\"15\">{tr}All{/tr}</td></tr>");
  //-->
  </script>
</td></tr>
{/if}
</table>

{if $checkboxes_on eq 'y'} {* what happens to the checked items *}
  <select name="submit_mult" onchange="this.form.submit();">
    <option value="" selected="selected">{tr}with checked{/tr}:</option>
    {if $gBitUser->hasPermission('bit_p_remove_contact')}
      <option value="remove_contacts">{tr}remove{/tr}</option>
    {/if}
    {* add here e.g. <option value="categorize">{tr}categorize{/tr}</option> *}
  </select>
  <script language="Javascript" type="text/javascript">
  <!--
  // Fake js to allow the use of the <noscript> tag (so non-js-users kenn still submit)
  //-->
  </script>
  <noscript>
    <input type="submit" value="{tr}ok{/tr}" />
  </noscript>
{/if}
</form>

</div> {* end .body *}

{pagination_c}

</div> {* end .admin *}
