if(typeof(window.console)=='undefined'){window.console={log:function(str){}};}if(typeof(window.__xatajax_included__)!='object'){window.__xatajax_included__={};};(function(){var headtg=document.getElementsByTagName("head")[0];if(!headtg)return;var linktg=document.createElement("link");linktg.type="text/css";linktg.rel="stylesheet";linktg.href="/TPTracker/index.php?-action=css&--id=switch_use-a79fe9d72a44acc550f2606d1cda88a2";linktg.title="Styles";headtg.appendChild(linktg);})();if(typeof(window.__xatajax_included__['xataface/modules/g2/global.js'])=='undefined'){window.__xatajax_included__['xataface/modules/g2/global.js']=true;if(typeof(window.__xatajax_included__['xatajax.actions.js'])=='undefined'){window.__xatajax_included__['xatajax.actions.js']=true;if(typeof(window.__xatajax_included__['xatajax.form.core.js'])=='undefined'){window.__xatajax_included__['xatajax.form.core.js']=true;(function(){var $=jQuery;XataJax.form={findField:findField,createForm:createForm,submitForm:submitForm};function findField(startNode,fieldName){var field=null;$(startNode).parents('.xf-form-group').each(function(){if(field){return;}
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
if(typeof(window.__xatajax_included__['xataface/modules/switch_user/switch_user.js'])=='undefined'){window.__xatajax_included__['xataface/modules/switch_user/switch_user.js']=true;(function(){function _(key,defaultValue){if(xataface&&xataface.strings&&xataface.strings[key]){return xataface.strings[key];}else{return defaultValue;}}
var initSwitchUser;var $=jQuery;jQuery(document).ready(function($){var userbar=document.createElement('div');$(userbar).attr('id','switch-user-menu');$(userbar).html(_('switch_user.label.logged_in_as','Logged in as <span id="switch-user-username">&nbsp;</span>.')+' <a href="#" id="switch-user-btn" title="'+
_('switch_user.label.switch_user','Switch User')+'"><span>'+
_('switch_user.label.switch_user','Switch User')+'</span></a>');var usernameSpan=$('#switch-user-username',userbar).get(0);var switchUserBtn=$('#switch-user-btn',userbar).get(0);var isOriginalUser=true;function restoreToOriginalUser(){$.post(DATAFACE_SITE_HREF,{'-action':'switch_user','--restore':1},function(response){try{if(typeof(response)=='string'){eval('response='+response+';');}
if(response.code==200){$(usernameSpan).html(response.username);window.location.reload();}else{throw response.msg;}}catch(e){alert(e);}});}
function switchUser(username){$.post(DATAFACE_SITE_HREF,{'-action':'switch_user','--username':username},function(response){try{if(typeof(response)=='string'){eval('response='+response+';');}
if(response.code==200){$(usernameSpan).html(response.username);window.location.reload();}else{throw response.msg;}}catch(e){alert(e);}});}
initSwitchUser=function(username,isOriginal){$(usernameSpan).html(username);$('body').append(userbar);isOriginalUser=isOriginal;if(!isOriginalUser){$(userbar).addClass('non-original-user');}}
$(switchUserBtn).click(function(){if(isOriginalUser){var user=prompt(_('switch_user.message.enter_username','Please enter the name of the user you wish to switch to.'),_('switch_user.label.username','Username'));if(user){switchUser(user);}}else{if(confirm(_('switch_user.message.are_you_sure','Are you sure you want to exit this user account and return to your own account?'))){restoreToOriginalUser();}}
return false;});$.get(DATAFACE_SITE_HREF,{'-action':'switch_user_status'},function(response){try{if(response.username){initSwitchUser(response.username,response.isOriginal);}}catch(e){}});});})();}
if(typeof(window.__xatajax_included__['xataface/modules/summary/summary-page.js'])=='undefined'){window.__xatajax_included__['xataface/modules/summary/summary-page.js']=true;if(typeof(window.__xatajax_included__['multiselect-widget.min.js'])=='undefined'){window.__xatajax_included__['multiselect-widget.min.js']=true;(function(d){var i=0;d.widget("ech.multiselect",{options:{header:!0,height:175,minWidth:225,classes:"",checkAllText:"Check all",uncheckAllText:"Uncheck all",noneSelectedText:"Select options",selectedText:"# selected",selectedList:0,show:"",hide:"",autoOpen:!1,multiple:!0,position:{}},_create:function(){var a=this.element.hide(),b=this.options;this.speed=d.fx.speeds._default;this._isOpen=!1;a=(this.button=d('<button type="button"><span class="ui-icon ui-icon-triangle-2-n-s"></span></button>')).addClass("ui-multiselect ui-widget ui-state-default ui-corner-all").addClass(b.classes).attr({title:a.attr("title"),"aria-haspopup":!0,tabIndex:a.attr("tabIndex")}).insertAfter(a);(this.buttonlabel=d("<span />")).html(b.noneSelectedText).appendTo(a);var a=(this.menu=d("<div />")).addClass("ui-multiselect-menu ui-widget ui-widget-content ui-corner-all").addClass(b.classes).insertAfter(a),c=(this.header=d("<div />")).addClass("ui-widget-header ui-corner-all ui-multiselect-header ui-helper-clearfix").appendTo(a);(this.headerLinkContainer=d("<ul />")).addClass("ui-helper-reset").html(function(){return b.header===!0?'<li><a class="ui-multiselect-all" href="#"><span class="ui-icon ui-icon-check"></span><span>'+b.checkAllText+'</span></a></li><li><a class="ui-multiselect-none" href="#"><span class="ui-icon ui-icon-closethick"></span><span>'+b.uncheckAllText+"</span></a></li>":typeof b.header==="string"?"<li>"+b.header+"</li>":""}).append('<li class="ui-multiselect-close"><a href="#" class="ui-multiselect-close"><span class="ui-icon ui-icon-circle-close"></span></a></li>').appendTo(c);(this.checkboxContainer=d("<ul />")).addClass("ui-multiselect-checkboxes ui-helper-reset").appendTo(a);this._bindEvents();this.refresh(!0);b.multiple||a.addClass("ui-multiselect-single")},_init:function(){this.options.header===!1&&this.header.hide();this.options.multiple||this.headerLinkContainer.find(".ui-multiselect-all, .ui-multiselect-none").hide();this.options.autoOpen&&this.open();this.element.is(":disabled")&&this.disable()},refresh:function(a){var b=this.options,c=this.menu,e=this.checkboxContainer,h=[],f=[],g=this.element.attr("id")||i++;this.element.find("option").each(function(a){d(this);var e=this.parentNode,c=this.innerHTML,i=this.value,a=this.id||"ui-multiselect-"+g+"-option-"+a,j=this.disabled,l=this.selected,k=["ui-corner-all"];e.tagName.toLowerCase()==="optgroup"&&(e=e.getAttribute("label"),d.inArray(e,h)===-1&&(f.push('<li class="ui-multiselect-optgroup-label"><a href="#">'+e+"</a></li>"),h.push(e)));j&&k.push("ui-state-disabled");l&&!b.multiple&&k.push("ui-state-active");f.push('<li class="'+(j?"ui-multiselect-disabled":"")+'">');f.push('<label for="'+a+'" class="'+k.join(" ")+'">');f.push('<input id="'+a+'" name="multiselect_'+g+'" type="'+(b.multiple?"checkbox":"radio")+'" value="'+i+'" title="'+c+'"');l&&(f.push(' checked="checked"'),f.push(' aria-selected="true"'));j&&(f.push(' disabled="disabled"'),f.push(' aria-disabled="true"'));f.push(" /><span>"+c+"</span></label></li>")});e.html(f.join(""));this.labels=c.find("label");this._setButtonWidth();this._setMenuWidth();this.button[0].defaultValue=this.update();a||this._trigger("refresh")},update:function(){var a=this.options,b=this.labels.find("input"),c=b.filter(":checked"),e=c.length,a=e===0?a.noneSelectedText:d.isFunction(a.selectedText)?a.selectedText.call(this,e,b.length,c.get()):/\d/.test(a.selectedList)&&a.selectedList>0&&e<=a.selectedList?c.map(function(){return this.title}).get().join(", "):a.selectedText.replace("#",e).replace("#",b.length);this.buttonlabel.html(a);return a},_bindEvents:function(){function a(){b[b._isOpen?"close":"open"]();return!1}var b=this,c=this.button;c.find("span").bind("click.multiselect",a);c.bind({click:a,keypress:function(a){switch(a.which){case 27:case 38:case 37:b.close();break;case 39:case 40:b.open()}},mouseenter:function(){c.hasClass("ui-state-disabled")||d(this).addClass("ui-state-hover")},mouseleave:function(){d(this).removeClass("ui-state-hover")},focus:function(){c.hasClass("ui-state-disabled")||d(this).addClass("ui-state-focus")},blur:function(){d(this).removeClass("ui-state-focus")}});this.header.delegate("a","click.multiselect",function(a){if(d(this).hasClass("ui-multiselect-close"))b.close();else b[d(this).hasClass("ui-multiselect-all")?"checkAll":"uncheckAll"]();a.preventDefault()});this.menu.delegate("li.ui-multiselect-optgroup-label a","click.multiselect",function(a){a.preventDefault();var c=d(this),f=c.parent().nextUntil("li.ui-multiselect-optgroup-label").find("input:visible:not(:disabled)"),g=f.get(),c=c.parent().text();b._trigger("beforeoptgrouptoggle",a,{inputs:g,label:c})!==!1&&(b._toggleChecked(f.filter(":checked").length!==f.length,f),b._trigger("optgrouptoggle",a,{inputs:g,label:c,checked:g[0].checked}))}).delegate("label","mouseenter.multiselect",function(){d(this).hasClass("ui-state-disabled")||(b.labels.removeClass("ui-state-hover"),d(this).addClass("ui-state-hover").find("input").focus())}).delegate("label","keydown.multiselect",function(a){a.preventDefault();switch(a.which){case 9:case 27:b.close();break;case 38:case 40:case 37:case 39:b._traverse(a.which,this);break;case 13:d(this).find("input")[0].click()}}).delegate('input[type="checkbox"], input[type="radio"]',"click.multiselect",function(a){var c=d(this),f=this.value,g=this.checked,i=b.element.find("option");this.disabled||b._trigger("click",a,{value:f,text:this.title,checked:g})===!1?a.preventDefault():(c.attr("aria-selected",g),i.each(function(){if(this.value===f)this.selected=g;else if(!b.options.multiple)this.selected=!1}),b.options.multiple||(b.labels.removeClass("ui-state-active"),c.closest("label").toggleClass("ui-state-active",g),b.close()),setTimeout(d.proxy(b.update,b),10))});d(document).bind("mousedown.multiselect",function(a){b._isOpen&&!d.contains(b.menu[0],a.target)&&!d.contains(b.button[0],a.target)&&a.target!==b.button[0]&&b.close()});d(this.element[0].form).bind("reset.multiselect",function(){setTimeout(function(){b.update()},10)})},_setButtonWidth:function(){var a=this.element.outerWidth(),b=this.options;if(/\d/.test(b.minWidth)&&a<b.minWidth)a=b.minWidth;this.button.width(a)},_setMenuWidth:function(){var a=this.menu,b=this.button.outerWidth()-parseInt(a.css("padding-left"),10)-parseInt(a.css("padding-right"),10)-parseInt(a.css("border-right-width"),10)-parseInt(a.css("border-left-width"),10);a.width(b||this.button.outerWidth())},_traverse:function(a,b){var c=d(b),e=a===38||a===37,c=c.parent()[e?"prevAll":"nextAll"]("li:not(.ui-multiselect-disabled, .ui-multiselect-optgroup-label)")[e?"last":"first"]();c.length?c.find("label").trigger("mouseover"):(c=this.menu.find("ul:last"),this.menu.find("label")[e?"last":"first"]().trigger("mouseover"),c.scrollTop(e?c.height():0))},_toggleCheckbox:function(a,b){return function(){!this.disabled&&(this[a]=b);b?this.setAttribute("aria-selected",!0):this.removeAttribute("aria-selected")}},_toggleChecked:function(a,b){var c=b&&b.length?b:this.labels.find("input"),e=this;c.each(this._toggleCheckbox("checked",a));this.update();var h=c.map(function(){return this.value}).get();this.element.find("option").each(function(){!this.disabled&&d.inArray(this.value,h)>-1&&e._toggleCheckbox("selected",a).call(this)})},_toggleDisabled:function(a){this.button.attr({disabled:a,"aria-disabled":a})[a?"addClass":"removeClass"]("ui-state-disabled");this.menu.find("input").attr({disabled:a,"aria-disabled":a}).parent()[a?"addClass":"removeClass"]("ui-state-disabled");this.element.attr({disabled:a,"aria-disabled":a})},open:function(){var a=this.button,b=this.menu,c=this.speed,e=this.options;if(!(this._trigger("beforeopen")===!1||a.hasClass("ui-state-disabled")||this._isOpen)){var h=b.find("ul:last"),f=e.show,g=a.position();d.isArray(e.show)&&(f=e.show[0],c=e.show[1]||this.speed);h.scrollTop(0).height(e.height);d.ui.position&&!d.isEmptyObject(e.position)?(e.position.of=e.position.of||a,b.show().position(e.position).hide().show(f,c)):b.css({top:g.top+a.outerHeight(),left:g.left}).show(f,c);this.labels.eq(0).trigger("mouseover").trigger("mouseenter").find("input").trigger("focus");a.addClass("ui-state-active");this._isOpen=!0;this._trigger("open")}},close:function(){if(this._trigger("beforeclose")!==!1){var a=this.options,b=a.hide,c=this.speed;d.isArray(a.hide)&&(b=a.hide[0],c=a.hide[1]||this.speed);this.menu.hide(b,c);this.button.removeClass("ui-state-active").trigger("blur").trigger("mouseleave");this._isOpen=!1;this._trigger("close")}},enable:function(){this._toggleDisabled(!1)},disable:function(){this._toggleDisabled(!0)},checkAll:function(){this._toggleChecked(!0);this._trigger("checkAll")},uncheckAll:function(){this._toggleChecked(!1);this._trigger("uncheckAll")},getChecked:function(){return this.menu.find("input").filter(":checked")},destroy:function(){d.Widget.prototype.destroy.call(this);this.button.remove();this.menu.remove();this.element.show();return this},isOpen:function(){return this._isOpen},widget:function(){return this.menu},_setOption:function(a,b){var c=this.menu;switch(a){case"header":c.find("div.ui-multiselect-header")[b?"show":"hide"]();break;case"checkAllText":c.find("a.ui-multiselect-all span").eq(-1).text(b);break;case"uncheckAllText":c.find("a.ui-multiselect-none span").eq(-1).text(b);break;case"height":c.find("ul:last").height(parseInt(b,10));break;case"minWidth":this.options[a]=parseInt(b,10);this._setButtonWidth();this._setMenuWidth();break;case"selectedText":case"selectedList":case"noneSelectedText":this.options[a]=b;this.update();break;case"classes":c.add(this.button).removeClass(this.options.classes).addClass(b)}d.Widget.prototype._setOption.apply(this,arguments)}})})(jQuery);(function($){var rEscape=/[\-\[\]{}()*+?.,\\^$|#\s]/g;$.widget("ech.multiselectfilter",{options:{label:"Filter:",width:null,placeholder:"Enter keywords"},_create:function(){var self=this,opts=this.options,instance=(this.instance=$(this.element).data("multiselect")),header=(this.header=instance.menu.find(".ui-multiselect-header").addClass("ui-multiselect-hasfilter")),wrapper=(this.wrapper=$('<div class="ui-multiselect-filter">'+(opts.label.length?opts.label:'')+'<input placeholder="'+opts.placeholder+'" type="search"'+(/\d/.test(opts.width)?'style="width:'+opts.width+'px"':'')+' /></div>').prependTo(this.header));this.inputs=instance.menu.find('input[type="checkbox"], input[type="radio"]');this.input=wrapper.find("input").bind({keydown:function(e){if(e.which===13){e.preventDefault();}},keyup:$.proxy(self._handler,self),click:$.proxy(self._handler,self)});this.updateCache();instance._toggleChecked=function(flag,group){var $inputs=(group&&group.length)?group:this.labels.find('input'),_self=this,selector=self.instance._isOpen?":disabled, :hidden":":disabled";$inputs=$inputs.not(selector).each(this._toggleCheckbox('checked',flag));this.update();var values=$inputs.map(function(){return this.value;}).get();this.element.find('option').filter(function(){if(!this.disabled&&$.inArray(this.value,values)>-1){_self._toggleCheckbox('selected',flag).call(this);}});};$(document).bind("multiselectrefresh",function(){self.updateCache();self._handler();});},_handler:function(e){var term=$.trim(this.input[0].value.toLowerCase()),rows=this.rows,inputs=this.inputs,cache=this.cache;if(!term){rows.show();}else{rows.hide();var regex=new RegExp(term.replace(rEscape,"\\$&"),'gi');this._trigger("filter",e,$.map(cache,function(v,i){if(v.search(regex)!==-1){rows.eq(i).show();return inputs.get(i);}
return null;}));}
this.instance.menu.find(".ui-multiselect-optgroup-label").each(function(){var $this=$(this);$this[$this.nextUntil('.ui-multiselect-optgroup-label').filter(':visible').length?'show':'hide']();});},updateCache:function(){this.rows=this.instance.menu.find(".ui-multiselect-checkboxes li:not(.ui-multiselect-optgroup-label)");this.cache=this.element.children().map(function(){var self=$(this);if(this.tagName.toLowerCase()==="optgroup"){self=self.children();}
if(!self.val().length){return null;}
return self.map(function(){return this.innerHTML.toLowerCase();}).get();}).get();},widget:function(){return this.wrapper;},destroy:function(){$.Widget.prototype.destroy.call(this);this.input.val('').trigger("keyup");this.wrapper.remove();}});})(jQuery);}
(function(){var getRequestParams=XataJax.util.getRequestParams;var $=jQuery;var groupBySelect=$('div.summary-group-by-columns-form select');var summaryColsSelect=$('div.summary-summarized-columns-form select');var refreshBtn=$('#refresh-button');groupBySelect.multiselect({selectedText:"Grouping by # of # fields",noneSelectedText:"Select fields to group by"});summaryColsSelect.multiselect({selectedText:"Reporting # Summary Fields",noneSelectedText:"Select Summary Fields",});function refreshList(){var groupByStr=(groupBySelect.val()||[]).join(',');var summaryColsStr=(summaryColsSelect.val()||[]).join(',');requestParams=getRequestParams();requestParams['-group-by']=groupByStr;requestParams['-summary-cols']=summaryColsStr;var url=XataJax.util.url(requestParams);window.location.href=XataJax.util.url(requestParams);return;}
refreshBtn.click(refreshList);})();}
if(typeof(XataJax)!="undefined")XataJax.ready();