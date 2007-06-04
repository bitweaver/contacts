{* $Header$ *}
<div class="floaticon">{bithelp}</div>

{assign var=serviceEditTpls value=$gLibertySystem->getServiceValues('content_edit_tpl')}

<div class="admin contact">
	<div class="header">
		<h1>
		{* this weird dual assign thing is cause smarty wont interpret backticks to object in assign tag - spiderr *}
		{assign var=conDescr value=$gContent->mType.content_description}
		{if $contactInfo.content_id}
			{assign var=editLabel value="{tr}Edit{/tr} $conDescr"}
			{tr}{tr}Edit{/tr} {$contactInfo.title}{/tr}
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
						<input type="hidden" name="content_id" value="{$contactInfo.content_id}" />
						
						<div class="row">
							{formfeedback warning=`$errors.names`}
							{formfeedback warning=`$errors.store`}

							{formlabel label="$conDescr Contact" for="contentno"}
							{if !$contactInfo.contact_id}
								{forminput}
									New Contact Entry
								{/forminput}
							{else}
								{forminput}
									Edit Contact Entry No : {$contactInfo.contact_id}
								{/forminput}
							{/if}

							{formlabel label="Contact Type" for="contact_type"}
							{forminput}
								<input type="text" size="24" maxlength="24" name="contact_type" id="project_name" value="{$contactInfo.contact_type}" />
							{/forminput}
							
						</div>
						<div class="row">
							{formlabel label="$conDescr Title" for="title"}
							{forminput}
								<input type="text" size="10" maxlength="10" name="ctitle" id="ctitle" value="{$contactInfo.ctitle}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="Forename" for="forename"}
							{forminput}
								<input size="60" type="text" name="forename" id="forename" value="{$contactInfo.forename|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="Surname" for="surname"}
							{forminput}
								<input size="60" type="text" name="surname" id="surname" value="{$contactInfo.surname|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="Home Phone" for="home_phone"}
							{forminput}
								<input size="30" type="text" name="home_phone" id="home_phone" value="{$contactInfo.home_phone|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="Mobile Phone" for="mobile_phone"}
							{forminput}
								<input size="30" type="text" name="mobile_phone" id="mobile_phone" value="{$contactInfo.mobile_phone|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="eMail Address" for="email_address"}
							{forminput}
								<input size="60" type="text" name="email_address" id="email_address" value="{$contactInfo.email_address|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="Address" for="address1"}
							{forminput}
								<input size="60" type="text" name="address1" id="address1" value="{$contactInfo.address1|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{forminput}
								<input size="60" type="text" name="address2" id="address2" value="{$contactInfo.address2|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{forminput}
								<input size="60" type="text" name="address3" id="address3" value="{$contactInfo.address3|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="Town" for="town"}
							{forminput}
								<input size="30" type="text" name="town" id="town" value="{$contactInfo.town|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="County" for="county"}
							{forminput}
								<input size="30" type="text" name="county" id="county" value="{$contactInfo.county|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="Postcode" for="postcode"}
							{forminput}
								<input size="30" type="text" name="postcode" id="postcode" value="{$contactInfo.postcode|escape}" />
							{/forminput}
						</div>
						<div class="row">
							{formlabel label="Note" for="description"}
							{forminput}
								<input size="60" type="text" name="description" id="description" value="{$contactInfo.description|escape}" />
							{/forminput}
						</div>
					{/legend}
				{/jstab}

				{jstab title="Contact Notes"}
					{legend legend="Notes Body"}
						{if $gBitSystem->isPackageActive( 'quicktags' )}
							{include file="bitpackage:quicktags/quicktags_full.tpl"}
						{/if}

						<div class="row">
							{forminput}
								<textarea id="{$textarea_id}" name="edit" rows="{$rows|default:20}" cols="{$cols|default:80}">{$contactInfo.data|escape:html}</textarea>
							{/forminput}
						</div>

						{if $page ne 'SandBox'}
							<div class="row">
								{formlabel label="Comment" for="comment"}
								{forminput}
									<input size="50" type="text" name="comment" id="comment" value="{$contactInfo.comment}" />
									{formhelp note="Add a comment to illustrate your most recent changes."}
								{/forminput}
							</div>
						{/if}

					{/legend}
				{/jstab}

				{jstab title="Liberty Extensions"}
					{if $serviceEditTpls.categorization }
						{legend legend="Categorize"}
							{include file=$serviceEditTpls.categorization"}
						{/legend}
					{/if}
				{/jstab}
			{/jstabs}

			{include file="bitpackage:liberty/edit_services_inc.tpl serviceFile=content_edit_mini_tpl}

			<div class="row submit">
				<input type="submit" name="fCancel" value="{tr}Cancel{/tr}" />&nbsp;
				<input type="submit" name="fSaveContact" value="{tr}Save{/tr}" />
			</div>
		{/form}

		{include file="bitpackage:liberty/edit_help_inc.tpl"}

	</div><!-- end .body -->
</div><!-- end .admin -->

{/strip}
