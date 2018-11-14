<?php /* Smarty version 2.6.18, created on 2017-02-28 13:28:31
         compiled from manage_build_index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'manage_build_index.html', 1, false),array('block', 'fill_slot', 'manage_build_index.html', 3, false),)), $this); ?>
<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Main_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'main_section')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<h2>Build Index</h2>
		<div class="formHelp">
			<p>This form allows you to index the tables in your database so that
			   they will be searchable using Dataface's full-text natural language
			   search.
			</p>
			<p>Generally you only want tables that you consider to be entities to be 
			searchable.  You usually won't want to index your join tables, nor will
			you want to index supplementary tables like Dataface's __history tables.
			</p>
			<p>Before you can index your tables, you must enable indexing in the 
			conf.ini file and indicate there which tables are allowed to be indexed.
			You can do this by adding an [_index] section to your conf.ini file as
			follows:
			</p>
			<p>
				<code><pre>
[_index]
People=1
Users=1
News=1
				</pre></code>
			</p>
			<p>The above example would enable indexing on the People, Users, and News
			tables.</p>
				
		</div>
		<form action="<?php echo $this->_tpl_vars['ENV']['DATAFACE_SITE_HREF']; ?>
" method="post">
		<label>Select tables to be indexed:<select size="20" name="--tables[]" multiple>
		<?php $_from = $this->_tpl_vars['tables']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['table']):
?>
			<option value="<?php echo $this->_tpl_vars['table']; ?>
"><?php echo $this->_tpl_vars['table']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select></label>
		<label>Clear then rebuild<input type="checkbox" name="--clear"/></label>
		<input type="submit" name="--submit-now" value="Rebuild index now"/>
		<input type="hidden" name="--build-index" value="1"/>
		<input type="hidden" name="-action" value="manage_build_index"/>
		</form>
		
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>