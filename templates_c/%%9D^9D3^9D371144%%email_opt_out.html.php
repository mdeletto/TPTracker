<?php /* Smarty version 2.6.18, created on 2017-03-02 10:49:53
         compiled from xataface/modules/email/email_opt_out.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'xataface/modules/email/email_opt_out.html', 1, false),array('block', 'fill_slot', 'xataface/modules/email/email_opt_out.html', 2, false),array('modifier', 'escape', 'xataface/modules/email/email_opt_out.html', 4, false),)), $this); ?>
<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Main_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'html_body')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
		<div style="clear:both"></div>
		<div id="email-opt-out-wrapper" data-email-id="<?php echo ((is_array($_tmp=$this->_tpl_vars['emailId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['currentlyBlackListed']): ?>data-email-currently-blacklisted="1"<?php endif; ?>>
		
		
			<div class="slide opted-in" style="display:none">
				<h2>Email Notifications To <?php echo ((is_array($_tmp=$this->_tpl_vars['emailAddress'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
				<p>You are currently eligible to receive email notifications from us for the address <?php echo ((is_array($_tmp=$this->_tpl_vars['emailAddress'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
				<p>If you do not wish to receive email notifications, please click the button below.</p>
				<div class="buttons">
					<button class="opt-out">I Do Not Wish To Receive Email Notifications</button>
				</div>
			
			</div>
			
			
			<div class="slide opt-out-success" style="display:none">
				<h2>Thank You</h2>
				<p>You have been added to our "Do Not Send" list and will no longer receive email notifications from us.</p>
				<p>If you change your mind and you want to be able to receive email notifications from us, <a href="#" class="re-opt-in-link">click here</a>.</p>
				
			</div>
			
			<div class="slide opted-out" style="display:none">
				<h2>Email Notifications To <?php echo ((is_array($_tmp=$this->_tpl_vars['emailAddress'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
				<p>You are currently on our "Do Not Send" list.  This means that you will not receive email notifications
				from us.</p>
				<p>If you wish to receive email notifications from us, please click the button below.</p>
				<div class="buttons">
					<button class="opt-in">I Wish To Receive Email Notifications</button>
				</div>
			</div>
			
			<div class="slide opt-in-success" style="display:none">
			
				<h2>Thank You</h2>
				
				<p>You have been removed from our "Do Not Send" list so you are now eligible to receive email notifications from us.</p>
				<p>If you changed your mind and wish to re-add yourself to the "Do Not Send" list,  <a href="#" class="re-opt-out-link">click here</a>.</p>
			
			</div>
		
			
		
		
			
		
		</div>
	
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>