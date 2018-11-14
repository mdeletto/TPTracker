<?php /* Smarty version 2.6.18, created on 2017-02-28 11:37:57
         compiled from Dataface_Details_Controller.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'translate', 'Dataface_Details_Controller.html', 21, false),array('function', 'prev_link', 'Dataface_Details_Controller.html', 26, false),array('function', 'next_link', 'Dataface_Details_Controller.html', 30, false),array('function', 'actions_menu', 'Dataface_Details_Controller.html', 34, false),)), $this); ?>
	<div class="result-stats details-stats">
		<span class="cursor"><?php echo $this->_tpl_vars['ENV']['resultSet']->cursor()+1; ?>
</span> <?php $this->_tag_stack[] = array('translate', array('id' => "single_words.of")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>of<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> <span class="found"><?php echo $this->_tpl_vars['ENV']['resultSet']->found(); ?>
</span>
			
	</div>

	<div class="prev-link">
		<?php echo $this->_plugins['function']['prev_link'][0][0]->prev_link(array(), $this);?>

	</div>
	
	<div class="next-link">
		<?php echo $this->_plugins['function']['next_link'][0][0]->next_link(array(), $this);?>

	</div>
	
	<div class="record-details-actions">
		<?php echo $this->_plugins['function']['actions_menu'][0][0]->actions_menu(array('id' => "record-details-actions",'id_prefix' => "record-details-actions-",'class' => "icon-only",'category' => 'record_details_actions'), $this);?>

	</div>