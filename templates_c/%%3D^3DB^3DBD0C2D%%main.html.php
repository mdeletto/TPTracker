<?php /* Smarty version 2.6.18, created on 2017-06-07 13:10:13
         compiled from xataface/modules/summary/main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'xataface/modules/summary/main.html', 48, false),array('block', 'fill_slot', 'xataface/modules/summary/main.html', 50, false),array('modifier', 'escape', 'xataface/modules/summary/main.html', 52, false),array('modifier', 'count', 'xataface/modules/summary/main.html', 59, false),array('function', 'result_controller', 'xataface/modules/summary/main.html', 119, false),array('function', 'actions_menu', 'xataface/modules/summary/main.html', 122, false),)), $this); ?>
<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_List_View.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'result_list_content')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	
		<h2>Summary Reports for <?php echo ((is_array($_tmp=$this->_tpl_vars['table']->getLabel())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
	
		
		<?php $this->assign('currFilters', $this->_tpl_vars['self']->getCurrentFilters()); ?>
		
			<div class="query-browser">
				<p>This page summarizes the current result set (<?php echo $this->_tpl_vars['numResults']; ?>
 records) which includes the following searches:</p>
				<?php if (count($this->_tpl_vars['currFilters']) > 0): ?>
				<ul class="tagit">
					<?php $_from = $this->_tpl_vars['currFilters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['colname'] => $this->_tpl_vars['filter']):
?>
						<li class="tagit-choice" data-filter-field="<?php echo ((is_array($_tmp=$this->_tpl_vars['colname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['filter'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</li>
					<?php endforeach; endif; unset($_from); ?>
				
				</ul>
				
				<p><a href="<?php echo $this->_tpl_vars['ENV']['APPLICATION_OBJECT']->url('-action=find'); ?>
">Edit Search Terms...</a></p>
				
				<?php else: ?>
				
				<p><em>Currently there are no search terms. </em><a href="<?php echo $this->_tpl_vars['ENV']['APPLICATION_OBJECT']->url('-action=find'); ?>
">Edit Search Terms...</a></p>
				<?php endif; ?>
			</div>
		
	
		<fieldset>
		<legend>Report Options</legend>
		<div class="summary-group-by-columns-form">
			<select multiple="multiple">
				<?php $_from = $this->_tpl_vars['groupableFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
					<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['self']->isSelectedGroupField($this->_tpl_vars['key'])): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['field']['widget']['label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</div>
		
		
		
		<div class="summary-summarized-columns-form">
			<select multiple="multiple">
				<?php $_from = $this->_tpl_vars['summarizableFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
					<optgroup label="<?php echo ((is_array($_tmp=$this->_tpl_vars['field']['widget']['label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
						<?php $_from = $this->_tpl_vars['groupFuncs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['gkey'] => $this->_tpl_vars['func']):
?>
				
							<?php if ($this->_tpl_vars['self']->supports($this->_tpl_vars['key'],$this->_tpl_vars['gkey'])): ?>
								<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gkey'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
(<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
)" <?php if ($this->_tpl_vars['self']->isSelectedSummaryField($this->_tpl_vars['key'],$this->_tpl_vars['gkey'])): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['func']['label']; ?>
</option>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</optgroup>
				<?php endforeach; endif; unset($_from); ?>
				
				<optgroup label="Summary Fields">
					<?php $_from = $this->_tpl_vars['summaryFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
						<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['self']->isSelectedSummaryField($this->_tpl_vars['key'])): ?>selected<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['field']['widget']['label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
							
						
					<?php endforeach; endif; unset($_from); ?>
				</optgroup>
			
			</select>
		</div>
		
		<button id="refresh-button">Refresh Results</button>
		
		</fieldset>
		
		
		<?php if (count($this->_tpl_vars['rows']) > 0): ?>
		<?php if (count($this->_tpl_vars['rows']) > 29): ?>
			<?php echo $this->_plugins['function']['result_controller'][0][0]->result_controller(array(), $this);?>

		<?php endif; ?>
		<div class="result-list-actions summary-list-actions">
			<?php echo $this->_plugins['function']['actions_menu'][0][0]->actions_menu(array('id' => "result-list-actions",'id_prefix' => "result-list-actions-",'class' => "icon-only",'category' => 'summary_list_actions'), $this);?>

		</div>
		<div class="summary-results">
			<table class="xataface-summary-list listing">
				<thead>
					<tr>
					<?php if ($this->_tpl_vars['groupBy']): ?><?php $_from = $this->_tpl_vars['groupBy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['col']):
?>
						<th><?php echo ((is_array($_tmp=$this->_tpl_vars['self']->getFieldLabel($this->_tpl_vars['col']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
					<?php endforeach; endif; unset($_from); ?><?php endif; ?>
					<?php $_from = $this->_tpl_vars['self']->getSelectedSummaryColumns(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['col']):
?>
						<th><?php echo ((is_array($_tmp=$this->_tpl_vars['self']->getSummaryLabel($this->_tpl_vars['col']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
					<?php endforeach; endif; unset($_from); ?>
					</tr>
				</thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
						<tr>
							
							<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ckey'] => $this->_tpl_vars['cell']):
?>
								<td><?php echo ((is_array($_tmp=$this->_tpl_vars['self']->getCellValue($this->_tpl_vars['ckey'],$this->_tpl_vars['cell']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
							<?php endforeach; endif; unset($_from); ?>
						
						</tr>
					<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
		
		</div>
		<?php else: ?>
		
			<p>Please select some summary fields to display, then click "Refresh"</p>
		<?php endif; ?>
		
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>