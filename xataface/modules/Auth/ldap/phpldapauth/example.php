<?php
  /* Include the phpLDAPauth library (also automatically includes the debuggin library) */
  require_once ( realpath ( __DIR__ . DIRECTORY_SEPARATOR . 'phpldapauth.php' ) ) ;

  /* Define directory host array */
  $ar_DirHost = array (
   'ky_Locn' => 'localhost' ,
   'ky_Port' => '389'
  ) ;
  
  /* Define directory configuration array */
  $ar_DirConf = array (
   'ky_LdapType'           => 'openldap' ,
   'ky_LdapVer'            => 3 ,
   'ky_LdapFollowReferral' => FALSE ,
   'ky_BaseDn'             => NULL ,
   'ky_UsernameAttrib'     => 'uid' ,
   'ky_GroupnameAttrib'    => 'cn' ,
   'ky_GroupMemberAttrib'  => 'memberuid' ,
   'ky_UserContainerRdn'   => 'ou=Users' ,
   'ky_GroupContainerRdn'  => 'ou=Groups' ,
   'ar_GroupSearchFilter'  => array (
     'objectClass=posixGroup' ,
     'objectClass=sambaGroupMapping'
   )
  ) ;

  $ar_Request = array (
    'ky_UserKeyword'  => 'username' ,
    'ky_UserPassword' => 'password' ,
    'ky_UserDomain'   => 'DOMAIN' ,
    'ky_GroupKeyword' => 'usersgroup'
  ) ;

  /* Create phpLDAPauth object */
  $ob_Dir = new cl_Dir ( $ar_DirHost , $ar_DirConf ) ;

  /* Call the authentication function and store the result */
  $ar_AuthResult = $ob_Dir->fn_Auth ( $ar_Request ) ;

  /* Destroy user password from the working variable */
  $ar_Request['ky_UserPassword'] = NULL ;

  if ( $ar_AuthResult['ky_User_Authenticated'] === TRUE ) {
    echo ( 'User ' . $ar_Request['ky_UserKeyword'] . ' logged in' ) ;
  } else {
    echo ( 'Username or Password is invalid' ) ;
  }
?>