{strip}

<div class="floaticon">{bithelp}</div>

<div class="listing contacts">
	<div class="header">
		<h1>{tr}Contacts{/tr}</h1>
	</div>

	<div class="body">

		{include file="bitpackage:contacts/display_list_header.tpl"}

		<div class="navbar">
			<ul>
				<li>{biticon ipackage="icons" iname="emblem-symbolic-link" iexplain="sort by"}</li>
				{if $ir_list_title eq 'y'}
					<li>{smartlink ititle="Contact Number" isort="content_id" idefault=1 iorder=desc offset=$offset ihash=$ihash}</li>
					<li>{smartlink ititle="Title" isort="title" offset=$offset ihash=$ihash}</li>
				{/if}
				{if $ir_list_created eq 'y'}
					<li>{smartlink ititle="Created" isort="created" iorder=desc offset=$offset ihash=$ihash}</li>
				{/if}
				{if $ir_list_lastmodif eq 'y'}
					<li>{smartlink ititle="Last Modified" isort="last_modified" iorder=desc offset=$offset ihash=$ihash}</li>
				{/if}
				{if $ir_list_user eq 'y'}
					<li>{smartlink ititle="Creator" isort="user" offset=$offset ihash=$ihash}</li>
				{/if}
				{if $ir_list_notes eq 'y'}
					<li>{smartlink ititle="Notes" isort="notes" iorder=desc offset=$offset ihash=$ihash}</li>
				{/if}
			</ul>
		</div>

		<ul class="clear data">
			{section name=changes loop=$listcontacts}
				<li class="item {cycle values='odd,even'}">
					<div class="floaticon">
						{if ($gBitUser->mUserId and $listcontacts[changes].user_id eq $gBitUser->mUserId) or ($listcontacts[changes].public eq 'y')}
							<a title="{tr}edit{/tr}" href="{$smarty.const.CONTACTS_PKG_URL}edit.php?content_id={$listcontacts[changes].content_id}">{biticon ipackage="icons" iname="accessories-text-editor" iexplain="edit"}</a>
						{/if}
						{if ($gBitUser->mUserId and $listcontacts[changes].user_id eq $gBitUser->mUserId)}
							{if ($gBitUser->isAdmin()) or ($listcontacts[changes].individual eq 'n')}
								<a title="{tr}remove{/tr}" href="{$smarty.const.CONTACTS_PKG_URL}list.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;remove={$listcontacts[changes].content_id}">{biticon ipackage="icons" iname="edit-delete" iexplain="delete"}</a>
							{/if}
						{/if}
					</div>

					{if $ir_list_title eq 'y'}
						<h2><a title="{$listcontacts[changes].title}" href="{$listcontacts[changes].contact_url}">
						IR-{$listcontacts[changes].ir_id} - {$listcontacts[changes].title}{if ($gBitUser->isAdmin()) or ($listcontacts[changes].individual eq 'n')}</a>{/if}</h2>
					{/if}

					{if $ir_list_description eq 'y'}
						<p>{$listcontacts[changes].description}</p>
					{/if}

					<div class="date">
						{if $ir_list_user eq 'y'}
							{tr}Created by {$listcontacts[changes].creator_real_name}{/tr}
						{/if}

						{if $ir_list_created eq 'y'}
							{tr}{if $ir_list_user ne 'y'}<br />Created{/if} on {$listcontacts[changes].created|bit_short_date}{/tr}
							<br />
						{/if}

							{tr}Modified by {$listcontacts[changes].modifier_real_name}{/tr}
						{if $ir_list_lastmodif eq 'y'}
							{tr} on {$listcontacts[changes].last_modified|bit_short_datetime}{/tr}
						{/if}
					</div>

					<div class="footer">
							{tr}Project{/tr}: {$listcontacts[changes].project_name}&nbsp;&bull;&nbsp;
							{tr}Version{/tr}: {$listcontacts[changes].revision}&nbsp;&bull;&nbsp;
							{tr}Status{/tr}: {$listcontacts[changes].status}&nbsp;&bull;&nbsp;
							{tr}Priority{/tr}: {$listcontacts[changes].priority}&nbsp;&bull;&nbsp;
						
						{if $ir_list_visits eq 'y'}
							{tr}Visits{/tr}: {$listcontacts[changes].hits}&nbsp;&bull;&nbsp;
						{/if}
						
						{if $ir_list_activity eq 'y'}
							{tr}Activity{/tr}: {$listcontacts[changes].activity|default:0}
						{/if}
					</div>

					<div class="clear"></div>
				<li>
			{sectionelse}
				<li class="item norecords">
					{tr}No records found{/tr}
				</li>
			{/section}
		</ul>

		{libertypagination numPages=$cant_pages page=$actual_page ihash=$ihash}
	</div><!-- end .body -->
</div><!-- end .irlist -->

{/strip}
