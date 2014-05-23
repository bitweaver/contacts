{strip}
{form legend="Contact List Features"}
	<input type="hidden" name="page" value="{$page}" />

	{foreach from=$formContactListFeatures key=item item=output}
		<div class="control-group">
			{formlabel label=$output.label for=$item}
			{forminput}
				{html_checkboxes name="$item" values="y" checked=$gBitSystem->getConfig($item) labels=false id=$item}
			{/forminput}
			{formhelp note=$output.help page=$output.page}
		</div>
	{/foreach}

	<div class="control-group submit">
		<input type="submit" class="btn btn-default" name="contactlistfeatures" value="{tr}Change preferences{/tr}" />
	</div>
{/form}

{/strip}
