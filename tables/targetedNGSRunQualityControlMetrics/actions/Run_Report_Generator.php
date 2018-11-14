<?php
class actions_Run_Report_Generator {
    function handle(&$params){
        $app =& Dataface_Application::getInstance();
        $query =& $app->getQuery();
	$query['-limit'] = 1;        

	if ( $query['-table'] != 'targetedNGSRunQualityControlMetrics' ){
            return PEAR::raiseError('This action can only be used on the targetedNGSRunQualityControlMetrics table');
        }


	$record = df_get_record('targetedNGSRunQualityControlMetrics', $query);
	$cmd = "/var/www/TPL/TPTracker/bin/match_run_report_generator.py"." ".$record->htmlValue('resultName')." "."'".$record->htmlValue('instrumentName')."'";
	$run_report_generator_output = shell_exec($cmd);
	echo $run_report_generator_output;
    }
}
