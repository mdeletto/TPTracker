<?php
class tables_GENIESex {
    function getPermissions($record){
        $user = Dataface_AuthenticationTool::getInstance()->getLoggedInUser();
        if ( $user ){
        // Other logged in users have read only access
            $perms = Dataface_PermissionsTool::READ_ONLY();
            return $perms;
	}
    }
}
?>
