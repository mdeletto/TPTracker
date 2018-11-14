<?php /* Smarty version 2.6.18, created on 2018-01-02 08:54:02
         compiled from xataface/modules/email/manage.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'xataface/modules/email/manage.html', 1, false),array('block', 'fill_slot', 'xataface/modules/email/manage.html', 2, false),)), $this); ?>
<?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Main_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<?php $this->_tag_stack[] = array('fill_slot', array('name' => 'main_section')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	
		<h1>Email Management</h1>
		
		<div class="portalHelp">
			<p>This section allows you to manage the email module settings.  You can create email templates or manage your email black lists.</p>
			
		</div>
		<div>[<a href="<?php echo $this->_tpl_vars['ENV']['DATAFACE_SITE_HREF']; ?>
?-action=manage">Back to Control Panel</a>]</div>
		
		<ul>
			<li>
				<span class="icon"></span>
				<span class="title"><a href="<?php echo $this->_tpl_vars['ENV']['DATAFACE_SITE_HREF']; ?>
?-action=list&-table=xataface__email_newsletters&archive_category=1">View Email History</a></span>
				<span class="description">Browse through the history of sent emails.</span>
				
			</li>
		
			<li>
				<span class="icon"></span>
				<span class="title"><a href="<?php echo $this->_tpl_vars['ENV']['DATAFACE_SITE_HREF']; ?>
?-action=list&-table=xataface__email_templates">Manage Templates</a></span>
				<span class="description">Create templates that you can use to prepopulate emails that you send to your maillists.</span>
				
			</li>
			
			<li>
				<span class="icon"></span>
				<span class="title"><a href="<?php echo $this->_tpl_vars['ENV']['DATAFACE_SITE_HREF']; ?>
?-action=list&-table=dataface__email_blacklist">Manage Black List</a></span>
				<span class="description">The <em>Black List</em> is a list of users who have opted out of your maillist.</span>
			</li>
		
		</ul>
	<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>