<div class="header">
{if $is_categorized eq 'y' and $gBitSystemPrefs.package_categories eq 'y' and $gBitSystemPrefs.feature_categorypath eq 'y'}
<div class="category">
  <div class="path">{$display_catpath}</div>
</div> {* end category *}
{/if}

	<h1>{$contactInfo.title}</h1>
	<div class="description">{$contactInfo.description}</div>

</div> {* end .header *}
