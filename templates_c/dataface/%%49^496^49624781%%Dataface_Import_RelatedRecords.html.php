<?php /* Smarty version 2.6.18, created on 2014-12-22 11:40:05
         compiled from Dataface_Import_RelatedRecords.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'Dataface_Import_RelatedRecords.html', 20, false),array('block', 'fill_slot', 'Dataface_Import_RelatedRecords.html', 21, false),array('block', 'translate', 'Dataface_Import_RelatedRecords.html', 23, false),array('block', 'define_slot', 'Dataface_Import_RelatedRecords.html', 82, false),array('modifier', 'count', 'Dataface_Import_RelatedRecords.html', 30, false),array('modifier', 'addslashes', 'Dataface_Import_RelatedRecords.html', 67, false),array('function', 'block', 'Dataface_Import_RelatedRecords.html', 80, false),)), $this); ?>
<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Record_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'record_content')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

		<h2><?php $this->_tag_stack[] = array('translate', array('id' => "templates.Dataface_Import_Related_Records.HEADING_IMPORT_RECORDS_FORM")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			Import Records Form
			<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h2>
		<p><?php $this->_tag_stack[] = array('translate', array('id' => "templates.Dataface_Import_Related_Records.MESSAGE_INTRO")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			This form allows you to import records into the current table
			<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></p>
		
		<?php if (count($this->_tpl_vars['filters']) > 0 || $this->_tpl_vars['step'] != 1): ?>
				<?php if (count($this->_tpl_vars['filters']) > 0): ?>
				<div id="import-filter-help">
				<h3><?php $this->_tag_stack[] = array('translate', array('id' => "templates.Dataface_Import_Related_Records.HEADING_INSTRUCTIONS")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
					Instructions
					<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h3>
				<p><?php $this->_tag_stack[] = array('translate', array('id' => "templates.Dataface_Import_Related_Records.P_INSTRUCTIONS_1")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
					Select the appropriate import format from the select list, paste the appropriate
				   data to be imported into the text area or select a file to upload that contains
				   the data to be imported.
				   <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
				</p>
				<p>
					<?php $this->_tag_stack[] = array('translate', array('id' => "templates.Dataface_Import_Related_Records.P_INSTRUCTIONS_2")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
					Be sure that the data being imported is in the correct format or the
				   import may fail.
				   <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
				 </p>
				 
				 <h4><?php $this->_tag_stack[] = array('translate', array('id' => "templates.Dataface_Import_Related_Records.HEADING_IMPORT_SPECIFIC_INSTRUCTIONS")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
				 Import Format Specific Instructions:
				 <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h4>
				 <div id="import-filter-description">
				 
				 </div>
			
				</div>
			<?php echo '
				<script language="javascript"><!--
				
			'; ?>

			var filterDiv = document.getElementById('import-filter-description');
			filterDiv.__filter_descriptions = <?php echo '{};'; ?>

			
			<?php $_from = $this->_tpl_vars['filters']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['filterName']):
?>
				
				
				filterDiv.__filter_descriptions['<?php echo ((is_array($_tmp=$this->_tpl_vars['filterName'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : addslashes($_tmp)); ?>
'] = "<?php $this->_tag_stack[] = array('translate', array('id' => "import_filters:".($this->_tpl_vars['filterName']).":help")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>No description available for this import filter.  Please add a filter description to your language config files ask key <em>import_filters:<?php echo $this->_tpl_vars['filterName']; ?>
:help</em><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>";
			
			<?php endforeach; endif; unset($_from); ?>
			
			<?php echo '
				
				function updateFilterDescription(filterName){
					var filterDiv = document.getElementById(\'import-filter-description\');
					filterDiv.innerHTML = filterDiv.__filter_descriptions[filterName];
				}
				//--></script>
			'; ?>

			<?php endif; ?>
				<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => 'before_import_related_records_form'), $this);?>

				<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => "before_import_related_".($this->_tpl_vars['ENV']['relationship'])."_form"), $this);?>

				<?php $this->_tag_stack[] = array('define_slot', array('name' => "import_related_".($this->_tpl_vars['ENV']['relationship'])."_form")); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
				<?php $this->_tag_stack[] = array('define_slot', array('name' => 'import_related_records_form')); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
						<div id="import-records-form">
				<?php echo $this->_tpl_vars['form']; ?>

				</div>
				<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
				<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
				<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => "after_import_related_".($this->_tpl_vars['ENV']['relationship'])."_form"), $this);?>

				<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => 'after_import_related_records_form'), $this);?>

		<?php else: ?>
		
		<p><img src="<?php echo $this->_tpl_vars['ENV']['DATAFACE_URL']; ?>
/images/exclamation.gif"> <?php $this->_tag_stack[] = array('translate', array('id' => "templates.Dataface_Import_Related_Records.MESSAGE_NO_IMPORT_FILTERS_DEFINED")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>No import filters were defined for this table.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></p>
		<?php endif; ?>
		
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>