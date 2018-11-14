<?php

if ( !isset($_REQUEST['-sort']) and @$_REQUEST['-table'] == 'targetedNGSRunQualityControlMetrics' ){
    $_REQUEST['-sort'] = $_GET['-sort'] = 'datetimeCreated desc';
}

elseif ( !isset($_REQUEST['-sort']) and @$_REQUEST['-table'] == 'sequencing_cases' ){
    $_REQUEST['-sort'] = $_GET['-sort'] = 'req_date desc';
}

elseif ( !isset($_REQUEST['-sort']) and @$_REQUEST['-table'] == 'otherMolecularReqs' ){
    $_REQUEST['-sort'] = $_GET['-sort'] = 'reqDate desc';
}

elseif ( !isset($_REQUEST['-sort']) and @$_REQUEST['-table'] == 'taqmanCases' ){
    $_REQUEST['-sort'] = $_GET['-sort'] = 'req_date desc';
}

elseif ( !isset($_REQUEST['-sort']) and @$_REQUEST['-table'] == 'tumorProfilingServiceSchedule' ){
    $_REQUEST['-sort'] = $_GET['-sort'] = 'startDate desc';
}


// Include the Xataface API
require_once 'xataface/dataface-public-api.php';

// Initialize Xataface framework
df_init(__FILE__, 'xataface')->display();
    // first parameter is always the same (path to the current script)
    // 2nd parameter is relative URL to xataface directory (used for CSS files and javascripts)

/**
 * @brief Method to determine if the currently logged in user is allowed to switch users.
 * @return boolean True if the user is allowed to switch accounts.  False otherwise.
 */


