<?php /* Smarty version 2.6.18, created on 2017-05-17 08:52:15
         compiled from xataface/modules/email/email_progress_section.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'xataface/modules/email/email_progress_section.html', 14, false),)), $this); ?>
<div style="clear:both"></div>
<div id="email-preparing-panel">
	<h2>Preparing To Send Email...</h2>
	
	<p>Please wait...</p>
	
	<div id="indeterminate-progress-bar">
	
	
	</div>

</div>

<div id="email-progress-panel" data-job-id="<?php echo ((is_array($_tmp=$this->_tpl_vars['jobId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" style="display:none">


	<h2>Sending Emails</h2>
	
	
	<div id="job-progress-bar"></div>
	<div class="job-status-message">
		Now sending <span class="now-sending">x</span> of <span class="num-emails-in-job">y</span>.
	</div>
	<div class="buttons">
		<button class="cancel-button">Cancel</button>
	</div>
	
	<div class="job-stats">
		<table>
			<tr>
				<td>
					Attempted: <span clas="num-attempted">0</span>
				</td>
				<td>
					Successful: <span class="num-successful">0</span>
				</td>
				<td>
					Failed: <span class="num-failed">0</span>
				</td>
				<td>
					Blacklisted: <span class="num-blacklisted">0</span>
				</td>
			</tr>
		
		</table>
	
	</div>

</div>

<div id="email-complete-panel" style="display:none">
	<h2>Job Complete</h2>
	
	<p>All of the emails were either sent.  The results of the job are listed below:</p>
	
	<table>
		<tr>
			<th>Total Attempted</th><td id="total-attempted"></td>
		</tr>
		<tr>
			<th>Total Successful</th><td id="total-successful"></td>
		</tr>
		<tr>
			<th>Total Failed</th><td id="total-failed"></td>
		</tr>
		<tr>
			<th>Total Cancelled (blacklisted)</th><td id="total-blacklisted"></td>
		</tr>
		<tr>
			<th>Job Started at:</th><td id="job-started-at"></td>
		</tr>
		<tr>
			<th>Job Finished at:</th><td id="job-finished-at"></td>
		</tr>
	
	
	
	</table>
	
	

</div>

<div id="email-cancelled-panel" data-job-id="<?php echo ((is_array($_tmp=$this->_tpl_vars['jobId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" style="display:none">


	<h2>Job Paused</h2>
	
	
	<div class="job-status-message">
		This job has been cancelled.  The job status is as follows:
	</div>
	
	<div class="job-stats">
		<table>
			<tr>
				<td>
					Attempted: <span class="num-attempted">0</span>
				</td>
				<td>
					Successful: <span class="num-successful">0</span>
				</td>
				<td>
					Failed: <span class="num-failed">0</span>
				</td>
				<td>
					Blacklisted: <span class="num-blacklisted">0</span>
				</td>
			</tr>
		
		</table>
	
	</div>
	<div class="buttons">
		<button class="resume-button">Resume Job</button>
	</div>
	
</div>

<div id="job-details">

	<a href="<?php echo $this->_tpl_vars['ENV']['DATAFACE_SITE_HREF']; ?>
?-action=related_records_list&-table=xataface__email_newsletters&job_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['jobId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&-relationship=log">View Mail Log</a>
</div>