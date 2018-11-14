<?php /* Smarty version 2.6.18, created on 2017-07-13 16:38:12
         compiled from xataface/actions/show_hide_columns_panel.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'translate', 'xataface/actions/show_hide_columns_panel.html', 3, false),array('modifier', 'count', 'xataface/actions/show_hide_columns_panel.html', 11, false),array('modifier', 'escape', 'xataface/actions/show_hide_columns_panel.html', 12, false),)), $this); ?>
<div class="show-hide-columns-panel">
	
	<h2><?php $this->_tag_stack[] = array('translate', array('id' => "show_hide_columns.title")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Select Column Visibility<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h2>
	
	<p class="instructions">
		<?php $this->_tag_stack[] = array('translate', array('id' => "show_hide_columns.instructions")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		Check the boxes next to columns that you want to appear in the specified view.  Uncheck
		boxes next to columns you wish to hide.
		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
	</p>
	<?php if (count($this->_tpl_vars['fields']) > 0): ?>
		<table class="show-hide-columns-grid" data-table-name="<?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
			<thead>
				<tr>
					<th><?php $this->_tag_stack[] = array('translate', array('id' => "show_hide_columns.column_label")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Column<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
					<?php $_from = $this->_tpl_vars['visibility_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vtype']):
?>
						<th class="visibility-col"><?php echo ((is_array($_tmp=$this->_tpl_vars['vtype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
					<?php endforeach; endif; unset($_from); ?>
					<th>Record Data</th>
				</tr>
				<tr>
					<td>(Un)Select All &raquo;</td>
					<?php $_from = $this->_tpl_vars['visibility_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vtype']):
?>
						<th class="checkbox-col visibility-col">
							<input type="checkbox"
								class="select-all"
								id="select-all-<?php echo ((is_array($_tmp=$this->_tpl_vars['vtype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" 
								data-visibility-type="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
							/>
						</th>
					<?php endforeach; endif; unset($_from); ?>
					<th><!-- Record Data --></th>
				</tr>
			</thead>
			<tbody>
				<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field']):
?>
					<tr data-field-name="<?php echo ((is_array($_tmp=$this->_tpl_vars['field']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
						<th><?php echo ((is_array($_tmp=$this->_tpl_vars['field']['widget']['label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
						<?php $_from = $this->_tpl_vars['visibility_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vtype']):
?>
							<td class="checkbox-col visibility-col">
								<input type="checkbox"
									data-visibility-type="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
									data-field-name="<?php echo ((is_array($_tmp=$this->_tpl_vars['field']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
									<?php if ($this->_tpl_vars['self']->is_checked($this->_tpl_vars['field']['name'],$this->_tpl_vars['vtype'])): ?>
										checked="1"
									<?php endif; ?>
								/>
							</td>
						<?php endforeach; endif; unset($_from); ?>
						<td>
							<?php echo ((is_array($_tmp=$this->_tpl_vars['record']->preview($this->_tpl_vars['field']['name']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

						</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
			</tbody>
		</table>
	<?php endif; ?>
	<?php $_from = $this->_tpl_vars['relationships']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['relationship']):
?>
		<div class="relationship-show-hide-columns relationship-show-hide-columns-<?php echo ((is_array($_tmp=$this->_tpl_vars['relationship']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
			data-relationship-name="<?php echo ((is_array($_tmp=$this->_tpl_vars['relationship']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
		>
			<h3><?php echo ((is_array($_tmp=$this->_tpl_vars['relationship']['label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
			
			<table class="show-hide-columns-grid" data-table-name="<?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" data-relationship-name="<?php echo ((is_array($_tmp=$this->_tpl_vars['relationship']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
				<thead>
					<tr>
						<th><?php $this->_tag_stack[] = array('translate', array('id' => "show_hide_columns.column_label")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Column<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
						<?php $_from = $this->_tpl_vars['visibility_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vtype']):
?>
							<th class="visibility-col"><?php echo ((is_array($_tmp=$this->_tpl_vars['vtype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
						<?php endforeach; endif; unset($_from); ?>
						<th>Record Data</th>
					</tr>
					<tr>
						<td>(Un)Select All &raquo;</td>
						<?php $_from = $this->_tpl_vars['visibility_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vtype']):
?>
							<th class="checkbox-col visibility-col">
								<input type="checkbox"
									class="select-all"
									id="select-all-<?php echo ((is_array($_tmp=$this->_tpl_vars['vtype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" 
									data-visibility-type="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
								/>
							</th>
						<?php endforeach; endif; unset($_from); ?>
						<th><!-- Record Data --></th>
					</tr>
				</thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['relationship']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_name'] => $this->_tpl_vars['field']):
?>
						<tr data-field-name="<?php echo ((is_array($_tmp=$this->_tpl_vars['field']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
							<th><?php echo ((is_array($_tmp=$this->_tpl_vars['field']['widget']['label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
							<?php $_from = $this->_tpl_vars['visibility_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vtype']):
?>
								<td class="checkbox-col visibility-col">
									<input type="checkbox"
										data-visibility-type="<?php echo ((is_array($_tmp=$this->_tpl_vars['vtype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
										data-field-name="<?php echo ((is_array($_tmp=$this->_tpl_vars['field_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
										<?php if ($this->_tpl_vars['self']->is_checked($this->_tpl_vars['field_name'],$this->_tpl_vars['vtype'])): ?>
											checked="1"
										<?php endif; ?>
									/>
								</td>
							<?php endforeach; endif; unset($_from); ?>
							<td>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['record']->preview($this->_tpl_vars['field_name']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

							</td>
						</tr>
					<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
			
		</div>
	<?php endforeach; endif; unset($_from); ?>
	
	<div class="buttons">
		<button class="save">Save Changes</button>
	</div>	

</div>