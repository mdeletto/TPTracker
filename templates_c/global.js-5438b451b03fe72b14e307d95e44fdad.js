if(typeof(window.console)=='undefined'){window.console={log:function(str){}};}if(typeof(window.__xatajax_included__)!='object'){window.__xatajax_included__={};};(function(){var headtg=document.getElementsByTagName("head")[0];if(!headtg)return;var linktg=document.createElement("link");linktg.type="text/css";linktg.rel="stylesheet";linktg.href="/TPTracker/index.php?-action=css&--id=RecordDial-c70e656250caffff5fcd0634c9a78292";linktg.title="Styles";headtg.appendChild(linktg);})();if(typeof(window.__xatajax_included__['xataface/modules/g2/global.js'])=='undefined'){window.__xatajax_included__['xataface/modules/g2/global.js']=true;if(typeof(window.__xatajax_included__['xatajax.actions.js'])=='undefined'){window.__xatajax_included__['xatajax.actions.js']=true;if(typeof(window.__xatajax_included__['xatajax.form.core.js'])=='undefined'){window.__xatajax_included__['xatajax.form.core.js']=true;(function(){var $=jQuery;XataJax.form={findField:findField,createForm:createForm,submitForm:submitForm};function findField(startNode,fieldName){var field=null;$(startNode).parents('.xf-form-group').each(function(){if(field){return;}
field=$('[data-xf-field="'+fieldName+'"]',this).get(0);});if(!field){var parentGroup=$(startNode).parents('form').get(0);field=$('[data-xf-field="'+fieldName+'"]',parentGroup).get(0);}
return field;}
function createForm(method,params,target,action){if(typeof(action)=='undefined')action=DATAFACE_SITE_HREF;var form=$('<form></form>').attr('action',action).attr('method',method);if(target)form.attr('target',target);$.each(params,function(key,value){form.append($('<input/>').attr('type','hidden').attr('name',key).attr('value',value));});return form;}
function submitForm(method,params,target,action){var form=createForm(method,params,target,action);$('body').append(form);form.submit();}})();}
(function(){var $=jQuery;if(typeof(XataJax.actions)=='undefined'){XataJax.actions={};}
XataJax.actions.doSelectedAction=doSelectedAction;XataJax.actions.handleSelectedAction=handleSelectedAction;XataJax.actions.hasRecordSelectors=hasRecordSelectors;XataJax.actions.getSelectedIds=getSelectedIds;function getSelectedIds(container,asString){if(typeof(asString)=='undefined')asString=false;var ids=[];var checkboxes=$('input.rowSelectorCheckbox',container);checkboxes.each(function(){if($(this).is(':checked')&&$(this).attr('xf-record-id')){ids.push($(this).attr('xf-record-id'));}});if(asString)return ids.join("\n");return ids;}
function doSelectedAction(params,container,confirmCallback,emptyCallback){var ids=[];var checkboxes=$('input.rowSelectorCheckbox',container);checkboxes.each(function(){if($(this).is(':checked')&&$(this).attr('xf-record-id')){ids.push($(this).attr('xf-record-id'));}});if(ids.length==0){if(typeof(emptyCallback)=='function'){emptyCallback(params,container);}else{alert('No records are currently selected.  Please first select the records that you wish to act upon.');}
return;}
if(typeof(confirmCallback)=='function'){if(!confirmCallback(ids)){return;}}
params['--selected-ids']=ids.join("\n");XataJax.form.submitForm('post',params);}
function hasRecordSelectors(container){return($('input.rowSelectorCheckbox',container).size()>0);}
function handleSelectedAction(aTag,selector){var href=$(aTag).attr('href');var confirmMsg=$(aTag).attr('data-xf-confirm-message');var confirmCallback=null;if(confirmMsg){confirmCallback=function(){return confirm(confirmMsg);};}
var params=XataJax.util.getRequestParams(href);XataJax.actions.doSelectedAction(params,$(selector),confirmCallback);return false;}})();}
if(typeof(window.__xatajax_included__['xataface/modules/g2/advanced-find.js'])=='undefined'){window.__xatajax_included__['xataface/modules/g2/advanced-find.js']=true;(function(){var $=jQuery;$(document).ajaxError(function(e,xhr,settings,exception){if(!console)return;console.log(e);console.log(xhr);console.log(settings);console.log(exception);});var g2=XataJax.load('xataface.modules.g2');g2.AdvancedFind=AdvancedFind;function AdvancedFind(o){this.table=$('meta#xf-meta-tablename').attr('content');this.el=$('<div>').addClass('xf-advanced-find').css('display','none').get(0);$.extend(this,o);this.loaded=false;this.loading=false;this.installed=false;if(window.location.hash==='#search'){this.show();}}
$.extend(AdvancedFind.prototype,{load:load,ready:ready,show:show,hide:hide,install:install});function load(callback){callback=callback||function(){};var self=this;$(this.el).load(DATAFACE_SITE_HREF+'?-table='+encodeURIComponent(this.table)+'&-action=g2_advanced_find_form',function(){decorateConfigureButton(this);var params=XataJax.util.getRequestParams();var widgets=[];var formEl=this;$('[name]',this).each(function(){if(params[$(this).attr('name')]){$(this).val(params[$(this).attr('name')]);}
var widget=null;if($(this).attr('data-xf-find-widget-type')){widget=$(this).attr('data-xf-find-widget-type');}else if($(this).get(0).tagName.toLowerCase()=='select'){widget='select';}
if(widget){widgets.push('xataface/findwidgets/'+widget+'.js');}});if(widgets.length>0){XataJax.util.loadScript(widgets.join(','),function(){self.loaded=true;callback.call(self);$('[name]',formEl).each(function(){if(params[$(this).attr('name')]){$(this).val(params[$(this).attr('name')]);}
var widget=null;if($(this).attr('data-xf-find-widget-type')){widget=$(this).attr('data-xf-find-widget-type');}else if($(this).get(0).tagName.toLowerCase()=='select'){widget='select';}
if(widget){var w=new xataface.findwidgets[widget]();w.install(this);}});$('button.xf-advanced-find-clear',formEl).click(function(){$('input[name],select[name]',formEl).val('');return false;});$('button.xf-advanced-find-search',formEl).click(function(){$(this).parents('form').find('[name="-action"]').val('list');$(this).parents('form').submit();});$(self).trigger('onready');});}else{self.loaded=true;callback.call(self);$(self).trigger('onready');}});}
function ready(callback){if(this.loaded){callback.call(this);}else{$(this).bind('onready',callback);if(!this.loading){this.load();}}}
function install(){if(this.installed)return;$(this.el).insertAfter('a.xf-show-advanced-find');this.installed=true;}
function show(){this.ready(function(){window.location.hash='#search';if(!this.loaded)throw"Cannot show advanced find until it is ready.";if(!this.installed)this.install();$(this.el).parents('form').find('[name="-action"]').val('list');if(!$(this.el).is(':visible')){$(this.el).slideDown(function(){var x=$(this).offset().left;$(this).width($(window).width()-x-5);});}});}
function hide(){this.ready(function(){window.location.hash='';if(!this.loaded||!this.installed)return;if($(this.el).is(':visible')){$(this.el).slideUp();}});}
function decorateConfigureButton(el){$('li.configure-advanced-find-form-action a',el).click(function(){var iframe=$('<iframe>').attr('width','100%').attr('height',$(window).height()*0.8).on('load',function(){var winWidth=$(window).width()*0.8;var width=Math.min(800,winWidth);$(this).width(width);dialog.dialog("option","position","center");var showHideController=iframe.contentWindow.xataface.controllers.ShowHideColumnsController;showHideController.saveCallbacks.push(function(data){data.preventDefault=true;dialog.dialog('close');window.location.reload(true);});}).attr('src',$(this).attr('href')+'&--format=iframe').get(0);;var dialog=$("<div></div>").append(iframe).appendTo("body").dialog({autoOpen:false,modal:true,resizable:false,width:"auto",height:"auto",close:function(){$(iframe).attr("src","");},buttons:{'Save':function(){$('button.save',iframe.contentWindow.document.body).click();}},create:function(event,ui){$('body').addClass('stop-scrolling');},beforeClose:function(event,ui){$('body').removeClass('stop-scrolling');}});dialog.dialog("option","title","Show/Hide Columns").dialog("open");return false;});}})();}
if(typeof(window.__xatajax_included__['jquery.floatheader.js'])=='undefined'){window.__xatajax_included__['jquery.floatheader.js']=true;(function($){$.fn.floatHeader=function(config){config=$.extend({fadeOut:200,fadeIn:200,forceClass:false,markerClass:'floating',floatClass:'floatHeader',recalculate:false,IE6Fix_DetectScrollOnBody:true},config);return this.each(function(){var self=$(this);var tableClone=self[0].cloneNode(false);var table=$(tableClone);var cloneId=table.attr("id")+"FloatHeaderClone";table.attr("id",cloneId);table.parent().remove();self.floatBox=$('<div class="'+config.floatClass+'"style="display:none"></div>');self.floatBox.append(table);self.IEWindowWidth=document.documentElement.clientWidth;self.IEWindowHeight=document.documentElement.clientHeight;if(!$.browser.msie){config.IE6Fix_DetectScrollOnBody=false;}else{if($.browser.version>7){config.IE6Fix_DetectScrollOnBody=false;}}
var scrollElement=config.IE6Fix_DetectScrollOnBody?$('body'):$('div.fixedLeftWrapper').add(window);scrollElement.scroll(function(){if(self.floatBoxVisible){if(!showHeader(self,self.floatBox)){var offset=self.offset();self.floatBox.css('position','absolute');self.floatBox.css('top',offset.top);self.floatBox.css('left',offset.left);self.floatBoxVisible=false;if(config.cbFadeOut){config.cbFadeOut(self.floatBox);}else{self.floatBox.stop(true,true);self.floatBox.fadeOut(config.fadeOut);}}}else if(showHeader(self,self.floatBox)){if(table.children().length===0){createFloater(table,self,config);}
self.floatBoxVisible=true;if($.browser.msie&&$.browser.version<7){self.floatBox.css('position','absolute');}else{self.floatBox.css('position','fixed');}
if(config.cbFadeIn){config.cbFadeIn(self.floatBox);}else{self.floatBox.stop(true,true);self.floatBox.fadeIn(config.fadeIn);}}
if(self.floatBoxVisible){if($.browser.msie&&$.browser.version<=7){self.floatBox.css('top',$(window).scrollTop());}else{self.floatBox.css('top',0);}
self.floatBox.css('left',self.offset().left-$(window).scrollLeft());if(config.recalculate){recalculateColumnWidth(table,self,config);}}});if($.browser.msie&&$.browser.version<=7){$(window).resize(function(){if((self.IEWindowWidth!=document.documentElement.clientWidth)||(self.IEWindowHeight!=document.documentElement.clientHeight)){self.IEWindowWidth=document.documentElement.clientWidth;self.IEWindowHeight=document.documentElement.clientHeight;if(table.children().length>0){table.fastempty();createFloater(table,self,config);}}});}else{$(window).resize(function(){if(table.children().length>0){table.fastempty();createFloater(table,self,config);}});};$(self).after(self.floatBox);this.fhRecalculate=function(){recalculateColumnWidth(table,self,config);};this.fhInit=function(){if(table.children().length>0){table.fastempty();createFloater(table,self,config);}};$.fn.fastempty=function(){if(this[0]){while(this[0].hasChildNodes()){this[0].removeChild(this[0].lastChild);}}
return this;};});};function createFloater(target,template,config){target.width(template.width());var items;if(!config.forceClass&&template.children('thead').length>0){items=template.children('thead').eq(0).children();var thead=jQuery("<thead/>");target.append(thead);target=thead;}else{items=template.find('.'+config.markerClass);}
items.each(function(){var row=$(this);var rowClone=row[0].cloneNode(false);var floatRow=$(rowClone);row.children().each(function(){var cell=$(this);var floatCell=cell.clone();floatCell.width(cell.width());floatRow.append(floatCell);});target.append(floatRow);});}
function recalculateColumnWidth(target,template,config){target.width(template.width());var src;var dst;if(!config.forceClass&&template.children('thead').length>0){src=template.children('thead').eq(0).children().eq(0);dst=target.children('thead').eq(0).children().eq(0);}else{src=template.find('.'+config.markerClass).eq(0);dst=target.children().eq(0);}
dst=dst.children().eq(0);src.children().each(function(index,element){dst.width($(element).width());dst=dst.next();});}
function showHeader(element,floater){var elem=$(element);var top=$(window).scrollTop();var y0=elem.offset().top;var height=elem.height()-floater.height();var foot=elem.children('tfoot');if(foot.length>0){height-=foot.height();}
return y0<=top&&top<=y0+height;}})(jQuery);}
(function(){var $=jQuery;var _=xataface.lang.get;$(document).ready(function(){$('#dataface-sections-left-column').each(function(){var txt=$(this).text().replace(/^\W+/,'').replace(/\W+$/);if(!txt&&$('img',this).length==0)$(this).hide();});$('#left_column').each(function(){var txt=$(this).text().replace(/^\W+/,'').replace(/\W+$/);if(!txt&&$('img',this).length==0)$(this).hide();});var resultListTable=$('#result_list').get(0);if(resultListTable){$(resultListTable).floatHeader({recalculate:true});var rowPermissions={};$('input.rowSelectorCheckbox[data-xf-permissions]',resultListTable).each(function(){var perms=$(this).attr('data-xf-permissions').split(',');$.each(perms,function(){rowPermissions[this]=1;});});$('.result-list-actions li.selected-action').each(function(){var perm=$(this).children('a').attr('data-xf-permission');if(perm&&!rowPermissions[perm]){$(this).hide();}});}
$('table.listing > tbody > tr > td span[data-fulltext]').each(function(){var span=this;$(span).addClass('short-text');var moreDiv=null;var td=$(this).parent();while($(td).prop('tagName').toLowerCase()!='td'){td=$(td).parent();}
td=$(td).get(0);$(td).css({});var moreButton=$('<a>').addClass('listing-show-more-button').attr('href','#').html('...').click(showMore).get(0);var lessButton=$('<a href="#" class="listing-show-less-button">...</a>').click(showLess).get(0);function showMore(){var width=$(td).width();if(moreDiv==null){var divContent=null;var parentA=$(span).parent('a');if(parentA.size()>0){divContent=parentA.clone();$('span',divContent).removeClass('short-text').removeAttr('data-fulltext').text($(span).attr('data-fulltext'));}else{divContent=$(span).clone();divContent.removeClass('short-text').text($(span).attr('data-fulltext'));}
var divWidth=width-$(moreButton).width()-10;moreDiv=$('<div style="white-space:normal;"></div>').css('width',divWidth).append(divContent).addClass('full-text').get(0);$(td).prepend(moreDiv);}
$(td).addClass('expanded');return false;}
function showLess(){$(td).removeClass('expanded');return false;}
$(td).append(moreButton);$(td).append(lessButton);});$('table.listing td.row-actions-cell').each(function(){var reqWidth=0;$('.row-actions a',this).each(function(){reqWidth+=$(this).outerWidth(true);});$(this).width(reqWidth);$(this).css({padding:0,margin:0,'padding-right':'5px','padding-top':'3px'});});$(".xf-dropdown a.trigger").each(function(){var atag=this;$(this).parent().find('ul li.selected > a').each(function(){$(atag).append(': '+$(this).text());$(atag).parent().addClass('selected');});}).append('<span class="arrow"></span>').click(function(){var atag=this;if($(this).hasClass('menu-visible')){$(this).removeClass('menu-visible');$(this).parent().find(">ul").slideUp('slow');$('body').unbind('click.xf-dropdown');}else{$(this).addClass('menu-visible');$(this).parent().find(">ul").each(function(){if($(atag).hasClass('horizontal-trigger')){var pos=$(atag).position();$(this).css('top',0).css('left',20);}
$(this).css('z-index',10000);}).slideDown('fast',function(){$('body').bind('click.xf-dropdown',function(){$(atag).trigger('click');});}).show();}
return false;}).hover(function(){$(this).addClass("subhover");},function(){$(this).removeClass("subhover");});var hasResultListCheckboxes=XataJax.actions.hasRecordSelectors($('.resultList'));var hasRelatedListCheckboxes=XataJax.actions.hasRecordSelectors($('.relatedList'));$('.selected-action a').each(function(){if(!hasResultListCheckboxes){$(this).parent().hide();}}).click(function(){XataJax.actions.handleSelectedAction(this,'.resultList');return false;});$('.related-selected-action a').each(function(){if(!hasRelatedListCheckboxes){$(this).parent().hide();}}).click(function(){XataJax.actions.handleSelectedAction(this,'.relatedList');return false;});$('.xf-button-bar').each(function(){var bar=this;var container=$(bar).parent();var containerOffset=$(container).offset();if(containerOffset==null)containerOffset={left:0,top:0};var parentWidth=$(container).width();var rightBound=containerOffset.left+parentWidth;var windowWidth=$(window).width();var pos=$(this).offset();var left=pos.left;var screenWidth=$(window).width();var outerWidth=$(this).outerWidth();var excess=outerWidth+pos.left-screenWidth;if(excess>0){var oldWidth=$(this).width();$(this).width(oldWidth-excess);var newWidth=oldWidth-excess;}
$(window).scroll(function(){var container=$(bar).parent();var containerOffset=$(container).offset();if(containerOffset==null)containerOffset={left:0,top:0};var leftMost=containerOffset.left;var rightMost=leftMost+$(container).innerWidth();var currMarginLeft=$(bar).css('margin-left');var scrollLeft=$(window).scrollLeft();if(scrollLeft<left){$(bar).css('margin-left',-30);$(bar).width(Math.min(newWidth+scrollLeft,$(container).innerWidth()-10));}else if(scrollLeft<excess+60){$(bar).css('margin-left',scrollLeft-left-30);}});});$('.list-view-menu').each(function(){var self=this;if($('.action-sub-menu',this).children().size()<2){$(self).hide();}});$('form h3.Dataface_collapsible_sidebar').each(function(){var siblings=$(this).parent().find('>h3.Dataface_collapsible_sidebar:visible');if(siblings.size()<=1)$(this).hide();});$('.xf-save-new-related-record a').click(function(){$('form input[name="-Save"]').click();return false;});$('.xf-save-new-record a').click(function(){$('form input[name="--session:save"]').click();return false;});$('.result-stats').each(function(){if($(this).hasClass('details-stats'))return;var resultStats=this;var isRelated=$(resultStats).hasClass('related-result-stats');var start=$('span.start',this).text().replace(/^\W+/,'').replace(/\W+$/);var end=$('span.end',this).text().replace(/^\W+/,'').replace(/\W+$/);var found=$('span.found',this).text().replace(/^\W+/,'').replace(/\W+$/);var limit=$('.limit-field input').val();start=parseInt(start)-1;end=parseInt(end);found=parseInt(found);limit=parseInt(limit);$(this).css('cursor','pointer');$(this).click(function(){var div=$('<div>').addClass('xf-change-limit-dialog');var label=$('<p>Show <input class="limitter" type="text" value="'+(limit)+'" size="2"/> per page starting at <input type="text" value="'+start+'" class="starter" size="2"/> </p>');$('input.limitter',label).change(function(){var query=XataJax.util.getRequestParams();var limitParam='-limit';if(isRelated){limitParam='-related:limit';}
query[limitParam]=$(this).val();window.location.href=XataJax.util.url(query);}).css({'font-size':'12px'});$('input.starter',label).change(function(){var query=XataJax.util.getRequestParams();var skipParam='-skip';if(isRelated){skipParam='-related:skip';}
query[skipParam]=$(this).val();window.location.href=XataJax.util.url(query);}).css({'font-size':'12px'});div.append(label);var offset=$(resultStats).offset();$('body').append(div);$(div).css({position:'absolute',top:offset.top+$(resultStats).height(),left:Math.min(offset.left,$(window).width()-275),'background-color':'#bbccff','z-index':1000,'padding':'2px 5px 2px 10px','border-radius':'5px'});$(div).show();$(div).click(function(e){e.preventDefault();e.stopPropagation();});function onBodyClick(){$(div).remove();$('body').unbind('click',onBodyClick);}
setTimeout(function(){$('body').bind('click',onBodyClick);},1000);});});$('.details-stats').each(function(){var resultStats=this;var cursor=$('span.cursor',this).text();var found=$('span.found',this).text();cursor=parseInt(cursor);found=parseInt(found);$(this).click(function(){var div=$('<div>').addClass('xf-change-limit-dialog');var label=$('<p>Show <input class="limitter" type="text" value="'+(cursor)+'" size="2"/> of '+found+' </p>');$('input.limitter',label).change(function(){var query=XataJax.util.getRequestParams();query['-cursor']=parseInt($(this).val())-1;window.location.href=XataJax.util.url(query);}).css({'font-size':'12px'});div.append(label);var offset=$(resultStats).offset();$('body').append(div);$(div).css({position:'absolute !important',top:offset.top+$(resultStats).height(),left:Math.min(offset.left,$(window).width()-150),'background-color':'#bbccff','z-index':1000,'padding':'2px 5px 2px 10px','border-radius':'5px'});$(div).show();$(div).click(function(e){e.preventDefault();e.stopPropagation();});function onBodyClick(){$(div).remove();$('body').unbind('click',onBodyClick);}
setTimeout(function(){$('body').bind('click',onBodyClick);},1000);}).css('cursor','pointer');});(function(){var searchField=$('.xf-search-field').parents('form').submit(function(){$(this).find(':input[value=""]').attr('disabled',true);});})();(function(){if(typeof(sessionStorage)=='undefined'){sessionStorage={};}
function parseString(str){var parts=str.split('&');var out=[];$.each(parts,function(){var kv=this.split('=');out[decodeURIComponent(kv[0])]=decodeURIComponent(kv[1]);});return out;}
var currTable=$('meta#xf-meta-tablename').attr('content');if(currTable){var currSearch=$('meta#xf-meta-search-query').attr('content');var currSearchUrl=window.location.href;var searchSelected=false;if(!currSearch){currSearch=sessionStorage['xf-currSearch-'+currTable+'-params'];currSearchUrl=sessionStorage['xf-currSearch-'+currTable+'-url'];}else{searchSelected=true;sessionStorage['xf-currSearch-'+currTable+'-params']=currSearch;sessionStorage['xf-currSearch-'+currTable+'-url']=currSearchUrl;}
if(currSearch){var item=$('<li>');if(searchSelected)item.addClass('selected');var a=$('<a>').attr('href',currSearchUrl).attr('title',_('themes.g2.VIEW_SEARCH_RESULTS','View Search results')).text(_('themes.g2.SEARCH_RESULTS','Search Results'));item.append(a);$('.tableQuicklinks').append(item);}
var currRecord=$('meta#xf-meta-record-title').attr('content');var currRecordUrl=window.location.href;var recordSelected=false;if(!currRecord){currRecord=sessionStorage['xf-currRecord-'+currTable+'-title'];currRecordUrl=sessionStorage['xf-currRecord-'+currTable+'-url'];}else{recordSelected=true;sessionStorage['xf-currRecord-'+currTable+'-title']=currRecord;sessionStorage['xf-currRecord-'+currTable+'-url']=currRecordUrl;}
var currRecordId=$('meta#xf-meta-record-id').attr('content');if(currRecordId){(function(){$('a.xf-related-record-link[data-xf-related-record-id]').click(function(){var idKey='xf-parent-of-'+$(this).attr('data-xf-related-record-id');var idUrl='xf-parent-of-url-'+$(this).attr('data-xf-related-record-id');var idTitle='xf-parent-of-title-'+$(this).attr('data-xf-related-record-id');sessionStorage[idKey]=currRecordId;sessionStorage[idUrl]=currRecordUrl;sessionStorage[idTitle]=currRecord;return true;});})();}
if(currRecord){var isChildRecord=false;if(currRecordId){(function(){var idKey='xf-parent-of-'+currRecordId;var idUrl='xf-parent-of-url-'+currRecordId;var idTitle='xf-parent-of-title-'+currRecordId;if(sessionStorage[idUrl]){var item=$('<li>');var a=$('<a>').attr('href',sessionStorage[idUrl]).attr('title',sessionStorage[idTitle]).text(sessionStorage[idTitle]);item.append(a);$('.tableQuicklinks').append(item);isChildRecord=true;}})();}
var item=$('<li>');if(recordSelected)item.addClass('selected');var a=$('<a>').attr('href',currRecordUrl).attr('title',currRecord).text(currRecord);if(isChildRecord){$(a).addClass('xf-child-record');}
item.append(a);$('.tableQuicklinks').append(item);}
var g2=XataJax.load('xataface.modules.g2');var advancedFindForm=new g2.AdvancedFind({});function handleShowAdvancedFind(){advancedFindForm.show();$(this).addClass('expanded').removeClass('collapsed');$(this).unbind('click',handleShowAdvancedFind);$(this).bind('click',handleHideAdvancedFind);};function handleHideAdvancedFind(){advancedFindForm.hide();$(this).addClass('collapsed').removeClass('expanded');$(this).unbind('click',handleHideAdvancedFind);$(this).bind('click',handleShowAdvancedFind);}
$('a.xf-show-advanced-find').bind('click',handleShowAdvancedFind);}})();});})();}
if(typeof(window.__xatajax_included__['xataface/widgets/datepicker.js'])=='undefined'){window.__xatajax_included__['xataface/widgets/datepicker.js']=true;(function(){var $=jQuery;var pickerAtts={'showOn':'string','showAnim':'string','showOptions':'object','defaultDate':'string','appendText':'string','buttonText':'string','buttonImage':'string','buttonImageOnly':'bool','hideIfNoPrevNext':'bool','navigationAsDateFormat':'bool','gotoCurrent':'bool','changeMonth':'bool','changeYear':'bool','yearRange':'string','showOtherMonths':'bool','selectOtherMonths':'bool','showWeek':'bool','calculateWeek':'object','shortYearCutoff':'string','minDate':'string','maxDate':'string','duration':'string','beforeShowDay':'object','beforeShow':'object','onSelect':'object','onChangeMonthYear':'object','onClose':'object','numberOfMonths':'int','showCurrentAtPos':'int','stepMonths':'int','stepBigMonths':'int','altField':'string','altFormat':'string','constrainInput':'bool','showButtonPanel':'bool','autoSize':'bool','firstDay':'int'};registerXatafaceDecorator(function(node){$('input.xf-datepicker',node).each(function(){var self=this;var p={dateFormat:''+$(this).attr('data-xf-date-format'),altFormat:''+$(this).attr('data-xf-date-format')};$.each(pickerAtts,function(k,v){var attKey='data-xf-datepicker-'+k;if($(self).attr(attKey)!==undefined){var val=$(self).attr(attKey);switch(v){case'string':p[k]=val;break;case'bool':p[k]=val==='true';break;case'int':p[k]=parseInt(val);break;case'object':p[k]=eval(val);break;}}});$(this).datepicker(p);});});})();}
if(typeof(window.__xatajax_included__['RecordDialog/RecordDialog.js'])=='undefined'){window.__xatajax_included__['RecordDialog/RecordDialog.js']=true;(function($){if(typeof(window.xataface)=='undefined'){window.xataface={};}
window.xataface.RecordDialog=RecordDialog;var _=xataface.lang.get;function RecordDialog(o){this.el=document.createElement('div');this.recordid=null;this.table=null;this.baseURL=DATAFACE_URL+'/js/RecordDialog';this.formChanged=false;for(var i in o)this[i]=o[i];this.marginH=this.marginH||25;this.marginW=this.marginW||25;};RecordDialog.version=1;RecordDialog.prototype={display:function(){var dialog=this;$(this.el).load(this.baseURL+'/templates/dialog.html',function(){var frame=$(this).find('.xf-RecordDialog-iframe').css({'width':'100%','height':'96%','padding':0,'margin':0,'border':'none'}).attr('src',dialog.getURL());$(frame).hide();frame.load(function(){$(frame).hide();dialog.formChanged=false;var iframe=$(this).contents();try{var parsed=null;eval('parsed = '+iframe.text()+';');if(parsed['response_code']==200){if(dialog.callback){dialog.callback(parsed['record_data']);}
$(dialog.el).dialog('close');if(parsed['response_message']){dialog.showResponseMessage(parsed['response_message']);}
return;}}catch(err){}
var portalMessage=iframe.find('.portalMessage');portalMessage.detach();iframe.find('.xf-button-bar').remove();var dc=iframe.find('.documentContent').first();if(dc.length==0)dc=iframe.find('#main_section');if(dc.length==0)dc=iframe.find('#main_column');dc.remove();dc.prepend(portalMessage);var ibody=iframe.find('body');var hidden=$(':hidden',ibody);iframe.find('body').addClass('RecordDialogBody').empty();$('script',dc).remove();dc.appendTo(ibody);hidden.each(function(){if(this.tagName=='SCRIPT'){return;}
$('script',this).remove();$(this).appendTo(ibody);$(this).hide();});$('#details-controller, .contentViews, .contentActions, .insert-record-label, .edit-record-label',ibody).hide();$(ibody).css('background-color','transparent');$('.documentContent',ibody).css({'border':'none','margin':0,'padding':0,'background-color':'transparent','overflow':'scroll'});$(frame).fadeIn(function(){dc.height($(frame).parent().innerHeight()-25);});$('input, textarea, select',ibody).change(function(){dialog.formChanged=true;});});});$(this.el).appendTo('body');$('body').addClass('stop-scrolling');var buttons=[{text:_('RecordDialog.OK_BUTTON_LABEL','OK'),click:function(){if(dialog.callback){dialog.callback();}
$(this).dialog('close');}}];$(this.el).dialog({beforeClose:function(){$('body').removeClass('stop-scrolling')
if(dialog.formChanged){return confirm('You have unsaved changes.  Clicking "OK" will discard these changes.  Do you wish to proceed?');}},height:dialog.height||$(window).height()-dialog.marginH,width:dialog.width||$(window).width()-dialog.marginW,title:dialog.title||(this.recordid?'Edit '+this.table+' Record':'Create New '+this.table+' Record'),modal:true});},getURL:function(){var action;if(!this.recordid){action='new';}else{action='edit';}
var url=DATAFACE_SITE_HREF+'?-table='+encodeURIComponent(this.table)+(this.recordid?'&-recordid='+encodeURIComponent(this.recordid):'')+'&-action='+encodeURIComponent(action)+'&-response=json';if(typeof(this.params)=='object'){$.each(this.params,function(key,val){url+='&'+encodeURIComponent(key)+'='+encodeURIComponent(val);});}
return url;},showResponseMessage:function(msg){alert(msg);}};RecordDialog.constructor=RecordDialog;$.fn.RecordDialog=function(options){return this.each(function(){$(this).click(function(){var RecordDialog=xataface.RecordDialog;try{if(xataface.RecordDialog.version===window.top.xataface.RecordDialog.version){RecordDialog=window.top.xataface.RecordDialog;}}catch(e){}
var d=new RecordDialog(options);d.display();});});};})(jQuery);}
if(typeof(window.__xatajax_included__['xataface/widgets/lookup.js'])=='undefined'){window.__xatajax_included__['xataface/widgets/lookup.js']=true;if(typeof(window.__xatajax_included__['RecordBrowser/RecordBrowser.js'])=='undefined'){window.__xatajax_included__['RecordBrowser/RecordBrowser.js']=true;if(typeof(window.__xatajax_included__['xataface/Permissions.js'])=='undefined'){window.__xatajax_included__['xataface/Permissions.js']=true;(function(){var $=jQuery;var xataface=XataJax.load('xataface');xataface.Permissions=Permissions;function Permissions(o){this.query=null;this.permissions=null;if(typeof(o)=='undefined')o={};$.extend(this,o);}
$.extend(Permissions.prototype,{load:load,ready:ready,checkPermission:checkPermission,getPermissions:getPermissions,setQuery:setQuery,getQuery:getQuery});function load(callback){if(!this.query){throw"No query provided for permissions";}
this.query['-action']='ajax_get_permissions';if(!callback)callback=function(){};var self=this;$.get(DATAFACE_SITE_HREF,this.query,function(res){self.permissions=res;callback.call(self);});}
function ready(callback){if(typeof(callback)=='undefined')callback=function(){};if(this.permissions!=null){callback.call(this);}else{this.load(callback);}}
function checkPermission(perm){if(this.permissions!=null){return this.permissions[perm]?true:false;}
return false;}
function getPermissions(){return this.permissions;}
function setQuery(q){this.query=q;this.permissions=null;}
function getQuery(){return this.query;}})();}
(function($){if(typeof(console)=='undefined')console={'log':function(){}};if(typeof(console.log)=='undefined')console.log=function(){};var xataface=XataJax.load('xataface');xataface.RecordBrowser=function(o){this.table=null;this.value=null;this.text=null;this.filters={};this.callback=null;this.editParams={};this.newParams={};this.el=document.createElement('div');this.baseURL=DATAFACE_URL+'/js/RecordBrowser';this.allowAddNew=true;for(var i in o){this[i]=o[i];}
this.dirty=true;}
xataface.RecordBrowser.prototype={display:function(){var rb=this;$('body').append(this.el);$(this.el).load(this.baseURL+'/templates/RecordBrowser.html',function(){var dialog=this;var searchChangeHandler=function(){var val=$(this).val();var self=this;setTimeout(function(){if(val!=$(self).val()){return;}
rb.filterRecords({'-search':$(self).val()});},500);};$(this).find('.xf-RecordBrowser-search-field').keyup(searchChangeHandler).change(searchChangeHandler);$(this).find('.xf-RecordBrowser-select-field').css('width','100%').attr('size',8);if(rb.allowAddNew){$(this).find('.xf-RecordBrowser-addnew-button').RecordDialog({table:rb.table,callback:function(){rb.dirty=true;rb.updateRecords();},params:rb.newParams,width:rb.width,height:rb.height,marginW:rb.marginW,marginH:rb.marginH});}else{$(this).find('.xf-RecordBrowser-addnew-button').hide();}
$(this).dialog({'title':'Select Record','buttons':{'Select':function(){var out={};$(dialog).find('.xf-RecordBrowser-select-field :selected').each(function(i,selected){out[$(selected).attr('value')]=$(selected).text();});if(rb.callback)rb.callback(out);$(this).dialog("close");},'Cancel':function(){$(this).dialog("close");}},'modal':true,'resize':function(event,ui){$(dialog).find('.xf-RecordBrowser-select-field').css('height',($(dialog).height()-60)+'px');}});rb.updateRecords();});},filterRecords:function(filter){for(var i in filter){if(this.filters[i]!=filter[i])this.dirty=true;this.filters[i]=filter[i];}
this.updateRecords();},updateRecords:function(){if(this.dirty){var sel=$(this.el).find('.xf-RecordBrowser-select-field');var val=$(sel).val();sel.load(this.getDataURL(),function(){sel.val(val);});this.dirty=false;}},getDataURL:function(){var url=DATAFACE_SITE_HREF+'?-action=RecordBrowser_data&-table='+encodeURIComponent(this.table);if(this.value)url+='&-value='+encodeURIComponent(this.value);if(this.text)url+='&-text='+encodeURIComponent(this.text);for(var i in this.filters){url+='&'+encodeURIComponent(i)+'='+encodeURIComponent(this.filters[i]);}
return url;}};$.fn.RecordBrowser=function(options){return this.each(function(){var obj=$(this);obj.click(function(){if(typeof(options.click)=='function'){options.click();}
var rb=new xataface.RecordBrowser(options);rb.display();});});};$.fn.RecordBrowserWidget=function(options){return this.each(function(){var obj=$(this);var editable=options.editable||false;if(obj.hasClass("xf-RecordBrowserWidget")){var oldDisplayField=obj.next();var oldButton=oldDisplayField.next();oldDisplayField.remove();oldButton.remove();obj.removeClass('xf-RecordBrowserWidget');}
var displayField=document.createElement('input');$(displayField).attr('type','text').addClass('xf-RecordBrowserWidget-displayField').css('cursor','pointer').attr('readonly',1);$(displayField).insertAfter(this);obj.css('display','none').addClass('xf-RecordBrowserWidget');function updateEditable(){if(editable)$(editButton).show();else $(editButton).hide();}
function updatePermissions(){try{var theq={'-table':options.table};if(options.value&&options.value!='__id__'){theq[options.value]=obj.val();}else{theq['--id']=obj.val();}
var perms=new xataface.Permissions({query:theq});perms.ready(function(){if(perms.checkPermission('edit')){editable=true;}else{editable=false;}
updateEditable();});}catch(e){console.log('Looks like xataface.Permissions is not loaded while handling RecordBrowser change event.');console.log(e);}}
if(!options.frozen){obj.change(function(){var id;if(options.value&&options.value!='__id__'){id=encodeURIComponent(options.value)+'='+encodeURIComponent(obj.val());}else{id=obj.val();}
var url=DATAFACE_SITE_HREF+'?-action=RecordBrowser_lookup_single&-table='+options.table+'&-id='+encodeURIComponent(id);if(options.text)url+='&-text='+encodeURIComponent(options.text);$.get(url,function(text){$(displayField).val(text);});updatePermissions();});var a=document.createElement('a');$(a).addClass('xf-RecordBrowser-button').css('cursor','pointer').html('<img src="'+DATAFACE_URL+'/images/search_icon.gif" border="0" /><span class="xf-RecordBrowser-button-label"> Lookup</span>');$(a).find('.xf-RecordBrowser-button-label').css('display','none');$(a).insertAfter(displayField);var editButton=$('<a>').addClass('xf-RecordBrowser-edit-button').html('<img src="'+DATAFACE_URL+'/images/edit.gif" border="0" /><span class="xf-RecordBrowser-button-label">Edit</span>').css({cursor:'hand'});$(editButton).find('.xf-RecordBrowser-button-label').css('display','none');$(editButton).click(function(){if(!editable){alert('This record is not currently editable.');}
var id=obj.val();if(!id){alert('No record is currently selected.');return;}
var keyColName='__id__';if(options.value){keyColName=options.value;}
var recordid=encodeURIComponent(options.table)+'?'+encodeURIComponent(keyColName)+'='+encodeURIComponent(id);var RecordDialog=xataface.RecordDialog;try{if(xataface.RecordDialog.version===window.top.xataface.RecordDialog.version){RecordDialog=window.top.xataface.RecordDialog;}}catch(e){}
var dlg=new RecordDialog({recordid:recordid,table:options.table,params:options.editParams||{},width:options.width,height:options.height,marginW:options.marginW,marginH:options.marginH});dlg.display();});$(editButton).insertAfter(a);$(editButton).hide();var origCallback=function(){};if(typeof(options.callback=='function')){origCallback=options.callback;}
options.callback=function(vals){for(var i in vals){obj.val(i);obj.trigger('change');}
origCallback(vals,obj);};$(a).RecordBrowser(options);$(displayField).RecordBrowser(options);}else{}
if(obj.val()){var id;if(options.value&&options.value!='__id__'){id=encodeURIComponent(options.value)+'='+encodeURIComponent(obj.val());}else{id=obj.val();}
var url=DATAFACE_SITE_HREF+'?-action=RecordBrowser_lookup_single&-table='+options.table+'&-id='+encodeURIComponent(id);if(options.text)url+='&-text='+encodeURIComponent(options.text);$.get(url,function(text){$(displayField).val(text);});if(typeof(updatePermissions)!=='undefined'){updatePermissions();}}});};})(jQuery);}
(function(){var $=jQuery;registerXatafaceDecorator(function(node){$('.xf-lookup',node).each(function(){var options={};if($(this).attr('data-xf-lookup-options')){eval('options='+$(this).attr('data-xf-lookup-options')+';');}
if(!options.filters)options.filters={};options.dynFilters={};$.each(options.filters,function(key,val){if(val.indexOf("$")==0){options.dynFilters[key]=val.substr(1);delete options.filters[key];}});if(options.callback){eval('options.callback='+options.callback+';');}
options.click=function(){$.each(options.dynFilters,function(key,val){delete options.filters[key];$("form *[name="+val+"]").each(function(){options.filters[key]=$(this).val();});});};$(this).RecordBrowserWidget(options);});});})();}
if(typeof(XataJax)!="undefined")XataJax.ready();