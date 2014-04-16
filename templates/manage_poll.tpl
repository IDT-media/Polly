{* HTML begins
**********************************************************}
<div id="polly-container">
{$startform}

{$mod->StartTabHeaders()}

	{$mod->SetTabHeader('main', $mod->Lang('main'))}
	{$mod->SetTabHeader('statistics', $mod->Lang('statistics'))}

{$mod->EndTabHeaders()}
{$mod->StartTabContent()}

	{$mod->StartTab('main')}

		<fieldset>
			<legend>{$mod->Lang('name')}</legend>
		
			<div class="pageoverflow">
				{*<p class="pagetext">{$mod->Lang('name')}:</p>*}
				<p class="pageinput">{$input_name}</p>
			</div>

		</fieldset>
		
		<fieldset class="polly-questions-section">
			<legend>{$mod->Lang('questions')}</legend>
		
			<div class="pageoverflow">
				{*<p class="pagetext">{$mod->Lang('questions')}:</p>*}
				<div class="pageinput" id="polly-options-container">
					<ul id="polly-options" data-polly-lang='{ldelim}"sort_drag":"{$mod->Lang('sort_drag')}","insert_question":"{$mod->Lang('insert_question')}","delete":"{$mod->Lang('delete')}"{rdelim}' data-polly-actionid='{$actionid}'>
					</ul>
					<input type="hidden" id="polly-data-values" name="{$actionid}options" value='{$item->options|json_encode|escape:'htmlall'}' />
				</div>
				<div class="pageinput polly-add-new">
					<button id="polly-add-new">{$mod->Lang('add_question')}</button>
				</div>
			</div>
		
		</fieldset>
		
	{$mod->EndTab()}

	{$mod->StartTab('statistics')}
	
		<h3>{$mod->Lang('statistic_title', $item->name)}</h3>
			<div class="pageoverflow">
				<script>
					var votes = [];
					
					{foreach $item->options as $option}{$votes = mt_rand(0, 500)}
					
						vote = ['{$option->data|escape:'quotes'}', {$votes}];
						votes.push(vote);
					{/foreach}
					
				</script>
				<div class="polly-vote-results-container">
					<div class="polly-vote-results" id="polly-pie-chart"></div>
				</div>
			</div>
	{$mod->EndTab()}
	
{$mod->EndTabContent()}

	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">
			<input name="{$actionid}submit" class="{$mod->GetName()|strtolower}-submit" value="{lang('submit')}" type="submit" />
			<input name="{$actionid}cancel" class="{$mod->GetName()|strtolower}-cancel" value="{lang('cancel')}" type="submit" />
			<input name="{$actionid}apply" class="{$mod->GetName()|strtolower}-apply" value="{lang('apply')}" type="submit" />
		</p>
	</div>
	
{$endform}
</div>