<?php /* Smarty version 2.6.18, created on 2017-06-13 13:55:47
         compiled from xataface/RelatedList/forms/search_form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'translate', 'xataface/RelatedList/forms/search_form.html', 4, false),)), $this); ?>

<script language="javascript" src="<?php echo $this->_tpl_vars['ENV']['DATAFACE_URL']; ?>
/js/Dataface/RelatedList/search_form.js"></script>
<form action="#" method="get" onsubmit="return Dataface.RelatedList.processSearchForm(this);">
	<label for="related_find_query"><?php $this->_tag_stack[] = array('translate', array('id' => "scripts.Dataface_ResultList.MESSAGE_FILTER_RESULTS")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Filter Results:<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label> 
	<input type="text" name="related_find_query" value="<?php echo $this->_tpl_vars['ENV']['APPLICATION_OBJECT']->getQueryParam('related:search'); ?>
" />
	<input type="submit" name="filter" value="<?php $this->_tag_stack[] = array('translate', array('id' => "scripts.Dataface_ResultList.MESSAGE_FILTER_RESULTS_SUBMIT")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Filter<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>" />
</form>