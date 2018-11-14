<?php
                                             
  /**
  * @package   Xataface LDAP authentication script
  * @author    Vihar Malviya
  * @version   See VERSION
  * @created   2014-09-13
  * @brief     This module extends Dataface to allow LDAP authentication
  * @copyright Copyright (C) 2015, Vihar Malviya
  *            under the GNU General Public License version 2
  * 
  * Requires at least
  * - phpldapauth >= v02.00.01
  * - phpdbauth   >= v02.02.01
  *
  */
  
  
  /**-------------------------------------------------------------------------------
  * Xataface LDAP authentication script
  * Copyright (C) 2015 Vihar Malviya
  * 
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License
  * along with this program; if not, write to the Free Software
  * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
  *-------------------------------------------------------------------------------
  **/
  
  /* Use $GLOBALS['bl_DebugSwitch'] for debugging */
  // $GLOBALS['bl_DebugSwitch'] = FALSE ;
 
  // This module requires the following parameters in /var/www/... .../application/conf.ini.
  // Optional parameters have been configured to default to a reference OpenLDAP directory configuration
  // [_auth]
  // auth_type = ldap                           // The authentication type to use
  // ldap_host = "ldapserver"                   // The host of the LDAP directory (optional, default = "localhost")
  // ldap_port = 389                            // The port at which the above host listens for directory connections (optional, default = 389)
  // ldap_version = 3                           // The LDAP protocol version to use (optional, default = 3)
  // ldap_type = "openldap"                     // The type of LDAP directory server (options: "openldap", "ad-ds", "ad-lds", default = "openldap")
  // ldap_userdomain = "COMPANY"                // User domain used for AD environments (use NetBios domain for AD DS and DNS domain for AD LDS, no default; ref. https://msdn.microsoft.com/en-us/library/cc223126.aspx#gt_2e72eeeb-aee9-4b0a-adc6-4476bacf5024)
  // ldap_base = "dc=example,dc=com"            // The base DN of the directory. If functionality to authenticate users of a certain directory 
                                                // group is required then do not include the organisational unit of users or groups.
                                                // specify these separate below.
  // ldap_groupname = "usersnormal"             // The name of the group whose member an authenticated user should be.
  // ldap_usernameattrib = "uid"                // The LDAP attribute corresponding to the username (optional, default = "uid")
  // ldap_groupnameattrib = "cn"                // The LDAP attribute corresponding to group name (optional, default = "cn")
  // ldap_groupmemberattrib = "memberuid"       // The LDAP attribute in groups showing member's usernames (optional, default = "memberuid")
  // ldap_usercontainerrdn = "ou=Users"         // Organisational unit under base DN containing the users (optional).
                                                // If not specified, the users will bind to the directory as per ldap_base specified above.
                                                // If not specified then ensure that ldap_usernameattrib + ldap_base forms user DN.
                                                // Otherwise user will not be authenticated.
  // ldap_groupcontainerrdn = "ou=Groups"       // Organisational unit under base DN containing the groups (optional).
                                                // If not specified, the groups will be searched in ldap_base specified above.
                                                // Not good if functionality to authenticate users of a certain directory group is required,
                                                // as groupname searches will yield more than one result for directories with groupnames matching
                                                // with usernames.
  // users_table = xata_users                   // The name of the table in the database containing the users
  // username_column = Username                 // The name of the column/field in users_table containing the usernames
  // role_column = "Role"                       // The name of the column in users_table containing the roles of users.
  // default_role = "READ ONLY"                 // The default role an authenticated user should be given if not found in users_table.
  

        
  /* Define dependencies */
  // library to authenticate against
  require_once (
    dirname(__FILE__) .
    DIRECTORY_SEPARATOR .
    'phpldapauth' .
    DIRECTORY_SEPARATOR .
    'phpldapauth.php'
  ) ;
  // library to verify user against database
  require_once (
    dirname(__FILE__) .
    DIRECTORY_SEPARATOR .
    'phpdbauth' .
    DIRECTORY_SEPARATOR .
    'phpdbauth.php'
  ) ;
    
  class dataface_modules_ldap {

    /**
     * Implementation of checkCredentials() hook.  This checks the 
     * credentials to see if the username/password combination are
     * correct.
     */




    function checkCredentials ( ) {

    

      $auth =& Dataface_AuthenticationTool::getInstance ( ) ;
      $app =& Dataface_Application::getInstance ( ) ;
      
      $creds = $auth -> getCredentials ( ) ;
      $creds['UserName'] = trim($creds['UserName']);
      $creds['Password'] = trim($creds['Password']);
      if (empty($creds['UserName']) or empty($creds['Password'])) {
        return false;
      }
      if ( ! isset ( $auth->conf['ldap_base'] ) ) {
        trigger_error ( 'Please specify the LDAP basedn in the [_auth] section of the conf.ini file.' , E_USER_ERROR ) ;
      }
      
      // Define request as an array
      $ar_Request = array (
        'ky_UserKeyword' => $creds['UserName'] ,
        'ky_UserPassword' => $creds['Password'] ,
        'ky_UserDomain' => $auth->conf['ldap_userdomain'] ,
        'ky_GroupKeyword' => $auth->conf['ldap_groupname'] ,
      ) ;

      
      // Define Directory configuration
      $ar_DirHost = array (
        'ky_Locn' => $auth->conf['ldap_host'] ,
        'ky_Port' => $auth->conf['ldap_port'] ,
      ) ;
      
      $ar_DirConf = array (
        'ky_LdapType'           => $auth->conf['ldap_type'] ,
        'ky_LdapVer'            => $auth->conf['ldap_version'] ,
        'ky_BaseDn'             => $auth->conf['ldap_base'] ,
        'ky_UsernameAttrib'     => $auth->conf['ldap_usernameattrib'] ,
        'ky_GroupnameAttrib'    => $auth->conf['ldap_groupnameattrib'] ,
        'ky_GroupMemberAttrib'  => $auth->conf['ldap_groupmemberattrib'] ,
        'ky_UserContainerRdn'   => $auth->conf['ldap_usercontainerrdn'] ,
        'ky_GroupContainerRdn'  => $auth->conf['ldap_groupcontainerrdn'] ,
        'ar_GroupSearchFilter'  => array (
          'objectClass=posixGroup' ,
          'objectClass=sambaGroupMapping'
        )
      ) ;

      // Specify data table parameters
      $var__Table = array (
        "key__Table_Name"             => $auth->conf["users_table"] ,
        "key__Table_ColumnUsername"   => $auth->conf["username_column"] ,
        "key__Table_ColumnRole"       => $auth->conf["role_column"] ,
        "key__Table_DefaultRoleValue" => $auth->conf["default_role"] ,
      ) ;

      $var__Database_Connection [ "key__DatabaseConnection_Object" ] = df_db() ;

      // Normalise the group search keyword for later use
      if ( array_key_exists ( 'ky_GroupKeyword' , $ar_Request ) ) {
        if ( is_null ( $ar_Request['ky_GroupKeyword'] ) | ! $ar_Request['ky_GroupKeyword'] == '' ) {
        } else {
          $ar_Request['ky_GroupKeyword'] = NULL ;
        }
      } else {
        $ar_Request['ky_GroupKeyword'] = NULL ;
      }

      /* Authenticate with directory */
      // Create Directory object
      $ob_Dir = new cl_Dir($ar_DirHost,$ar_DirConf) ;
      // Call authentication function
      $ar_AuthResult = $ob_Dir->fn_Auth($ar_Request) ;
      // Destroy directory object
      unset($ob_Dir) ;
      
      // Destroy user password from the working variable
      $ar_Request['ky_UserPassword'] = NULL ;

      // Check success of authentication
      if ( $ar_AuthResult['ky_User_Authenticated'] == TRUE ) {
        // If authenticated then check if group is specified or group membership is correct
        if ( is_null ( $ar_Request['ky_GroupKeyword'] ) | $ar_AuthResult['ky_Group_ContainsUser'] == TRUE ) {

          // If authenticated, then call the database function.
          $var__Database_VerificationSummary = fn__Database_Verify ( $ar_Request , $var__Table , "mysql" , NULL , $var__Database_Connection ) ;

          // Check if the user was found in users_table or added to users_table. Can't be both.
          if ( $var__Database_VerificationSummary [ "key__Database_UserFound" ] == TRUE ^ $var__Database_VerificationSummary [ "key__Database_UserAdded" ] == TRUE ) {

            // User authenticated by directory; and either found in users_table or added to it.
            return TRUE ;
          } else {

            // User authenticated, and not found in users_table, but could not be added to it.
            return FALSE ;
          }
        } else {
          
          // User not member of specified group
          return FALSE ;
        }
      } else {
      
      // User not authenticated by the directory service
	return FALSE;
      }
    }


    
  }
?>
