<?php /* Smarty version 2.6.18, created on 2016-06-07 14:15:09
         compiled from Dataface_single_record_search.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'Dataface_single_record_search.html', 1, false),array('block', 'fill_slot', 'Dataface_single_record_search.html', 2, false),array('block', 'collapsible_sidebar', 'Dataface_single_record_search.html', 10, false),array('modifier', 'escape', 'Dataface_single_record_search.html', 3, false),array('modifier', 'count', 'Dataface_single_record_search.html', 7, false),)), $this); ?>
<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_View_Record.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'record_view_main_section')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<h3>Search results for <em>&quot;<?php echo ((is_array($_tmp=$this->_tpl_vars['queryString'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&quot;</em>
		<a title="Subscribe to an RSS feed of these results" href="<?php echo $this->_tpl_vars['ENV']['APPLICATION_OBJECT']->url(''); ?>
&--subsearch=<?php echo ((is_array($_tmp=$this->_tpl_vars['queryString'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&--format=RSS2.0"><img src="<?php echo $this->_tpl_vars['ENV']['DATAFACE_URL']; ?>
/images/feed-icon-14x14.png" alt="RSS" /></a>
		</h3>
		
		<?php if (count($this->_tpl_vars['results']) > 0): ?>
			<?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['relationship'] => $this->_tpl_vars['rows']):
?>
				
				<?php $this->_tag_stack[] = array('collapsible_sidebar', array('heading' => "<em>".($this->_tpl_vars['relationship'])."</em> Matches")); $_block_repeat=true;smarty_block_collapsible_sidebar($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
					<?php if (count($this->_tpl_vars['rows']) > 0): ?>
					<ol>
					<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
						<?php $this->assign('rowRecord', $this->_tpl_vars['row']->toRecord()); ?>
						<?php if ($this->_tpl_vars['rowRecord']->checkPermission('view')): ?>
							<li>
							
							
							<div><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['row']->getParentURL('-action=view_related_record'))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['rowRecord']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></div>
							<div><?php echo $this->_tpl_vars['rowRecord']->getDescription(); ?>
</div>
							</li>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					</ol>
					<?php else: ?>
						<p>No matching records in the <em><?php echo $this->_tpl_vars['relationship']; ?>
</em> relationship</p>
					<?php endif; ?>
				<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_collapsible_sidebar($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
				
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
			<p>No records matches your query.</p>
		<?php endif; ?>
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>