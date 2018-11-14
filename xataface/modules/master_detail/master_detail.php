<?php
class modules_master_detail {
	/**
	 * @brief The base URL to the datepicker module.  This will be correct whether it is in the 
	 * application modules directory or the xataface modules directory.
	 *
	 * @see getBaseURL()
	 */
	private $baseURL = null;
	/**
	 * @brief Returns the base URL to this module's directory.  Useful for including
	 * Javascripts and CSS.
	 *
	 */
	public function getBaseURL(){
		if ( !isset($this->baseURL) ){
			$this->baseURL = Dataface_ModuleTool::getInstance()->getModuleURL(__FILE__);
		}
		return $this->baseURL;
	}
	
	private $pathsAdded = false;
	public function addPaths(){
		if ( !$this->pathsAdded ){
			$this->pathsAdded = true;
			Dataface_JavascriptTool::getInstance()->addPath(
				dirname(__FILE__).'/js',
				$this->getBaseURL().'/js'
			);
			Dataface_CSSTool::getInstance()->addPath(
				dirname(__FILE__).'/css',
				$this->getBaseURL().'/css'
			);
			df_register_skin('master_detail', dirname(__FILE__).'/templates');

		}

	}

}