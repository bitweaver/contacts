<div class="body">
	<div class="content">
		{include file="bitpackage:liberty/storage_thumbs.tpl"}
		Forename: {$contactInfo.forename}<br />
		Surname: {$contactInfo.surname}<br />
		<br />
		Home Phone: {$contactInfo.home_phone}<br />
		Mobile Phone:{$contactInfo.mobile_phone}<br />
		Address:<br />
		{$contactInfo.address1}<br />
		{$contactInfo.address2}<br />
		{$contactInfo.address3}<br />
		Town: {$contactInfo.town}<br />
		County: {$contactInfo.county}<br />
		Postcode: {$contactInfo.postcode}<br />
		<br />
		eMail Address:<br />
		{$contactInfo.email_address}<br />
		<br />
		Note: {$contactInfo.description}<br />
		Memo:<br />
		{$contactInfo.data}<br />
	</div><!-- end .content -->
</div><!-- end .body -->
