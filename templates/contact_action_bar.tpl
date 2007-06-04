<div class="navbar">
	{if $show_page eq 'y'}
		{if $gBitSystem->isFeatureActive('feature_sample_attachments')}
			{if $gBitUser->hasPermission('bit_p_sample_view_attachments') or $gBitUser->hasPermission('bit_p_sample_admin_attachments') or $gBitUser->hasPermission('bit_p_sample_attach_files')}
				<a href="javascript:document.location='#attachments';flip('attzone{if $atts_show eq 'y'}open{/if}');">{if $atts_count eq 0}{tr}attach file{/tr}{elseif $atts_count eq 1}{tr}1 attachment{/tr}{else}{$atts_count} {tr}attachments{/tr}{/if}</a>
			{else}
				{if $atts_count eq 1}{tr}1&nbsp;attachment{/tr}{else}{$atts_count}&nbsp;{tr}attachments{/tr}{/if}
			{/if}
		{/if}
	{/if}
</div>

{if $gBitSystem->isFeatureActive('feature_sample_comments')}
<div class="navbar comment">
	{if $comments_cant > 0}
		<a href="javascript:document.location='#comments';flip('comzone{if $comments_show eq 'y'}open{/if}');">{if $comments_cant eq 1}{tr}1 comment{/tr}{else}{$comments_cant} {tr}comments{/tr}{/if}</a>
	{else}
		<a href="javascript:document.location='#comments';flip('comzone{if $comments_show eq 'y'}open{/if}');">{tr}comment{/tr}</a>
	{/if}
</div>
{/if}
