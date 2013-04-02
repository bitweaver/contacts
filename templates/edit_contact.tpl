{* $Header$ *}
{popup_init src="`$gBitLoc.THEMES_PKG_URL`overlib.js"}
{strip}
<div class="floaticon">{bithelp}</div>

{* Check to see if there is an editing conflict *}
{if $editpageconflict == 'y'}
	<script language="javascript" type="text/javascript">
		<!-- Hide Script
			alert("{tr}This page is being edited by{/tr} {$semUser}. {tr}Proceed at your own peril{/tr}.")
		//End Hide Script-->
	</script>
{/if}

<div class="admin contact">

	{if $preview}
		<h2>Preview - {$pageInfo.title}</h2>
		<div class="preview">
			{include file="bitpackage:contacts/contact_display.tpl" page=`$contactInfo.content_id`}
		</div>
	{/if}

	<div class="header">
		<h1>
		{if $contactInfo.content_id}
			{tr}{tr}Edit - {/tr} {$contactInfo.title}{/tr}
		{else}
			{tr}Create New Record{/tr}
		{/if}
		</h1>
	</div>

	<div class="body">
		{form legend="Edit/Create Contact Record" enctype="multipart/form-data" id="editpageform"}
			<input type="hidden" name="content_id" value="{$contactInfo.content_id}" />

			<div class="control-group">
				{formlabel label="Forename" for="forename"}
				{forminput}
					<input size="60" type="text" name="forename" id="forename" value="{$contactInfo.forename|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Surname" for="surname"}
				{forminput}
					<input size="60" type="text" name="surname" id="surname" value="{$contactInfo.surname|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Home Phone" for="home_phone"}
				{forminput}
					<input size="30" type="text" name="home_phone" id="home_phone" value="{$contactInfo.home_phone|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Mobile Phone" for="mobile_phone"}
				{forminput}
					<input size="30" type="text" name="mobile_phone" id="mobile_phone" value="{$contactInfo.mobile_phone|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="eMail Address" for="email_address"}
				{forminput}
					<input size="60" type="text" name="email_address" id="email_address" value="{$contactInfo.email_address|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Address" for="address1"}
				{forminput}
					<input size="60" type="text" name="address1" id="address1" value="{$contactInfo.address1|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{forminput}
					<input size="60" type="text" name="address2" id="address2" value="{$contactInfo.address2|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{forminput}
					<input size="60" type="text" name="address3" id="address3" value="{$contactInfo.address3|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Town" for="town"}
				{forminput}
					<input size="30" type="text" name="town" id="town" value="{$contactInfo.town|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="County" for="county"}
				{forminput}
					<input size="30" type="text" name="county" id="county" value="{$contactInfo.county|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Postcode" for="postcode"}
				{forminput}
					<input size="30" type="text" name="postcode" id="postcode" value="{$contactInfo.postcode|escape}" />
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Note" for="description"}
				{forminput}
					<input size="60" type="text" name="description" id="description" value="{$contactInfo.description|escape}" />
				{/forminput}
			</div>

			<div class="control-group">
				{formlabel label="Memo" for="$textarea_id"}
				{forminput}
					<input type="hidden" name="rows" value="{$rows}" />
					<input type="hidden" name="cols" value="{$cols}" />
					<textarea id="{$textarea_id}" name="edit" rows="{$rows|default:20}" cols="{$cols|default:80}">{if !$preview}{$contactInfo.data|escape}{else}{$edit}{/if}</textarea>
				{/forminput}
			</div>

			<div class="control-group submit">
				<input type="submit" name="preview" value="{tr}Preview{/tr}" /> 
				<input type="submit" name="fSavePage" value="{tr}Save{/tr}" />&nbsp;
				<input type="submit" name="cancel" value="{tr}Cancel{/tr}" />
			</div>
		{/form}

	</div><!-- end .body -->
</div><!-- end .contact -->

{/strip}

<br />

