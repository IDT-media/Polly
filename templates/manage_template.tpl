<!-- start tab -->
<div id="page_tabs">
	<div id="edittemplate">
		{$title}
	</div>
</div>
<!-- end tab //-->
<!-- start content -->
<div id="page_content"> 
	<div id="edittemplate_c"> 
	<div id="edittemplate_result"></div>
	{$startform}

		<div class="pageoverflow">
    		<p class="pagetext">* {$mod->Lang('template')} {$mod->Lang('name')|strtolower}:</p>
    		<p class="pageinput">{$input_name}</p>
		</div>
		
		<div class="pageoverflow">
    		<p class="pagetext">{'default'|lang} {$mod->Lang('templates')|strtolower}:</p>
    		<p class="pageinput tpl_list">{$input_tpl_list}</p>
		</div>

		<div class="pageoverflow">
    		<p class="pagetext">{$mod->Lang('template')}:</p>
    		<div class="pageinput tpl_content">{$input_template}</div>
		</div>

		<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<p class="pageinput">
				<input name="{$actionid}submit" class="polly-submit" value="{lang('submit')}" type="submit" />
				<button name="{$actionid}operation" class="mod-button polly-cancel" data-ui-icon='ui-icon-circle-close' value="cancel" type="submit">{lang('cancel')}</button>
			</p>	
		</div>

	{$endform}
	</div>
</div>