{foreach from=$items key=section item=templates}

	<fieldset>
		{capture assign='section_lang'}{$section}_templates{/capture}
		<legend>{$mod->Lang($section_lang)}</legend>

		{if count($templates) > 0}
		<table cellspacing="0" class="pagetable">
			<thead>
				<tr>
					<th>{$mod->Lang('template')}</th>				
					<th class="pageicon">{'default'|lang}</th>
					<th class="pageicon">&nbsp;</th>
					<th class="pageicon">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$templates item=entry}
				<tr class="{cycle values='row1,row2' name='summary'}">
					<td>{$entry->link}</td>
					<td>{$entry->default}</td>
					<td>{$entry->edit}</td>
					<td>{$entry->delete|default:''}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		{/if}

		<div class="pageoptions">{$addlinks.$section}</div>
	</fieldset>	
	
{/foreach}