<?php

class tables_AACRGenie{

	function css__tableRowClass(&$record){ 
	    if ( $record->val('GENIEstage') == 'ERROR-I' ){
		return 'error';
	    } elseif ( $record->val('GENIEstage') == 'HOLD' || $record->val('GENIEstage') == 'REVIEW' ){ 
		return 'hold'; 
	    } 
	    else return ''; 
	   }


    function beforeInsert(&$record)
    {
        $auth =& Dataface_AuthenticationTool::getInstance();
        $username =& $auth->getLoggedInUsername();
        $record->setValue('creator', $username);
        $record->setValue('modifier', $username);
    }
    
    
    function beforeUpdate(&$record)
    {
        // Track modifier
        $auth =& Dataface_AuthenticationTool::getInstance();
        $username =& $auth->getLoggedInUsername();
        if ($username)
            $record->setValue('modifier', $username);
    }

     function getPermissions(&$record){
         $auth =& Dataface_AuthenticationTool::getInstance();
         $user =& $auth->getLoggedInUser();
         if ( !isset($user) ) return Dataface_PermissionsTool::NO_ACCESS();
             // if the user is null then nobody is logged in... no access.
             // This will force a login prompt.
         $role = $user->val('Role');
	 if ($role=='MASTER'){
		return Dataface_PermissionsTool::getRolePermissions($role);
        } elseif ($role=='GENIE' or $role=='GENIE-D' or $role=='LABDIR') {
		return Dataface_PermissionsTool::getRolePermissions($role);
	}
	else{
		return Dataface_PermissionsTool::READ_ONLY();
	}
             // Returns all of the permissions for the user's current role.
      }


}
?>
