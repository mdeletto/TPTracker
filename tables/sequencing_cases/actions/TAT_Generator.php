<?php

class tables_sequencing_cases_actions_TAT_Generator {
    function handle(&$params){
        $app =& Dataface_Application::getInstance();
	$cmd = "/var/www/TPL/TPTracker/bin/TAT_Generator.R";
	$cmd_output = shell_exec("Rscript"." ".$cmd);
	header("Location: http://10.71.30.46/tmp/TAT.png");
	echo $cmd_output;
	//$tmp_file = "/var/www/TPL/TPTracker/Rplots.pdf";
	echo file_get_contents($tmp_file);
    }
}
/*
class actions_TAT_Generator {
    function handle(&$params){
        $app =& Dataface_Application::getInstance();
	$cmd = "/var/www/TPL/TPTracker/bin/TAT_Generator.R";
	$cmd_output = shell_exec($cmd);
	$tmp_file = "/var/www/TPL/tmp/TAT.html";
	echo $tmp_file;
    }
}
*/
