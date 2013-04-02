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
				<li>{booticon iname="icon-circle-arrow-right"  ipackage="icons"  iexplain="sort by"}</li>
				{if $gBitSystem->isFeatureActive( 'contacts_list_id' ) }
					<li>{smartlink ititle="Contact Number" isort="content_id" idefault=1 iorder=desc offset=$offset ihash=$ihash}</li>
				{/if}
				{if $gBitSystem->isFeatureActive( 'contacts_list_forename' ) }
					<li>{smartlink ititle="Forename" isort="forename" offset=$offset ihash=$ihash}</li>
				{/if}
				{if $gBitSystem->isFeatureActive( 'contacts_list_surname' ) }
					<li>{smartlink ititle="Surname" isort="surname" offset=$offset ihash=$ihash}</li>
				{/if}
				{if $gBitSystem->isFeatureActive( 'contacts_list_home_phone' ) }
					<li>{smartlink ititle="Home Phone" isort="home_phone" offset=$offset ihash=$ihash}</li>
				{/if}
				{if $gBitSystem->isFeatureActive( 'contacts_list_mobile_phone' ) }
					<li>{smartlink ititle="Mobile Phone" isort="mobile_phone" offset=$offset ihash=$ihash}</li>
				{/if}
				{if $gBitSystem->isFeatureActive( 'contacts_list_email' ) }
					<li>{smartlink ititle="eMail Address" isort="email_address" offset=$offset ihash=$ihash}</li>
				{/if}
				{if $gBitSystem->isFeatureActive( 'contacts_list_last_modified' ) }
					<li>{smartlink ititle="Last Modified" isort="last_modified" offset=$offset ihash=$ihash}</li>
				{/if}
			</ul>
		</div>

		<ul class="clear data">
			{section name=content loop=$listcontacts}
				<li class="item {cycle values='odd,even'}">
					<div class="floaticon">
						{if ($gBitUser->mUserId and $listcontacts[content].user_id eq $gBitUser->mUserId) or ($listcontacts[content].public eq 'y')}
							<a title="{tr}edit{/tr}" href="{$smarty.const.CONTACTS_PKG_URL}edit.php?content_id={$listcontacts[content].content_id}">{booticon iname="icon-edit" ipackage="icons" iexplain="edit"}</a>
						{/if}
						{if ($gBitUser->mUserId and $listcontacts[content].user_id eq $gBitUser->mUserId)}
							{if ($gBitUser->isAdmin()) or ($listcontacts[content].individual eq 'n')}
								<a title="{tr}remove{/tr}" href="{$smarty.const.CONTACTS_PKG_URL}list.php?offset={$offset}&amp;sort_mode={$sort_mode}&amp;remove={$listcontacts[content].content_id}">{booticon iname="icon-trash" ipackage="icons" iexplain="delete"}</a>
							{/if}
						{/if}
					</div>

					{if $gBitSystem->isFeatureActive( 'contacts_list_id' ) }
						<h2><a title="{$listcontacts[content].title}" href="{$listcontacts[content].contact_url}">
						{$listcontacts[content].content_id}&nbsp;&nbsp;
					{/if}
					{if $gBitSystem->isFeatureActive( 'contacts_list_forename' ) }
						{$listcontacts[content].forename}&nbsp;
					{/if}
					{if $gBitSystem->isFeatureActive( 'contacts_list_surname' ) }
						{$listcontacts[content].surname} 
					{/if}
						</a></h2>
						
					{if $gBitSystem->isFeatureActive( 'contacts_list_home_phone' ) }
						Home: {$listcontacts[content].home_phone} 
					{/if}

					{if $gBitSystem->isFeatureActive( 'contacts_list_mobile_phone' ) }
						Mobile: {$listcontacts[content].mobile_phone}
					{/if}

					{if $gBitSystem->isFeatureActive( 'contacts_list_mobile_phone' ) }
						eMail: {$listcontacts[content].email_address}
					{/if}

					{if $gBitSystem->isFeatureActive( 'contacts_list_edit_details' ) }
						<div class="date">
						{tr}Created by {$listcontacts[content].creator_real_name}{/tr}
							<br />{tr}Created on {$listcontacts[content].created|bit_short_date}{/tr}
							<br />{tr}Modified by {$listcontacts[content].modifier_real_name}{/tr}
							{tr} on {$listcontacts[content].last_modified|bit_short_datetime}{/tr}
						</div>
					{/if}

					<div class="footer">
							{tr}Project{/tr}: {$listcontacts[content].project_name}&nbsp;&bull;&nbsp;
							{tr}Version{/tr}: {$listcontacts[content].revision}&nbsp;&bull;&nbsp;
							{tr}Status{/tr}: {$listcontacts[content].status}&nbsp;&bull;&nbsp;
							{tr}Priority{/tr}: {$listcontacts[content].priority}&nbsp;&bull;&nbsp;
						
						{if $ir_list_visits eq 'y'}
							{tr}Visits{/tr}: {$listcontacts[content].hits}&nbsp;&bull;&nbsp;
						{/if}
						
						{if $ir_list_activity eq 'y'}
							{tr}Activity{/tr}: {$listcontacts[content].activity|default:0}
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

		{pagination}
	</div><!-- end .body -->
</div><!-- end .irlist -->

{/strip}
