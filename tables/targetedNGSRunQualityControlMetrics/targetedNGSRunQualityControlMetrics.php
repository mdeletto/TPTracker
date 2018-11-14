<?php
class tables_targetedNGSRunQualityControlMetrics {

	function beforeInsert(&$record){
    		$auth =& Dataface_AuthenticationTool::getInstance();
    		$username =& $auth->getLoggedInUsername();
    		$record->setValue('creator', $username);
		$record->setValue('modifier', $username);
	}


	function beforeUpdate(&$record) {
	    // Track modifier
	    $auth =& Dataface_AuthenticationTool::getInstance();
	    $username =& $auth->getLoggedInUsername();
	    if ( $username ) $record->setValue('modifier', $username);
	}

    function __sql__()
    {
        return "select t1.*, t3.highPriority as highPriority, null as heatmap, null as rawMeanAccuracyPlot, null as wellsBeadogram, null as tumorBarcodeHistogram, null as normalBarcodeHistogram, null as tumorRNABarcodeHistogram from targetedNGSRunQualityControlMetrics t1 left join sequencing_cases t3 on t1.sampleName = t3.copath_id";
    }

    function heatmap__htmlValue(&$record){
	
	$id = $record->display('resultName');
	$files = glob("tables/targetedNGSRunQualityControlMetrics/TSimages/$id*/Bead_density_200.png");

	return "<img src='$files[0]' style='height: 60%;' />";

    }

    function rawMeanAccuracyPlot__htmlValue(&$record){
	
	$id = $record->display('resultName');
	$files = glob("tables/targetedNGSRunQualityControlMetrics/TSimages/$id*/base_error_plot.png");

	return "<img src='$files[0]' style='height: 60%;'/>";

    }

    function wellsBeadogram__htmlValue(&$record){
	
	$id = $record->display('resultName');
	$files = glob("tables/targetedNGSRunQualityControlMetrics/TSimages/$id*/basecaller_results/wells_beadogram.png");

	return "<img src='$files[0]' style='height: 60%;'/>";

    }

    function tumorBarcodeHistogram__htmlValue(&$record){
	
	$id = $record->display('resultName');
	$tumor_barcode = $record->display('tumorBarcode');
	$files = glob("tables/targetedNGSRunQualityControlMetrics/TSimages/$id*/basecaller_results/$tumor_barcode*.sparkline.png");

	return "<img src='$files[0]' />";

    }

    function normalBarcodeHistogram__htmlValue(&$record){
	
	$id = $record->display('resultName');
	$normal_barcode = $record->display('normalBarcode');
	$files = glob("tables/targetedNGSRunQualityControlMetrics/TSimages/$id*/basecaller_results/$normal_barcode*.sparkline.png");
	if (!(is_null($normal_barcode)) && !($normal_barcode == "")){
		return "<img src='$files[0]' />";
	}
    }

    function tumorRNABarcodeHistogram__htmlValue(&$record){
	
	$id = $record->display('resultName');
	$tumorRNAbarcode = $record->display('tumorRNABarcode');
	if (!(is_null($tumorRNAbarcode)) && !($tumorRNAbarcode == "" )){
		$files = glob("tables/targetedNGSRunQualityControlMetrics/TSimages/$id*/basecaller_results/$tumorRNAbarcode*.sparkline.png");
		return "<img src='$files[0]' />";
	} else {
		return;
	}


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
   /**
    function heatmap__renderCell(&$record){

	return '<img src="'.'tables/targetedNGSRunQualityControlMetrics/TSimages'.$record->display('resultName').'/Bead_density_70.png'.'"/>';
   }
   */

    /**
     * Trigger that is called after Course record is inserted.
     * @param $record Dataface_Record object that has just been inserted.
     
    function afterInsert(&$record){
        mail("michael.d'eletto@ynhh.org",'Subject Line', 'Message body'); 
    } 
    */
}
?>
