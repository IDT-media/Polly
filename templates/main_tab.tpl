{if count($items)}
<div class="pageoptions">
	<span class="polly polly-button add">{$add_item}</span>
</div>

<table cellspacing="0" cellpadding="0" class="pagetable">
	<thead>
		<tr>
			<th width="30">ID</th>
			<th>{$Polly->Lang('name')}</th>
			<th>{$Polly->Lang('tag')}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
	
	<tbody>
	{foreach from=$items item=entry}
		{cycle values="row1,row2" assign='rowclass'}
		<tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
			<td>{$entry->id}</td>
			<td>{$entry->name}</td>
			<td>{ldelim}{$mod->GetName()} poll='{$entry->id}'{rdelim}</td>
			<td>{$entry->editlink}</td>
			<td>{$entry->deletelink}</td>
		</tr>
	{/foreach}
	</tbody>	
</table>
{/if}

<div class="pageoptions">
	<span class="polly polly-button add">{$add_item}</span>
</div>