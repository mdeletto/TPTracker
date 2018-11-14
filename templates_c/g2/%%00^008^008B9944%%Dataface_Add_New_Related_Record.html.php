<?php /* Smarty version 2.6.18, created on 2017-06-07 12:47:35
         compiled from Dataface_Add_New_Related_Record.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_record', 'Dataface_Add_New_Related_Record.html', 20, false),array('function', 'block', 'Dataface_Add_New_Related_Record.html', 23, false),array('function', 'actions_menu', 'Dataface_Add_New_Related_Record.html', 31, false),array('block', 'use_macro', 'Dataface_Add_New_Related_Record.html', 21, false),array('block', 'fill_slot', 'Dataface_Add_New_Related_Record.html', 22, false),array('block', 'define_slot', 'Dataface_Add_New_Related_Record.html', 25, false),array('block', 'translate', 'Dataface_Add_New_Related_Record.html', 41, false),array('modifier', 'escape', 'Dataface_Add_New_Related_Record.html', 40, false),)), $this); ?>
<?php echo $this->_plugins['function']['load_record'][0][0]->load_record(array(), $this);?>

<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Main_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'main_section')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => 'before_add_new_related_record_form'), $this);?>

		<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => "before_add_new_related_".($this->_tpl_vars['ENV']['relationship'])."_form"), $this);?>

		<?php $this->_tag_stack[] = array('define_slot', array('name' => "add_new_related_".($this->_tpl_vars['ENV']['relationship'])."_form")); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<?php $this->_tag_stack[] = array('define_slot', array('name' => 'add_new_related_record_form')); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		
		<?php ob_start(); ?>
			<div class="xf-button-bar">
				<div class="xf-button-bar-actions">
					<?php echo $this->_plugins['function']['actions_menu'][0][0]->actions_menu(array('category' => 'add_new_related_record_actions'), $this);?>

				</div>
				<div style="clear:both; height: 1px;"></div>
			</div>
			
		<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('new_related_record_button_bar', ob_get_contents());ob_end_clean(); ?>
		<?php echo $this->_tpl_vars['new_related_record_button_bar']; ?>

		<?php $this->assign('relationshipObject', $this->_tpl_vars['ENV']['table_object']->getRelationship($this->_tpl_vars['ENV']['relationship'])); ?>
		<h3>
		    <?php echo ((is_array($_tmp=$this->_tpl_vars['ENV']['record']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 &raquo; 
		    <?php $this->_tag_stack[] = array('translate', array('id' => 'add_new_x','x' => ((is_array($_tmp=$this->_tpl_vars['relationshipObject']->getSingularLabel())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		        Add New <?php echo ((is_array($_tmp=$this->_tpl_vars['relationshipObject']->getSingularLabel())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

		    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		</h3>
		<?php echo $this->_tpl_vars['form']; ?>

		
		<?php echo $this->_tpl_vars['new_related_record_button_bar']; ?>

		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => "after_add_new_related_".($this->_tpl_vars['ENV']['relationship'])."_form"), $this);?>

		<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => 'after_add_new_related_record_form'), $this);?>

	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>