<?php /* Smarty version 2.6.18, created on 2017-04-19 14:49:44
         compiled from email_form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'email_form.html', 20, false),array('block', 'fill_slot', 'email_form.html', 22, false),array('block', 'translate', 'email_form.html', 32, false),array('block', 'define_slot', 'email_form.html', 34, false),array('function', 'block', 'email_form.html', 33, false),)), $this); ?>
<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Main_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'main_section')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['ENV']['DATAFACE_URL']; ?>
/js/ajaxgold.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['EMAIL_ROOT']; ?>
/js/email_form.js"></script>
		
		<h1 style="clear:both">Send Email to Found Set</h1>
		<p>Please complete the form below to send email to the <?php echo $this->_tpl_vars['ENV']['resultSet']->found(); ?>
 addresses
		associated with the current found set.  <a href="#" onclick="Xataface.showEmailAddresses('<?php echo $this->_tpl_vars['querystr']; ?>
');">Show Email Addresses</a>.
			<div id="email-addresses">&nbsp;</div>
		</p>
		
		<?php if ($this->_tpl_vars['error']): ?><div id="error"><?php $this->_tag_stack[] = array('translate', array('id' => $this->_tpl_vars['error_i18n'])); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php echo $this->_tpl_vars['error']; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></div><?php endif; ?>
		<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => 'before_email_form'), $this);?>

		<?php $this->_tag_stack[] = array('define_slot', array('name' => 'email_form')); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<div class="email-form-wrapper">
			<?php echo $this->_tpl_vars['email_form']; ?>

		</div>
		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
		<?php echo $this->_plugins['function']['block'][0][0]->block(array('name' => 'after_email_form'), $this);?>

	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>