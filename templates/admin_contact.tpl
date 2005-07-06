{strip}
{form legend="Home Contact"}
	<input type="hidden" name="page" value="{$page}" />
	<div class="row">
		{formlabel label="Home Contact (main contact)" for="homeContact"}
		{forminput}
			<select name="homeContact" id="homeContact">
				{section name=ix loop=$contacts}
					<option value="{$contacts[ix].content_id|escape}" {if $contacts[ix].content_id eq $home_contact}selected="selected"{/if}>{$contacts[ix].title|truncate:20:"...":true}</option>
				{sectionelse}
					<option>{tr}No records found{/tr}</option>
				{/section}
			</select>
		{/forminput}
	</div>

	<div class="row submit">
		<input type="submit" name="contactset" value="{tr}Change contact{/tr}" />
	</div>
{/form}
{/strip}
