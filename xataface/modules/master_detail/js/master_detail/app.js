//require-css <jquery-ui/jquery-ui.css>
//require-css <master_detail/style.css>
//require <jquery.packed.js>
//require <jquery.layout.js>
//require-css <jstree/style.min.css>
//require <jstree.min.js>
(function(){
	var $ = jQuery;
		$(document).ready(function () {
		$('body').layout({ applyDemoStyles: true });
		$('#navtree').jstree();
		$('#navtree a').each(function(){
			var href = $(this).attr('href');
			if ( href.indexOf('-table=') >= 0 ){
				href = href.replace(/-action=[^&]+/,'');
				href += '&-action=master_detail_list';
				$(this).attr('href',href);
				$(this).attr('target', 'mainFrame');
				$(this).click(function(){
					$('#mainFrame').get(0).src = href;
					//alert("foobar");
					return false;
				});
			}
			
			
		});
	});

})();