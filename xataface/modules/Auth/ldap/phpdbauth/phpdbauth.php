<?php
  /**
  * 
  * @package   phpDBauth
  * @version   Refer to VERSION
  * @author    Vihar Malviya
  * @brief     Database user lookup library
  * @detail    Searches for a username in a specified column in a specified
  *            table in a specified database on a specified host (or a 
  *            specified database connection resource).
  *            If a single match found then returns true
  * @copyright Copyright (C) 2015, Vihar Malviya
  *            Under Modified BSD (3-Clause) License
  *            (see LICENSE or http://opensource.org/licenses/BSD-3-Clause)
  *
  **/
  
  /**
  * Request
  $ar_Request = array (
    "ky_UserKeyword"  => "username" ,
    "ky_UserPassword" => "password" ,
    "ky_GroupKeyword" => "usersgroup" ,
  ) ;

  * Specify data table parameters
  $var__Table = array (
    "key__Table_Name"             => "tblUser" ,
    "key__Table_ColumnUsername"   => "UserUsername" ,
    "key__Table_ColumnRole"       => "UserRole" ,
    "key__Table_DefaultRoleValue" => "READ ONLY" ,
  ) ;

  * Specify database parameters
  $var__Database = array (
    "key__Database_Host"     => "localhost" ,
    "key__Database_Port"     => 3306 ,
    "key__Database_Name"     => "databasename" ,
    "key__Database_User"     => "databaseusername" ,
    "key__Database_Password" => "databasepassword" ,
  ) ;

  * Specify an existing database connection object
  $var__Database_Connection [ "key__DatabaseConnection_Object" ] = mysqli_connect (
    $var__Database [ "key__Database_Host" ] ,
    $var__Database [ "key__Database_User" ] ,
    $var__Database [ "key__Database_Password"] ,
    $var__Database [ "key__Database_Name" ] ,
    $var__Database [ "key__Database_Port" ]
  ) ;

  * Call the function - four alternatives:
  fn__Database_Verify ( $ar_Request , $var__Table , "mysqli" , NULL           , $var__Database_Connection ) ;
  fn__Database_Verify ( $ar_Request , $var__Table , "mysql"  , NULL           , $var__Database_Connection ) ;
  fn__Database_Verify ( $ar_Request , $var__Table , "mysqli" , $var__Database , NULL ) ;
  fn__Database_Verify ( $ar_Request , $var__Table , "mysql"  , $var__Database , NULL ) ;

  If $var__Database and $var__Database_Connection are both given,
  then $var__Database_Connection takes precedence
  because an existing connection is given priority over creating a new connection.

  **/

  /* Set $GLOBALS['bl_DebugSwitch'] = TRUE for debugging */
  // $GLOBALS['bl_DebugSwitch'] = FALSE ;
  
  
  /* Include libraries */
  $sr_Filename = '' ;
  foreach (
    glob ( 
      dirname(__FILE__) .
      DIRECTORY_SEPARATOR .
      'Lib' .
      DIRECTORY_SEPARATOR .
      '*.inc.php'
    ) as $sr_Filename
  ) {
    include_once(realpath($sr_Filename)) ;
  }
  
  function fn__Database_Verify (
    $ag_Request ,
    $arg__Table ,
    $arg__Database_Extension = "mysqli" ,
    $arg__Database = NULL ,
    $arg__Database_ConnectionObject = NULL
  ) {
    
    fn_Debug ( 'Request' , $ag_Request , 'ky_UserPassword' ) ;
    fn_Debug ( 'Supplied table parameters' , $arg__Table ) ;
    fn_Debug ( 'DB extension library requested' , $arg__Database_Extension ) ;
    fn_Debug ( 'Supplied database connection configuration' , $arg__Database , 'key__Database_Password' ) ;
    fn_Debug ( 'Supplied database connection resource' , $arg__Database_ConnectionObject ) ;
    
    // Temporary variable for compatibility with XatafaceLDAPauth v02.00.00
    $arg__Common['key__Common_SearchUserKeyword'] = $ag_Request['ky_UserKeyword'] ; 
    $arg__Common['key__Common_SearchUserPassword'] = $ag_Request['ky_UserPassword'] ;
    $arg__Common['key__Common_SearchGroupKeyword'] = $ag_Request['ky_GroupKeyword'] ;
    fn_Debug ( 'Transferred to holding variable for compatibility' , $arg__Common , 'key__Common_SearchUserPassword' ) ;
    
    // Transfer supplied connection object
    $arg__Database_Connection=array();
    fn_Debug ( 'Holding array for existing DB connection object created' , $arg__Common , 'key__Common_SearchUserPassword' ) ;
    fn_Debug ( 'Checking for supplied DB connection object/resource' , @$arg__Database_ConnectionObject ) ;
    if ( ! is_null($arg__Database_ConnectionObject) ) {
      $arg__Database_Connection["key__DatabaseConnection_Object"] = $arg__Database_ConnectionObject ;
      fn_Debug ( 'Non-null database connection found, mapped to internal variable' , $arg__Database_Connection["key__DatabaseConnection_Object"] ) ;
    } else {
      fn_Debug ( 'Null database connection. Will need to connect to the database later.' ) ;
    }
    
    // Preset worst case for return result;
    $ret__Database = array (
      "key__Database_Connection" => FALSE ,
      "key__Database_UserFound"  => FALSE ,
      "key__Database_UserAdded"  => FALSE
    ) ;
    fn_Debug ( 'Preset default responses' , $ret__Database ) ;
    
    
    fn_Debug ( 'Checking for supplied database configuration' , $arg__Database , 'key__Database_Password' ) ;
    if ( $arg__Database != NULL ) {
      fn_Debug ( 'Checking for supplied database host' , @$arg__Database['key__Database_Host'] ) ;
      if ( ! array_key_exists ( 'key__Database_Host' , $arg__Database ) ) {
        $arg__Database [ "key__Database_Host" ] = "localhost" ;
        fn_Debug ( 'Database host not specified. Set "localhost" as default.' , $arg__Database["key__Database_Host"] ) ;
      }
      
      fn_Debug ( 'Checking for supplied database port' , @$arg__Database['key__Database_Port'] ) ;
      if ( ! array_key_exists ( 'key__Database_Port' , $arg__Database ) ) {
      $arg__Database["key__Database_Port"] = 3306 ;
      fn_Debug ( 'Database port not specified. Set "3306" as default.' , $arg__Database["key__Database_Port"] ) ;
      }
    }
    
    // Check if MySQL functionality exists
    fn_Debug ( 'Checking if MySQL functionality exists' ) ;
    if ( $arg__Database_Extension == "mysqli" && ! function_exists ( "mysqli_connect" ) ) {
      fn_Debug ( 'mysqli library requested, but not found' ) ;
      trigger_error ( "Please install the PHP MySQLi module in order to use MySQL database verification." , E_USER_ERROR ) ;
    } elseif ( $arg__Database_Extension == "mysql" && ! function_exists ( "mysql_connect" ) ) {
      fn_Debug ( 'mysql library requested, but not found' ) ;
      trigger_error ( "Please install the PHP MySQL module in order to use MySQL database verification." , E_USER_ERROR ) ;
    } else {
      
      // Connect to database
      fn_Debug ( 'MySQL functionality checked, proceeding to connect' ) ;
      
      // Check if existing connection object is supplied
      fn_Debug ( 'Checking if existing connection object is supplied' , @$arg__Database_Connection["key__DatabaseConnection_Object"] ) ;
      if ( @$arg__Database_Connection["key__DatabaseConnection_Object"] === NULL ) {
        // Existing connection object not found in supplied parameters; check supplied database parameters for new connection.
        fn_Debug ( 'Existing connection object not found in supplied parameters; checking supplied database parameters for new connection' , @$arg__Database , 'key__Database_Password' ) ;
        if ( $arg__Database == NULL ) {
          // Database configuration not found in supplied parameters
          fn_Debug ( 'Database configuration not found in supplied parameters, returning values' ) ;
          return array (
            "key__Database_Connection" => $ret__Database ["key__Database_Connection" ] ,
            "key__Database_UserFound" => $ret__Database [ "key__Database_UserFound" ] ,
            "key__Database_UserAdded" => $ret__Database [ "key__Database_UserAdded" ] ,
          ) ;
          trigger_error ( "Please supply either a valid database connection object or database connection parameters." , E_USER_ERROR ) ;
        } else {
          // Database connection configuration found, checking extension
          fn_Debug ( 'Database connection configuration found, checking extension' , $arg__Database_Extension ) ;
          switch ( $arg__Database_Extension ) {
            case "mysqli":
              // mysqli requested, proceeding to connect
              fn_Debug ( 'mysqli requested, proceeding to connect' , $arg__Database , 'key__Database_Password' ) ;
              $arg__Database_Connection [ "key__DatabaseConnection_Object" ] = mysqli_connect (
                $arg__Database [ "key__Database_Host" ] ,
                $arg__Database [ "key__Database_User" ] ,
                $arg__Database [ "key__Database_Password"] ,
                $arg__Database [ "key__Database_Name" ] ,
                $arg__Database [ "key__Database_Port" ]
              ) ;
              // Check for connection errors
              fn_Debug ( 'Checking for connection errors' , mysqli_connect_errno() ) ;
              if ( mysqli_connect_errno() ) {
                // Failed to connect to MySQL
                fn_Debug ( 'Failed to connect to MySQL; returning response' , $ret__Database ) ;
                
                // Exit if connection fails
                trigger_error ( "Failed to connect to MySQL: " . mysqli_connect_error ( ) , E_USER_ERROR ) ;
                return array (
                  "key__Database_Connection" => $ret__Database ["key__Database_Connection" ] ,
                  "key__Database_UserFound" => $ret__Database [ "key__Database_UserFound" ] ,
                  "key__Database_UserAdded" => $ret__Database [ "key__Database_UserAdded" ] ,
                ) ;
              }
              else {
                // Successfully connected to MySQL
                $ret__Database ["key__Database_Connection" ] = TRUE ;
                fn_Debug ( 'Successfully connected to MySQL; set response' , $ret__Database ["key__Database_Connection" ] ) ;
              }
              break;
            case "mysql":
              // mysql requested, proceeding to connect
              fn_Debug ( 'mysql requested, proceeding to connect' , $arg__Database , 'key__Database_Password' ) ;
              $arg__Database_Connection["key__DatabaseConnection_Object"] = mysql_connect (
                $arg__Database["key__Database_Host"] . ":" . $arg__Database [ "key__Database_Port" ] ,
                $arg__Database["key__Database_User"] ,
                $arg__Database [ "key__Database_Password"]
              ) ;
              
              // Check for connection errors
              fn_Debug ( 'Checking for connection errors' , $arg__Database_Connection["key__DatabaseConnection_Object"] ) ;
              if ( ! $arg__Database_Connection [ "key__DatabaseConnection_Object" ] ) {
                // Failed to connect to MySQL
                fn_Debug ( 'Failed to connect to MySQL' ) ;
                trigger_error ( "Failed to connect to MySQL host." , E_USER_ERROR ) ;
              } else {
                // Successfully connected to MySQL
                fn_Debug ( 'Successfully connected to database server; proceeding to select database' , $ret__Database ["key__Database_Connection" ] ) ;
                
                // Select database
                if ( ! mysql_select_db ( $arg__Database['key__Database_Name'] , $arg__Database_Connection["key__DatabaseConnection_Object"] ) ) {
                  fn_Debug ( 'Could not select database' , $arg__Database['key__Database_Name'] ) ;
                } else {
                  fn_Debug ( 'Selected database' , $arg__Database['key__Database_Name'] ) ;
                  $ret__Database ["key__Database_Connection" ] = TRUE ;
                  fn_Debug ( 'Response set' , $ret__Database ["key__Database_Connection" ] ) ;
                }
                
              }
              break;
          }
        }
      } else {
      fn_Debug ( 'Connection object is supplied' ) ;
      }

      // Formulate SQL query
      fn_Debug ( 'Formulating SQL query to search for user' ) ;
      
      // Escape supplied username keyword
      fn_Debug ( 'Escaping username depending on selected extensions' , $arg__Common["key__Common_SearchUserKeyword"] ) ;
      
      fn_Debug ( 'Selecting appropriate library extensions' , $arg__Database_Extension ) ;
      switch ( $arg__Database_Extension ) {
        case "mysqli":
          // mysqli requested, proceed to escape string
          fn_Debug ( 'mysqli requested, escaping string' ) ;
          $arg__Common["key__Common_SearchUserKeyword"] = mysqli_real_escape_string ( $arg__Database_Connection [ "key__DatabaseConnection_Object" ] , $arg__Common["key__Common_SearchUserKeyword"] ) ;
          break;
        case "mysql":
          // mysqli requested, proceed to escape string
          fn_Debug ( 'mysql requested, escaping string' ) ;
          // $arg__Common["key__Common_SearchUserKeyword"] = mysql_real_escape_string ( $arg__Common["key__Common_SearchUserKeyword"] , $arg__Database_Connection [ "key__DatabaseConnection_Object" ] ) ;
          $arg__Common["key__Common_SearchUserKeyword"] = mysql_real_escape_string ( $arg__Common["key__Common_SearchUserKeyword"] ) ;
          break;
      }
      fn_Debug ( 'Escaped username' , $arg__Common["key__Common_SearchUserKeyword"] ) ;
      
      
      $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Text" ] =
        "SELECT `" . $arg__Table [ "key__Table_ColumnUsername" ] .
        "` FROM `" . $arg__Table [ "key__Table_Name" ] .
        "` WHERE `" . $arg__Table [ "key__Table_ColumnUsername" ] . "`='" . $arg__Common [ "key__Common_SearchUserKeyword" ] . "'" ;
      fn_Debug ( 'Query formulated' , $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Text" ] ) ;

      // Run the query
      fn_Debug ( 'Selecting appropriate library extensions' , $arg__Database_Extension ) ;
      switch ( $arg__Database_Extension ) {
        case "mysqli":
          // mysqli requested, proceed to run query
          fn_Debug ( 'mysqli requested, running query' ) ;
          $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] = mysqli_query (
            $arg__Database_Connection [ "key__DatabaseConnection_Object" ] ,
            $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Text" ]
          ) ;
          break;
        case "mysql":
          // mysql requested, proceed to run query
          fn_Debug ( 'mysql requested, running query' ) ;
          $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] = mysql_query (
            $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Text" ] // ,
            // $arg__Database_Connection [ "key__DatabaseConnection_Object" ]
          ) ;
          break;
      }

      // Check query success
      fn_Debug ( 'Query submitted, checking results' , $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ;
      if ( ! $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) {
        fn_Debug ( 'Query failed' ) ;
      } else {

        // Query successful. Check number of rows returned, but first select appropriate extension
        fn_Debug ( 'Query successful. Selecting extension library' , $arg__Database_Extension ) ;
        switch ( $arg__Database_Extension ) {
          case "mysqli":
            // mysqli requested, Check number of rows returned
            fn_Debug ( 'mysqli requested, checking number of rows returned' ) ;
            $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_ReturnedRowCount" ] =  mysqli_num_rows ( $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ;
            break;
          case "mysql":
            // mysql requested, Check number of rows returned
            fn_Debug ( 'mysql requested, checking number of rows returned' ) ;
            $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_ReturnedRowCount" ] =  mysql_num_rows ( $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ;
            break;
        }
        
        // Check
        fn_Debug ( 'Overall status of query' , $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] ) ;
        
        fn_Debug ( 'Results counted' , $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_ReturnedRowCount" ] ) ;
        
        // Check for size of the result
        fn_Debug ( 'Organise results; evaluate results count' ,$arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_ReturnedRowCount" ] ) ;
        switch ( $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_ReturnedRowCount" ]  ) {
          case 0:
            // No results found
            fn_Debug ( 'No results found, inserting new record' , $arg__Common [ "key__Common_SearchUserKeyword" ] ) ;

            // Formulate a query string to insert new record
            fn_Debug ( 'Formulating SQL query to insert new record' ) ;
            $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] [ "key__QueryAdd_Text" ] = "INSERT INTO `" . $arg__Table [ "key__Table_Name" ] . "`
              ( `" . $arg__Table [ "key__Table_ColumnUsername" ] . "`, `" . $arg__Table [ "key__Table_ColumnRole" ] . "` )
              VALUES ( '" . $arg__Common [ "key__Common_SearchUserKeyword" ] . "', '" . $arg__Table [ "key__Table_DefaultRoleValue" ] . "' )" ;
            
            fn_Debug ( 'Query formulated' , $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] [ "key__QueryAdd_Text" ] ) ;
            fn_Debug ( 'Selecting appropriate library extensions' , $arg__Database_Extension ) ;
            switch ( $arg__Database_Extension ) {
              case "mysqli":
                // mysqli requested, Run query
                fn_Debug ( 'mysqli requested, running query' ) ;
                $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] [ "key__QueryAdd_Result" ] = mysqli_query (
                    $arg__Database_Connection [ "key__DatabaseConnection_Object" ] ,
                    $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] [ "key__QueryAdd_Text" ]
                ) ;
                break;
              case "mysql":
                // mysql requested, Run query
                fn_Debug ( 'mysql requested, running query' ) ;
                $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] [ "key__QueryAdd_Result" ] = mysql_query (
                    $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] [ "key__QueryAdd_Text" ] //,
                    // $arg__Database_Connection [ "key__DatabaseConnection_Object" ]
                ) ;
                break;
            }

            // Check query success
            fn_Debug ( 'Query submitted, checking results' , $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] [ "key__QueryAdd_Result" ] ) ;
            if ( ! $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] [ "key__QueryAdd_Result" ] ) {
              fn_Debug ( 'Query failed, could not add record' , $arg__Common [ "key__Common_SearchUserKeyword" ] ) ;
            } else {
              fn_Debug ( 'Query successful, record added' , $arg__Common [ "key__Common_SearchUserKeyword" ] ) ;
              $ret__Database [ "key__Database_UserAdded" ] = TRUE ;
              fn_Debug ( 'Return response set' , $ret__Database [ "key__Database_UserAdded" ] ) ;
            }

            // Check
            fn_Debug ( 'Overall status of query' , $arg__Database_Connection [ "key__DatabaseConnection_QueryAddUser" ] ) ;
            
            break ;

          case 1:
            fn_Debug ( 'One result found; checking further' , $arg__Common [ "key__Common_SearchUserKeyword" ] ) ;

            // Go to the start of the result
            fn_Debug ( 'Selecting appropriate library extensions' , $arg__Database_Extension ) ;
            switch ( $arg__Database_Extension ) {
              case "mysqli":
                // mysqli requested, Seek to beginning of the result
                fn_Debug ( 'mysqli requested, seeking to the beginning of the result' ) ;
                if ( mysqli_data_seek ( $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] , 0 ) ) {
                  fn_Debug ( 'Moved result pointer to the first row returned' ) ;
                } else {
                  fn_Debug ( 'Failed to move result pointer to the first row returned' ) ;
                }
                break;
              case "mysql":
                // mysql requested, Seek to beginning of the result
                fn_Debug ( 'mysql requested, seeking to the beginning of the result' ) ;
                if ( mysql_data_seek ( $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] , 0 ) ) {
                  fn_Debug ( 'Moved result pointer to the first row returned' ) ;
                } else {
                  fn_Debug ( 'Failed to move result pointer to the first row returned' ) ;
                }
                break;
            }

            // Fetch the data (since only one result is returned, a while loop to go through the rows returned is not required)
            fn_Debug ( 'Fetching data; but selecting appropriate library extensions' , $arg__Database_Extension ) ;
            switch ( $arg__Database_Extension ) {
              case "mysqli":
                // mysqli requested, proceed to fetch data
                fn_Debug ( 'mysqli requested, proceeding to fetch data' , $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ]) ;
                $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Output" ] = mysqli_fetch_assoc ( $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ;
                break;
              case "mysql":
                // mysql requested, proceed to fetch data
                fn_Debug ( 'mysql requested, proceeding to fetch data' , $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ;
                $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Output" ] = mysql_fetch_assoc ( $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ;
                break;
            }

            // Show the output
            fn_Debug ( 'Search data fetched' , $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ]["key__QuerySearch_Output"] ) ;

            // Compare the result
            fn_Debug (
              'Comparing result' ,
              array (
                $arg__Database_Connection
                  ["key__DatabaseConnection_QuerySearchUser"]
                  ["key__QuerySearch_Output"]
                  [$arg__Table["key__Table_ColumnUsername"]] ,
                $arg__Common["key__Common_SearchUserKeyword"]
              )
            ) ;
            if ( $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Output" ] [ $arg__Table [ "key__Table_ColumnUsername" ] ] == $arg__Common [ "key__Common_SearchUserKeyword" ] ) {
              $ret__Database [ "key__Database_UserFound" ] = TRUE ;
              fn_Debug ( 'Match found, response set' , $ret__Database["key__Database_UserFound"] ) ;
            }
            else {
              fn_Debug ( 'Match not found, response unchanged' ) ;
            }
            
            break ;
          default:
            fn_Debug ( 'More than one result found; Exiting loop' ) ;
            break;
        }
        
        // Check
        fn_Debug ( 'Overall status of connection' , $arg__Database_Connection ) ;

        // Free the memory associated with the query result
        fn_Debug ( 'Freeing memory for the result of the search query' , $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ;
        fn_Debug ( 'Selecting appropriate library extensions' , $arg__Database_Extension ) ;
        switch ( $arg__Database_Extension ) {
          case "mysqli":
            // mysqli requested, proceed to free memory
            fn_Debug ( 'mysqli requested, proceeding to free memory' ) ;
            mysqli_free_result (  $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ;
            break;
          case "mysql":
            // mysql requested, proceed to free memory
            fn_Debug ( 'mysql requested, proceeding to free memory' ) ;
            if ( mysql_free_result (  $arg__Database_Connection [ "key__DatabaseConnection_QuerySearchUser" ] [ "key__QuerySearch_Result" ] ) ) {
              fn_Debug ( 'Memory for the result of the search query freed' ) ;
            } else {
              fn_Debug ( 'Failed to free memory for the result of the search query' ) ;
            }
            break;
        }

      }

      // Close the database connection
      fn_Debug ( 'Finished, checking if database connection was initially supplied' , @$arg__Database_Connection ) ;
      if ( $arg__Database_Connection == NULL ) {
        fn_Debug ( 'Database connection was not supplied, checking if database parameters were supplied' , @$arg__Database , 'key__Database_Password' ) ;
        if ( $arg__Database == NULL ) {
          // No need to close the connection as nothing could have been done if both database arguments were NULL.
          fn_Debug ( 'Database parameters were not supplied, assuming no connections were open, so none to close' ) ;
        } else {
          fn_Debug ( 'Selecting appropriate library extensions' , $arg__Database_Extension ) ;
          switch ( $arg__Database_Extension ) {
            case "mysqli":
              // mysqli requested, proceeding to close connection
              fn_Debug ( 'mysqli requested, proceeding to close connection' ) ;
              if ( mysqli_close ( $arg__Database_Connection [ "key__DatabaseConnection_Object" ] ) ) {
                fn_Debug ( 'Connection to database closed' ) ;
              } else {
                fn_Debug ( 'Could not close connection to database' ) ;
              }
              break;
            case "mysql":
              // mysql requested, proceeding to close connection
              fn_Debug ( 'mysql requested, proceeding to close connection' ) ;
              if ( mysql_close ( $arg__Database_Connection [ "key__DatabaseConnection_Object" ] ) ) {
                fn_Debug ( 'Connection to database closed' ) ;
              } else {
                fn_Debug ( 'Could not close connection to database' ) ;
              }
              break;
          }
        }
      } else {
        fn_Debug ( 'Database connection inherited, no closing required' , $arg__Database_Connection ) ;
      }
    }
    
    fn_Debug ( 'Returning response' , $ret__Database ) ;
    return array (
      "key__Database_Connection" => $ret__Database ["key__Database_Connection" ] ,
      "key__Database_UserFound"  => $ret__Database [ "key__Database_UserFound" ] ,
      "key__Database_UserAdded"  => $ret__Database [ "key__Database_UserAdded" ]
    ) ;

  }
?>