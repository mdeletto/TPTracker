<?php
  
  if ( ! function_exists ( 'fn_LoadDebugger' ) ) {
    function fn_LoadDebugger () {
      require_once (
        realpath (
          dirname(__FILE__) .
          DIRECTORY_SEPARATOR .
          'kint' .
          DIRECTORY_SEPARATOR .
          'Kint.class.php'
        )
      ) ;
      ini_set('log_errors', 'on') ;
      ini_set('display_errors', 'on') ;
      ini_set('display_startup_errors', 'on') ;
      ini_set('error_reporting', '-1') ;
      error_reporting ( E_ALL ) ;
      error_reporting ( -1 ) ;
      error_reporting ( E_ALL | E_STRICT ) ;
    }
  }
  
  if ( ! function_exists ( 'fn_StrObfuscate' ) ) {
    function fn_StrObfuscate($ag_StringIn) {
//    if(is_string($ag_StringIn)) {
        if ( function_exists('password_hash') ) {
          return password_hash ( $ag_StringIn , PASSWORD_BCRYPT ) ;
        } elseif ( function_exists('crypt') ) {
          return crypt($ag_StringIn) ;
        } else {
          return hash ( 'whirlpool' , $ag_StringIn ) ;
        }
//    } else {
//      trigger_error ( 'Cannot obfuscate non-string' , E_USER_ERROR ) ;
//    }
    }
  }
  
  if ( ! function_exists('fn_ArrRecurse') ) {
    function fn_ArrRecurse ( array &$ag_InArray , $ag_ItemKey ) {
      return array_walk_recursive (
        $ag_InArray ,
        function ( &$vr_Item , $ky_Item , $ag_ag_ItemKey ) {
          if ( strcmp ( $ky_Item , $ag_ag_ItemKey ) == 0 ) {
            $vr_Item = fn_StrObfuscate($vr_Item) ;
          }
        } ,
        $ag_ItemKey
      ) ;
    }
  }
  
  if ( ! function_exists('fn_Debug') ) {
    function fn_Debug (
      $ag_DebugMessage = '' ,     // Simple string describing what is being debugged.
      $ag_DebugOutput = NULL ,    // actual output to debug, mixed. this is passed to Kint.
      $ag_DebugObfuscate = NULL , // name of key to obfuscate if $ag_DebugOutput is array, any non-null (even '') if it is a string.
      $ag_DebugSwitch = NULL ,    // over-ride global debug switch
      $ag_ErrorTrigger = NULL     // debug output as a trigger_error if the parent framework suppresses Kint.
    ) {
      if(is_null($ag_DebugSwitch)) {
        if ( ! is_null($GLOBALS['bl_DebugSwitch']) ) {
          $ag_DebugSwitch = $GLOBALS['bl_DebugSwitch'] ;
        } else {
          $ag_DebugSwitch = FALSE ;
        }
      }
      
      if ( $ag_DebugSwitch === TRUE ) {
        if ( ! class_exists ( 'Kint' , FALSE ) ) {
          fn_LoadDebugger() ;
        }
        echo ('<hr />'.$ag_DebugMessage.'<br />') ;
        if ( ! is_null($ag_DebugObfuscate) ) {
          if ( is_string($ag_DebugOutput) ) {
            $ag_DebugOutput = fn_StrObfuscate($ag_DebugOutput) ;
          } elseif ( is_array($ag_DebugOutput) ) {
            if ( ! fn_ArrRecurse ( $ag_DebugOutput , $ag_DebugObfuscate ) ) {
              trigger_error (
                'Could not find specified array key, output not obfuscated. Sensitive data may be exposed.' ,
                E_USER_ERROR
              ) ;
            }
          }
        }
        if(!is_null($ag_DebugOutput)) +s($ag_DebugOutput) ;
        echo('<hr />') ;
        if ( $ag_ErrorTrigger === TRUE ) {
          trigger_error ( $ag_DebugOutput , E_USER_ERROR ) ;
        }
      }
    }
  }
  
  if ( $GLOBALS['bl_DebugSwitch'] === TRUE ) fn_LoadDebugger() ;
  
?>