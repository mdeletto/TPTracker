<?php

class tables_targetedNGSPipelineCommits{

     function getPermissions(&$record){
         $auth =& Dataface_AuthenticationTool::getInstance();
         $user =& $auth->getLoggedInUser();
         if ( !isset($user) ) return Dataface_PermissionsTool::NO_ACCESS();
             // if the user is null then nobody is logged in... no access.
             // This will force a login prompt.
         $role = $user->val('Role');
	 if ($role=='MASTER'){
		return Dataface_PermissionsTool::getRolePermissions($role);
        } 
	else{
		return Dataface_PermissionsTool::NO_ACCESS();
	}
             // Returns all of the permissions for the user's current role.
      }


}
?>
