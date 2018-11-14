<?php /* Smarty version 2.6.18, created on 2017-02-28 12:33:48
         compiled from actions_manage_migrate.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'actions_manage_migrate.html', 1, false),array('block', 'fill_slot', 'actions_manage_migrate.html', 3, false),array('block', 'translate', 'actions_manage_migrate.html', 5, false),array('modifier', 'count', 'actions_manage_migrate.html', 12, false),)), $this); ?>
<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Main_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'main_section')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	
		<h1><?php $this->_tag_stack[] = array('translate', array('id' => "templates.actions_manage_migrate.HEADING_MIGRATION_MANAGER")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			Migration Manager
			<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		</h1>
		<p><?php $this->_tag_stack[] = array('translate', array('id' => "templates.actions_manage_migrate.INSTRUCTIONS")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>This page allows you to migrate data from old versions of Dataface to your current version.  
		Select the migrations you wish to perform below and submit the form.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></p>
		<hr/>
		<?php if (count($this->_tpl_vars['migrations']) > 0): ?>
			<form method="post" action="<?php echo $this->_tpl_vars['ENV']['DATAFACE_SITE_HREF']; ?>
">
			<input type="hidden" name="-action" value="manage_migrate" />
			<dl>
			<?php $_from = $this->_tpl_vars['migrations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['migration']):
?>
				<dt><input type="checkbox" name="modules[<?php echo $this->_tpl_vars['key']; ?>
]" value="1" checked /><?php echo $this->_tpl_vars['key']; ?>
:</dt><dd><?php echo $this->_tpl_vars['migration']; ?>
</dd>
			<?php endforeach; endif; unset($_from); ?>
			</dl>
			
			<input type="submit" value="<?php $this->_tag_stack[] = array('translate', array('id' => "templates.actions_manage_migrate.LABEL_PERFORM_MIGRATIONS")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Perform selected migrations<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>" />
			</form>
		<?php else: ?>
			<p><?php $this->_tag_stack[] = array('translate', array('id' => "templates.actions_manage_migrate.MESSAGE_NO_MIGRATIONS")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
				There are currently no migrations to be performed.
			<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></p>
		<?php endif; ?>
		
		<?php if (count($this->_tpl_vars['log']) > 0): ?>
			<h2>Migration Results</h2>
			<dl>
			<?php $_from = $this->_tpl_vars['log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['entry']):
?>
				<dt><?php echo $this->_tpl_vars['key']; ?>
</dt>
				<dd>
					<ul>
					<?php $_from = $this->_tpl_vars['entry']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lineitem']):
?>
						<li><?php echo $this->_tpl_vars['lineitem']; ?>
</li>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
				</dd>
			<?php endforeach; endif; unset($_from); ?>
			</dl>
		<?php endif; ?>
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>