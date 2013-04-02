<div class="floaticon">
  {if $lock}
    {biticon ipackage="icons" iname="locked" iexplain="locked"}{$info.editor|userlink}
  {/if}
  {if $print_page ne 'y'}
    {if !$lock}
      {if $gBitUser->hasPermission('p_contacts_update')}
		<a href="edit.php?content_id={$contactInfo.content_id}" {if $beingEdited eq 'y'}{popup_init src="`$gBitLoc.THEMES_PKG_URL`overlib.js"}{popup text="$semUser" width="-1"}{/if}>{booticon iname="icon-edit" ipackage="icons" iexplain="edit"}</a>
      {/if}
    {/if}
    <a title="{tr}print{/tr}" href="print.php?content_id={$contactInfo.content_id}">{booticon iname="icon-print"  ipackage="icons"  iexplain="print"}</a>
      {if $gBitUser->hasPermission('p_contacts_delete')}
        <a title="{tr}remove this page{/tr}" href="remove_contact.php?content_id={$contactInfo.content_id}">{booticon iname="icon-trash" ipackage="icons" iexplain="delete"}</a>
      {/if}
  {/if} {* end print_page *}
</div> {*end .floaticon *}
<div class="date">
	{tr}Created by{/tr} {displayname user=$contactInfo.creator_user user_id=$contactInfo.user_id real_name=$contactInfo.creator_real_name}, {tr}Last modification by{/tr} {displayname user=$contactInfo.modifier_user user_id=$contactInfo.modifier_user_id real_name=$contactInfo.modifier_real_name} on {$contactInfo.last_modified|bit_long_datetime}
</div>
