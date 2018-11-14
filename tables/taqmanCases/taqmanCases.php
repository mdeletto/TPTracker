<?php
class tables_taqmanCases
{
    
    function default_sort()
    {
        if (!isset($_REQUEST['-sort']) and @$_REQUEST['-table'] == 'taqmanCases') {
            $_REQUEST['-sort'] = $_GET['-sort'] = 'req_date desc';
        }
    }
    
   /*function __sql__()
    {
        return "select t1.*,concat(t2.emailAddress) as emailAddress from sequencing_cases t1 left join emailGroups t2 on t1.emailGroup = t2.emailGroupName";
    }
  */

    
    function beforeInsert(&$record)
    {
        $auth =& Dataface_AuthenticationTool::getInstance();
        $username =& $auth->getLoggedInUsername();
        $record->setValue('creator', $username);
        $record->setValue('modifier', $username);
	$record->setValue('name',  preg_replace("%(?<!\\\\)'%", "\\'", $record->val('name'))); 
    }
    
    
    function beforeUpdate(&$record)
    {
        // Track modifier
        $auth =& Dataface_AuthenticationTool::getInstance();
        $username =& $auth->getLoggedInUsername();
        if ($username)
            $record->setValue('modifier', $username);
	$record->setValue('name',  preg_replace("%(?<!\\\\)'%", "\\'", $record->val('name')));
    }

    function highPriority__renderCell(&$record){

        if ( $record->val('highPriority') == 1 ){
                return '<font color="red" size="+1"><b><center>&#9745</center></b></font>';
        }
    }
    
    
    function highPriority__htmlValue(&$record){

        if ( $record->val('highPriority') == 1 ){
                return '<font color="red" size="+1"><b>&#9745</b></font>';
        }
    }

    function name__renderCell(&$record){
	return str_replace("\\", "", $record->val('name'));

    }

    function name__htmlValue(&$record){
        return str_replace("\\", "", $record->val('name'));

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
