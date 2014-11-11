<div class="domains-list">

<?php if(is_array($aDomains) && count($aDomains) > 0)
{
	foreach($aDomains as $domain) { ?>
		
		<div class="domain">
			<table>
				<tr>
					<td><?=$domain->sdo_name?></td>
					
					<td><?=isset($domain->prices) && is_array($domain->prices) ? implode(" | ", array_values($domain->prices)) : ''?></td>
				</tr>
			</table>
		</div>
		
	<?php }	
} ?>
</div>
