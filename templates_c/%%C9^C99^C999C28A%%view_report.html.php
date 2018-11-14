<?php /* Smarty version 2.6.18, created on 2017-06-06 16:21:20
         compiled from xataface/modules/htmlreports/view_report.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'xataface/modules/htmlreports/view_report.html', 4, false),)), $this); ?>
<!doctype html>
<html>
	<head>
		<title><?php echo ((is_array($_tmp=$this->_tpl_vars['report']->val('actiontool_label'))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</title>
		<style type="text/css">
			<?php echo $this->_tpl_vars['report']->val('template_css'); ?>

		</style>
	</head>
	<body>
	
		<?php echo $this->_tpl_vars['html']; ?>

	</body>


</html>