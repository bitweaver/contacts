{* $Header$ *}
<div class="floaticon">{bithelp}</div>

{assign var=serviceEditTpls value=$gLibertySystem->getServiceValues('content_edit_tpl')}

<div class="admin contact">
	<div class="header">
		<h1>
		{* this weird dual assign thing is cause smarty wont interpret backticks to object in assign tag - spiderr *}
		{assign var=conDescr value=$gContent->mType.content_description}
		{if $contentInfo.content_id}
			{assign var=editLabel value="{tr}Edit{/tr} $conDescr"}
			{tr}{tr}Edit{/tr} {$contentInfo.title}{/tr}
		{else}
			{assign var=editLabel value="{tr}Create{/tr} $conDescr"}
			{tr}{$editLabel}{/tr}
		{/if}
		</h1>
	</div>

	{* Check to see if there is an editing conflict *}
	{if $errors.edit_conflict}
		<script language="javascript" type="text/javascript">
			<!--
				alert( "{$errors.edit_conflict|strip_tags}" );
			-->
		</script>
		{formfeedback warning=`$errors.edit_conflict`}
	{/if}

	{strip}
	<div class="body">
		{form enctype="multipart/form-data" id="editpageform"}
			{jstabs}
				{jstab title="$editLabel Body"}
					{legend legend="`$editLabel` Body"}
						<input type="hidden" name="content_id" value="{$contentInfo.content_id}" />
						
						<div class="row">
							{formfeedback warning=`$errors.title`}

							{if !$contentInfo.page_id}
							{formlabel label="$conDescr Contact" for="contentno"}
								{forminput}
									New Contact Entry
								{/forminput}
							{/if}
								{formlabel label="Contact Type" for="contact_type"}
								{forminput}
									<input type="text" size="24" maxlength="24" name="contact_type" id="project_name" value="{$contentInfo.contact_type}" />
								{/forminput}
							{formlabel label="$conDescr Title" for="title"}
							{forminput}
								{if $gBitUser->hasPermission( 'bit_p_rename' ) || !$contentInfo.page_id}
									<input type="text" size="50" maxlength="200" name="title" id="title" value="{$contentInfo.title}" />
								{else}
									{$page} {$contentInfo.title}
								{/if}
							{/forminput}

						</div>

						{if $gBitSystem->isPackageActive( 'quicktags' )}
							{include file="bitpackage:quicktags/quicktags_full.tpl"}
						{/if}

						<div class="row">
							{forminput}
								<textarea id="{$textarea_id}" name="edit" rows="{$rows|default:20}" cols="{$cols|default:80}">{$contentInfo.data|escape:html}</textarea>
							{/forminput}
						</div>

						{if $page ne 'SandBox'}
							<div class="row">
								{formlabel label="Comment" for="comment"}
								{forminput}
									<input size="50" type="text" name="comment" id="comment" value="{$contentInfo.comment}" />
									{formhelp note="Add a comment to illustrate your most recent changes."}
								{/forminput}
							</div>
						{/if}

						<div class="row submit">
							<input type="submit" name="fCancel" value="{tr}Cancel{/tr}" />&nbsp;
							<input type="submit" name="fSavePage" value="{tr}Save{/tr}" />
						</div>

					{/legend}
				{/jstab}

				{jstab title="Liberty Extensions"}
					{if $serviceEditTpls.categorization }
						{legend legend="Categorize"}
							{include file=$serviceEditTpls.categorization"}
						{/legend}
					{/if}
				{/jstab}

				{jstab title="Advanced Options"}
					{if $gBitSystem->isPackageActive( 'nexus' )}
						{legend legend="Insert Link in Menu"}
							{include file="bitpackage:nexus/insert_menu_item_inc.tpl"}
						{/legend}
					{/if}
				{/jstab}
			{/jstabs}
		{/form}

		<br /><br />
		{include file="bitpackage:liberty/edit_help_inc.tpl"}

	</div><!-- end .body -->
</div><!-- end .admin -->

{/strip}
