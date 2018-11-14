//require <jquery.packed.js>
//require-css <jquery-ui/jquery-ui.css>
//require-css <master_detail/style.css>
//require <jquery.layout.js>
//require <flexigrid.js>
//require-css <flexigrid/flexigrid.pack.css>
(function(){
	var $ = jQuery;
	$(document).ready(function(){
		var table = $('#xf-meta-tablename').attr('content');
		$('body').layout({ 
		
			applyDemoStyles: true, 
			onresize_end : function(){
				
			}
		});
		$('.table-listing').each(function(){
			var cols = [];
			$('thead > tr > th', this).each(function(){
				cols.push({
					display: $(this).text(),
					name: $(this).attr('data-column-name'),
					sortable : true,
					
				});
			});
			
			
			var params = [];
			var query = window.location.search;
			if ( query.length > 0 ){
				query = query.substr(1);
				
			}
			var queryParts = query.split(/&/);
			$.each(queryParts, function(k,v){
				var kv = v.split(/=/);
				
				params.push({name : kv[0], value: kv[1]}); 
			});
			
			params.push({name : '--format', value: 'json'});
			
			$(this).flexigrid({
				url : DATAFACE_SITE_HREF,
				params : params,
				useRp : true,
				colModel : cols,
				singleSelect : true,
				rp : 15,
				usepager : true,
				dataType : 'json',
				height: 'auto',
				searchitems : cols,
				showTableToggleBtn : true
				
				
			});
			
			$(this).on('click', 'tr', function(){
				
				var id = $(this).attr('id');
				if ( !id || id.length < 4){
					return;
				}
				id = id.substr(3);
				if ( table ){
					var url = DATAFACE_SITE_HREF+'?-table='+encodeURIComponent(table)+'&-action=edit&--recordid='+encodeURIComponent(id);
					$('#detailFrame').attr('src',url);
				}

			});
			
			
			
		});
		
		
		
		$('#detailFrame').load(function(){
			var $head = $(this).contents().find("head");                
			$head.append($("<link/>", { rel: "stylesheet", href: DATAFACE_URL+'/iframe.css', type: "text/css" }));
			
		});
	});
	
})();