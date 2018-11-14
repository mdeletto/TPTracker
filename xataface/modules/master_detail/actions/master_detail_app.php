<?php
class actions_master_detail_app {
	function handle($params){
		$mod = Dataface_ModuleTool::getInstance()
			->loadModule('modules_master_detail');
		$mod->addPaths();
		
		$js = Dataface_JavascriptTool::getInstance()
			->import('master_detail/app.js');
			
		df_display(array(), 'master_detail/main.html');
	}
}