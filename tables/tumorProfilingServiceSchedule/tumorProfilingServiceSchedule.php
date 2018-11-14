<?php
class tables_tumorProfilingServiceSchedule {

    function default_sort()
    {
        if (!isset($_REQUEST['-sort']) and @$_REQUEST['-table'] == 'tumorProfilingServiceSchedule') {
            $_REQUEST['-sort'] = $_GET['-sort'] = 'endDate desc';
        }
    }

        function beforeInsert(&$record){
                $auth =& Dataface_AuthenticationTool::getInstance();
                $username =& $auth->getLoggedInUsername();
                $record->setValue('creator', $username);
                $record->setValue('modifier', $username);
		$record->setValue('lastSyncUser', $username);
        }


        function beforeUpdate(&$record) {
            // Track modifier
            $auth =& Dataface_AuthenticationTool::getInstance();
            $username =& $auth->getLoggedInUsername();
            if ( $username ) $record->setValue('modifier', $username);
	    if ( $username ) $record->setValue('lastSyncUser', $username);
        }
    /**
     * Trigger that is called after Course record is inserted.
     * @param $record Dataface_Record object that has just been inserted.

    function afterInsert(&$record){
        mail("michael.d'eletto@ynhh.org",'Subject Line', 'Message body'); 
    }
    */
}
?>

