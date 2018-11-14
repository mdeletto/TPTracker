<?php /* Smarty version 2.6.18, created on 2017-06-12 08:26:48
         compiled from xataface/actions/view_related_record.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'use_macro', 'xataface/actions/view_related_record.html', 2, false),array('block', 'fill_slot', 'xataface/actions/view_related_record.html', 3, false),array('block', 'define_slot', 'xataface/actions/view_related_record.html', 44, false),array('block', 'collapsible_sidebar', 'xataface/actions/view_related_record.html', 51, false),array('block', 'translate', 'xataface/actions/view_related_record.html', 240, false),array('modifier', 'escape', 'xataface/actions/view_related_record.html', 10, false),array('modifier', 'count', 'xataface/actions/view_related_record.html', 28, false),array('function', 'record_view', 'xataface/actions/view_related_record.html', 14, false),array('function', 'actions_menu', 'xataface/actions/view_related_record.html', 17, false),array('function', 'block', 'xataface/actions/view_related_record.html', 43, false),array('function', 'glance_list', 'xataface/actions/view_related_record.html', 68, false),)), $this); ?>
<?php if ($this->_tpl_vars['ENV']['resultSet']->found() > 0): ?>
    <?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Record_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php $this->_tag_stack[] = array('fill_slot', array('name' => 'record_content')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <div class="view-related-record-wrapper">
        	
        
            <div class="subrecord-tabs">
            	<ul>
                <?php $_from = $this->_tpl_vars['related_record']->toRecords(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['subrecord']):
?>
                	<li><a href="#tabs-<?php echo $this->_tpl_vars['k']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['subrecord']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></li>
                <?php endforeach; endif; unset($_from); ?>
                </ul>
                <?php $_from = $this->_tpl_vars['related_record']->toRecords(true); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['subrecord']):
?>
                    <?php echo $this->_plugins['function']['record_view'][0][0]->record_view(array('var' => 'subrv','record' => $this->_tpl_vars['subrecord']), $this);?>

                    <div class="view-tab-content view-mode" id="tabs-<?php echo $this->_tpl_vars['k']; ?>
" data-iframe-url="<?php echo ((is_array($_tmp=$this->_tpl_vars['subrecord']->getURL('-action=edit'))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" data-portal-id="<?php echo ((is_array($_tmp=$this->_tpl_vars['related_record']->getId())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                    	<div class="xf-button-bar-actions edit-related-record-actions-wrapper">
							<?php echo $this->_plugins['function']['actions_menu'][0][0]->actions_menu(array('record' => $this->_tpl_vars['subrecord'],'category' => 'edit_related_record_actions','maxcount' => 7), $this);?>

						</div>
						<div style="clear:both; height: 1px;"></div>
                    	<div class="record-view-wrapper">
                    		<div class="xf-button-bar-actions view-related-records-actions-wrapper">
								<?php echo $this->_plugins['function']['actions_menu'][0][0]->actions_menu(array('record' => $this->_tpl_vars['subrecord'],'category' => 'view_related_record_actions','maxcount' => 7), $this);?>

							</div>
							<div style="clear:both; height: 1px;"></div>
							<table class="view-record-columns" width="100%">
								<tr>
									<td id="dataface-sections-left-column" valign="top">
										<div class="dataface-sections-count-<?php echo count($this->_tpl_vars['subrv']->sections); ?>
 dataface-sections-left<?php if ($this->_tpl_vars['subrv']->showLogo): ?> dataface-sections-left-with-logo<?php endif; ?>" id="dataface-sections-left">
											<?php if ($this->_tpl_vars['subrv']->showLogo): ?>
												<?php if (count($this->_tpl_vars['subrv']->logos) > 0): ?>
													<?php $_from = $this->_tpl_vars['subrv']->logos; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['logo']):
?>
														<div class="dataface-view-logo">
														<?php echo $this->_tpl_vars['related_record']->htmlValue($this->_tpl_vars['logo']['name']); ?>

														</div>
													<?php endforeach; endif; unset($_from); ?>
												<?php else: ?>
													<div class="dataface-view-logo">
													<img src="<?php echo $this->_tpl_vars['ENV']['DATAFACE_URL']; ?>
/images/missing_logo.gif" alt="Missing Logo"/>
													</div>
												<?php endif; ?>
												
											<?php endif; ?>
											<?php echo $this->_plugins['function']['block'][0][0]->block(array('record' => $this->_tpl_vars['subrecord'],'table' => $this->_tpl_vars['subrecord']->_table->tablename,'name' => 'before_record_actions'), $this);?>

											<?php $this->_tag_stack[] = array('define_slot', array('table' => $this->_tpl_vars['subrecord']->_table->tablename,'name' => 'record_actions')); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
											
											<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
											<?php echo $this->_plugins['function']['block'][0][0]->block(array('record' => $this->_tpl_vars['subrecord'],'table' => $this->_tpl_vars['subrecord']->_table->tablename,'name' => 'after_record_actions'), $this);?>

											
											<?php $_from = $this->_tpl_vars['subrv']->sections; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['section']):
?>
												<?php if ($this->_tpl_vars['section']['class'] == 'left'): ?>
												<?php $this->_tag_stack[] = array('collapsible_sidebar', array('heading' => $this->_tpl_vars['section']['label'],'see_all' => $this->_tpl_vars['section']['url'],'edit_url' => $this->_tpl_vars['section']['edit_url'],'movable' => 1,'id' => $this->_tpl_vars['section']['name'],'prefix' => 'leftsidebar','oncollapse' => "DatafaceSections.oncollapse(this)",'onexpand' => "DatafaceSections.onexpand(this)",'display' => $this->_tpl_vars['section']['display'])); $_block_repeat=true;smarty_block_collapsible_sidebar($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
													<?php $this->_tag_stack[] = array('define_slot', array('table' => $this->_tpl_vars['subrecord']->_table->tablename,'name' => ($this->_tpl_vars['section']['name'])."_section_content")); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
													<?php if ($this->_tpl_vars['section']['content']): ?>
														<div class="dataface-view-section">
														<?php echo $this->_tpl_vars['section']['content']; ?>

														</div>
													<?php elseif ($this->_tpl_vars['section']['fields']): ?>
														<table class="record-view-table">
														<tbody>
														<?php $_from = $this->_tpl_vars['section']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fieldname'] => $this->_tpl_vars['field']):
?>
															<?php if ($this->_tpl_vars['field']['visibility']['browse'] != 'hidden' && $this->_tpl_vars['record']->htmlValue($this->_tpl_vars['field']['name'])): ?>
																<tr><th class="record-view-label"><?php echo $this->_tpl_vars['field']['widget']['label']; ?>
</th><td class="record-view-value"><?php echo $this->_tpl_vars['record']->htmlValue($this->_tpl_vars['field']['name']); ?>
</td></tr>
															<?php endif; ?>
														<?php endforeach; endif; unset($_from); ?>
														</tbody>
														</table>
													<?php elseif ($this->_tpl_vars['section']['records']): ?>
														<?php echo $this->_plugins['function']['glance_list'][0][0]->glance_list(array('records' => $this->_tpl_vars['section']['records']), $this);?>

													<?php endif; ?>
													<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
												<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_collapsible_sidebar($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
												<?php endif; ?>
											
											<?php endforeach; endif; unset($_from); ?>
											
										</div>
									</td>
									<td id="dataface-sections-main-column" valign="top">
										<div class="dataface-sections-main dataface-sections-count-<?php echo count($this->_tpl_vars['subrv']->sections); ?>
" id="dataface-sections-main"> 
											<?php $this->_tag_stack[] = array('define_slot', array('table' => $this->_tpl_vars['subrecord']->_table->tablename,'name' => 'record_view_main_section')); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
												<?php if ($this->_tpl_vars['ENV']['prefs']['collapse_all_sections_enabled']): ?>
												<div class="section-tools">
													<a href="javascript:DatafaceSections.collapseAll()"><img src="<?php echo $this->_tpl_vars['ENV']['DATAFACE_URL']; ?>
/images/treeExpanded.gif">Collapse All Sections</a> &nbsp; &nbsp;
												<a href="javascript:DatafaceSections.expandAll()"><img src="<?php echo $this->_tpl_vars['ENV']['DATAFACE_URL']; ?>
/images/treeCollapsed.gif">Expand All Sections</a>
												</div>
												<?php endif; ?>
												
												<?php $_from = $this->_tpl_vars['subrv']->sections; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['section']):
?>
													<?php if ($this->_tpl_vars['section']['class'] == 'main'): ?>
													<?php $this->_tag_stack[] = array('collapsible_sidebar', array('heading' => $this->_tpl_vars['section']['label'],'edit_url' => $this->_tpl_vars['section']['edit_url'],'movable' => 1,'prefix' => 'mainsidebar','id' => $this->_tpl_vars['section']['name'],'onexpand' => "DatafaceSections.onexpand(this)",'oncollapse' => "DatafaceSections.oncollapse(this)",'display' => $this->_tpl_vars['section']['display'])); $_block_repeat=true;smarty_block_collapsible_sidebar($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
														<?php $this->_tag_stack[] = array('define_slot', array('table' => $this->_tpl_vars['subrecord']->_table->tablename,'name' => ($this->_tpl_vars['section']['name'])."_section_content")); $_block_repeat=true;$this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
														<?php if ($this->_tpl_vars['section']['content']): ?>
															<div class="dataface-view-section">
															<?php echo $this->_tpl_vars['section']['content']; ?>

															</div>
														<?php elseif ($this->_tpl_vars['section']['fields']): ?>
															<table class="record-view-table">
															<tbody>
															<?php $_from = $this->_tpl_vars['section']['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fieldname'] => $this->_tpl_vars['field']):
?>
																<?php if ($this->_tpl_vars['field']['visibility']['browse'] != 'hidden'): ?>
																	<?php if ($this->_tpl_vars['section']['record']): ?>
																		<?php $this->assign('field_value', $this->_tpl_vars['section']['record']->htmlValue($this->_tpl_vars['field']['name'])); ?>
																	<?php else: ?>
																		<?php $this->assign('field_value', $this->_tpl_vars['subrecord']->htmlValue($this->_tpl_vars['field']['name'])); ?>
																	
																	<?php endif; ?>
																	<?php if ($this->_tpl_vars['field_value']): ?>
																		<tr><th class="record-view-label">
																				<?php if ($this->_tpl_vars['field']['label_link']): ?><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['field']['label_link'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" target="_blank" class="field-label-link no-link-icon"><?php endif; ?>
																					<?php echo $this->_tpl_vars['field']['widget']['label']; ?>

																				<?php if ($this->_tpl_vars['field']['label_link']): ?></a><?php endif; ?>
																			</th>
																			<td class="record-view-value"><?php echo $this->_tpl_vars['field_value']; ?>
</td></tr>
																	<?php endif; ?>
																<?php endif; ?>
															<?php endforeach; endif; unset($_from); ?>
															</tbody>
															</table>
														<?php elseif ($this->_tpl_vars['section']['records']): ?>
															<?php echo $this->_plugins['function']['glance_list'][0][0]->glance_list(array('records' => $this->_tpl_vars['section']['records']), $this);?>

														<?php endif; ?>
														<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
													<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_collapsible_sidebar($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
													<?php endif; ?>
												
												<?php endforeach; endif; unset($_from); ?>
											<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['define_slot'][0][0]->define_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
											<div style="clear:both"></div>
											
										</div>
										<?php echo '
					
										 <script type="text/javascript">
										// <![CDATA[
											require(DATAFACE_URL+\'/js/ajaxgold.js\');
											
											var DatafaceSections = {
												
												\'setDisplay\': function(el,disp){
													var params = \'--record_id=*&--name=\'+encodeURIComponent(\'tables.'; ?>
<?php echo $this->_tpl_vars['record']->_table->tablename; ?>
<?php echo '.sections.\'+el.getAttribute(\'df:section_name\')+\'.display\')+\'&--value=\'+disp;
													var query = window.location.search;
													if ( query.indexOf(\'-action=\') >= 0 ){
														query = query.replace(/([?&])-action=[^&]+/g, \'$1-action=ajax_set_preference\');
													} else {
														query = \'-action=ajax_set_preference\';
													}
													query = query.replace(/^[?]/, \'\');
													var url = DATAFACE_SITE_HREF;
													//alert(url + " : " + params);
													postDataReturnText(url, params + \'&\' + query, function(text){});
														
												},
												
												\'oncollapse\': function(el){
													return this.setDisplay(el, \'collapsed\');
												
												},
												
												\'onexpand\': function(el){
													return this.setDisplay(el, \'expanded\');
												},
												\'collapseAll\': function(){
												
													var handles = getElementsByClassName(document,\'*\',\'expansion-handle\');
													for ( var i=0; i<handles.length; i++){
														if ( !jQuery(handles[i].parentNode.nextSibling).hasClass(\'closed\') ){
															jQuery(handles[i].parentNode.nextSibling).slideToggle("slow", Xataface.blocks.collapsible_sidebar.toggleCallback);
															//cd.collapseElement(handles[i]);
														}
													}
												},
												\'expandAll\': function(){
													var handles = getElementsByClassName(document,\'*\',\'expansion-handle\');
													for ( var i=0; i<handles.length; i++){
														if ( jQuery(handles[i].parentNode.nextSibling).hasClass(\'closed\') ){
															jQuery(handles[i].parentNode.nextSibling).slideToggle("slow", Xataface.blocks.collapsible_sidebar.toggleCallback);
															//cd.collapseElement(handles[i]);
														}
													}
												}
											
											
											};
											
											var updateSections = function(container){
														//alert(\'here\');
														
														var params = window.location.search;//+\'&\'+Sortable.serialize("dataface-sections-left");
														params = params.replace(/([?&])-action=[^&]+/g, \'$1-action=ajax_sort_sections\');
														
														
														var movables = jQuery(container).find(\'.movable\');
														var movables_str = \'\';
														for ( var i=0; i<movables.length; i++){
															movables_str += \',\'+movables[i].getAttribute(\'df:section_name\');
														}
														params += \'&--\'+encodeURIComponent(container.getAttribute(\'id\'))+\'=\'+encodeURIComponent(movables_str);
														params = params.substring(1);
														//alert(params);
														postDataReturnText(DATAFACE_SITE_HREF, params, function(data){document.getElementById(\'terminal\').innerHTML=data;});
														//alert(Sortable.serialize("dataface-sections-left"));
													}
													
											jQuery(\'#dataface-sections-left\').sortable({\'handle\': \'.movable-handle\', \'update\': function(){updateSections(jQuery(\'#dataface-sections-left\').get(0));}});
											jQuery(\'#dataface-sections-main\').sortable({\'handle\': \'.movable-handle\', \'update\': function(){updateSections(jQuery(\'#dataface-sections-main\').get(0));}});
											/*Sortable.create("dataface-sections-left",
												{
													dropOnEmpty:true,
													constraint:false, 
													handle:\'movable-handle\',
													tag:\'div\',
													only:\'movable\',
													onUpdate: updateSections
												});
											Sortable.create("dataface-sections-main",
											{dropOnEmpty:true,constraint:false, handle:\'movable-handle\',tag:\'div\',only:\'movable\', onUpdate:updateSections});
										*/
										// ]]>
										 </script>
										 '; ?>

										<div id="terminal"/>
									</td>
								</tr>
							</table>
							<div class="view-related-record-footer-actions">
								<?php echo $this->_plugins['function']['actions_menu'][0][0]->actions_menu(array('category' => 'view_related_record_footer_actions','record' => $this->_tpl_vars['subrecord']), $this);?>

							</div>
						</div><!-- record-view-wrapper-->
                        
                    </div>
                    
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </div><!-- view-related-record-wrapper-->
        <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
<?php else: ?>
    <?php $this->_tag_stack[] = array('use_macro', array('file' => "Dataface_Main_Template.html")); $_block_repeat=true;$this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php $this->_tag_stack[] = array('fill_slot', array('name' => 'record_content')); $_block_repeat=true;$this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <?php $this->_tag_stack[] = array('translate', array('id' => "scripts.GLOBAL.NO_RECORDS_MATCHED_REQUEST")); $_block_repeat=true;$this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>No records matched your request.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['translate'][0][0]->translate($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
        <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['fill_slot'][0][0]->fill_slot($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_plugins['block']['use_macro'][0][0]->use_macro($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>

<?php endif; ?>