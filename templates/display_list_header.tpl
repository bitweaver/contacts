	<div class="navbar">
		{form class="find" legend="Find in Contact entries"}
			{foreach from=$hidden item=value key=name}
				<input type="hidden" name="{$name}" value="{$value}" />
			{/foreach}
					{formlabel label="Contact Type" for="contact_type"}
					{forminput}
						{html_options values="$contact_type" output="$contact_type" name=contact_t selected=$ihash.contact_type id=contact_t}
					{/forminput}
				<input type="submit" class="btn btn-default" name="search" value="{tr}Filter{/tr}" />&nbsp;
				<input type="button" onclick="location.href='{$smarty.server.SCRIPT_NAME}{if $hidden}?{/if}{foreach from=$hidden item=value key=name}{$name}={$value}&amp;{/foreach}'" value="{tr}Reset{/tr}" />
		{/form}
	</div>

