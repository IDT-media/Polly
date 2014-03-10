{$startform}
<fieldset>
	<legend>{$Polly->Lang('module_options')}</legend>
	<div class="pageoverflow">
	    <p class="pagetext">{$Polly->Lang('prompt_adminsection')}:</p>
	    <p class="pageinput">{$input_adminsection}</p>
	</div>
</fieldset> 
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">
		<input name="{$actionid}submit" id="submit" value="{lang('submit')}" type="submit" />
	</p>
</div>
{$endform}
