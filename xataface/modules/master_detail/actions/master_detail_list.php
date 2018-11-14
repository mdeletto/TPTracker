<?php
class actions_master_detail_list {
	function handle($params){
		$columns = array();
		if ( @$_POST and @$_POST['--format'] == 'json' ){
			$this->handlePost();
			return;
		}
	
		$mod = Dataface_ModuleTool::getInstance()
			->loadModule('modules_master_detail');
		$mod->addPaths();
		
		$js = Dataface_JavascriptTool::getInstance()
			->import('master_detail/list.js');
			
		$query = Dataface_Application::getInstance()->getQuery();
		
		
		$table = Dataface_Table::loadTable($query['-table']);
		$records = df_get_records_array($query['-table'], $q);
		
		$fields = $table->fields(false, true);
		foreach ( $fields as $k=>$field ){
			$columns[] = array(
				'name' => $field['name'],
				'label' => $field['widget']['label']
			);
		}
		
		
		
		df_display(array('columns' => $columns), 'master_detail/list_iframe.html');
	}
	
	function handlePost(){
		$rows = array();
		$columns = array();
		



		
		$query = Dataface_Application::getInstance()->getQuery();
		
		
		$q = array(
			'-table' => $query['-table'],
			'-limit' => $query['rp'],
			'-skip' => intval($query['rp']) * (intval($query['page'])-1)
		);
		if ( @$query['sortname'] ){
			$q['-sort'] = $query['sortname'].' '.$query['sortorder'];
		}
		
		if ( @$query['qtype'] ){
			$q[$query['qtype']] = $query['query'];
		}
		
		$table = Dataface_Table::loadTable($query['-table']);
		$records = df_get_records_array($query['-table'], $q);
		
		$fields = $table->fields(false, true);
		foreach ( $fields as $k=>$field ){
			$columns[] = array(
				'name' => $field['name'],
				'label' => $field['widget']['label']
			);
		}
		
		foreach ( $records as $record ){
			$row = array('id' => $record->getId(), 'cell' => array());
			foreach ( $columns as $col ){
				$row['cell'][] = $record->display($col['name']);
			}
			//$rows[$record->getId()] = $row;
			$rows[] = $row;
			
		}
		
		$qb = new Dataface_QueryBuilder($query['-table'], $q);
		$sql = $qb->select_num_rows($q);
		$res = df_q($sql);
		$numRows = 0;
		if ( $row = mysql_fetch_row($res) ){
			$numRows = $row[0];
		}
		@mysql_free_result($res);
		
		$out = array(
			'page' => $query['page'],
			'total' => $numRows,
			'rows' => $rows
		);
		
		header('Content-type: application/json; charset="'.Dataface_Application::getInstance()->_conf['oe'].'"');
		echo json_encode($out);
		
		
	}
	
}