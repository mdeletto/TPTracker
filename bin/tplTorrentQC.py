#!/usr/bin/python

import requests
import argparse
import json
import sys
import re
import os
import smtplib
import shutil
import MySQLdb
import datetime
from collections import defaultdict
from collections import OrderedDict
from pprint import PrettyPrinter
from elasticsearch import Elasticsearch
from email.mime.multipart import MIMEMultipart
from __builtin__ import str

class AutoVivification(dict):
    """Implementation of perl's autovivification feature."""
    def __getitem__(self, item):
        try:
            return dict.__getitem__(self, item)
        except KeyError:
            value = self[item] = type(self)()
            return value

def removew(d):
      
    return  {re.sub(" ","_",str(k)):removew(v) if isinstance(v, dict) else v for k, v in d.iteritems()}

def determine_run_filepath(run_data):
    """Takes the complete run_data dict as input.  Selects the 'reportLink' filepath name, reformats it to the base directory for results, and returns the string."""
    
    base_filepath = run_data['reportLink']
    #base_filepath = "/results/analysis" + base_filepath
    return base_filepath

def define_TS_login_credentials(args):
    """Defines login credentials for TS.
    For my universal function, default host is localhost.
    """
    
    myhost = args.ip_address[0]
    user = 'downstream'
    password = 'downstream'

    torrent_server_values = [user,password,myhost]
    return torrent_server_values

def create_sample_dict(base_filepath):
    """Takes the complete base_filepath string as input.  Finds file on server that defines barcode and sample names."""

    path = base_filepath + "basecaller_results/datasets_basecaller.json"
    response = requests.get('http://%s%s'%(myhost,path),auth=(user,password), stream=True)
    response = response.json()

    barcode_sample_name = defaultdict(dict)
    
    for k in response['read_groups'].keys():
        
        try:
#             
#             if all_barcodes is True:
#                 barcode_sample_name[response['read_groups'][k]['barcode_name']] = defaultdict(dict)
#                 barcode_sample_name[response['read_groups'][k]['barcode_name']]['sample'] = response['read_groups'][k]['sample'].replace(" ","_")
#                 barcode_sample_name[response['read_groups'][k]['barcode_name']]['read count'] = response['read_groups'][k]['read_count']
#             else:
                # The "or" here was used as a fix for chef runs where no sample definition exists (i.e. when no sample name is defined)
            if not re.search("none", response['read_groups'][k]['sample'].strip(), re.IGNORECASE) or int(response['read_groups'][k]["read_count"]) > 40000 :
                barcode_sample_name[response['read_groups'][k]['barcode_name']] = defaultdict(dict)
                barcode_sample_name[response['read_groups'][k]['barcode_name']]['sample'] = response['read_groups'][k]['sample'].replace(" ","_")
                barcode_sample_name[response['read_groups'][k]['barcode_name']]['read_count'] = response['read_groups'][k]['read_count']
    
                
        except KeyError, e:
            pass

    for barcode in barcode_sample_name.keys():
        try:
            
            path = base_filepath + "basecaller_results/%s_rawlib.ionstats_basecaller.json" % barcode
            response = requests.get('http://%s%s'%(myhost,path),auth=(user,password), stream=True)
            if response.status_code == 200:
                response = response.json()
            else:
                path = base_filepath + "%s_rawlib.ionstats_alignment.json" % barcode
                response = requests.get('http://%s%s'%(myhost,path),auth=(user,password), stream=True)
                response = response.json()
            read_length_histogram = response['full']['read_length_histogram']
            
            total_length, total_reads, counter = (0 for i in range(3))
            for x in read_length_histogram:
                total_length += (counter * int(x))
                total_reads += int(x)
                counter += 1
            mean_read_length = int(round(float(float(total_length)/float(total_reads))))
            #barcode_sample_name[barcode]['mean_read_length'] = response['full']['mean_read_length']
            barcode_sample_name[barcode]['mean_read_length'] = mean_read_length
        except Exception, e:
            barcode_sample_name[barcode]['mean_read_length'] = "ERROR: %s" % (str(e))
            pass

    return barcode_sample_name

def collect_metrics(run_data, selected_parameter):
        tmp_dict = {}
    
        if selected_parameter == 'experiment' or selected_parameter == 'pluginresults':
            metricsLoc = run_data[selected_parameter]
        else:
            metricsLoc = run_data[selected_parameter][0]
        if type(metricsLoc) is list:
            if selected_parameter == 'pluginresults':
                for loc in metricsLoc:
                    Result = requests.get('http://%s%s'%(myhost,loc),auth=(user,password))
                    Data = Result.json()
                    
                    if Data['pluginName'] == "coverageAnalysis":
                        coverage_analysis_dict = {'coverageAnalysis' : Data}
                        tmp_dict.update(coverage_analysis_dict)
                    elif Data['pluginName'] == "IonReporterUploader":
                        iru_dict = {'IonReporterUploader' : Data}
                        tmp_dict.update(iru_dict)
                    else:
                        pass
            
            if selected_parameter == 'experiment':
                for loc in metricsLoc:
                    Result = requests.get('http://%s%s'%(myhost,loc),auth=(user,password))
                    Data = Result.json()
                    exp_dict = {'experiment' : Data}
                    tmp_dict.update(exp_dict)
            
        else:     
            Result = requests.get('http://%s%s'%(myhost,metricsLoc),auth=(user,password))
            Data = Result.json()      
            tmp_dict = {selected_parameter : Data}
        
        return tmp_dict

def collect_coverage_analysis_stats(ts_api_selected_values, base_filepath):
    """Takes the complete ts_api dict as input.  Selects the coverage analysis plugin results and selects which values to print."""
    
    coverage_analysis_stats = {}
    for barcode in ts_api_selected_values['coverageAnalysis']['store']['barcodes']:
        nested_dict = {}
        barcode_name = barcode
        sample_name = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Sample Name']
        # Extract values from coverageAnalysis plugin
        try:
            amplicon_uniformity = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Uniformity of amplicon coverage']
        except:
            amplicon_uniformity = "N/A"
        try:
            base_uniformity = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Uniformity of base coverage']
        except:
            base_uniformity = "N/A"
        try:
            mapped_reads = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Number of mapped reads']
        except:
            mapped_reads = "N/A"
        try:
            percent_on_target = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Percent reads on target']
        except:
            percent_on_target = "N/A"
        try:
            mean_depth = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Average base coverage depth']
        except:
            mean_depth = "N/A"
        try:
            percent_amplicons_at_1x = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Amplicons with at least 1 read']
            percent_amplicons_at_20x = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Amplicons with at least 20 reads']
            percent_amplicons_at_100x = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Amplicons with at least 100 reads']
            percent_amplicons_at_500x = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Amplicons with at least 500 reads']
        except:
            percent_amplicons_at_1x = "N/A"
            percent_amplicons_at_20x = "N/A"
            percent_amplicons_at_100x = "N/A"
            percent_amplicons_at_500x = "N/A"
        try:
            percent_targets_at_1x = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Target base coverage at 1x']
            percent_targets_at_20x = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Target base coverage at 20x']
            percent_targets_at_100x = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Target base coverage at 100x']
            percent_targets_at_500x = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Target base coverage at 500x']
        except:
            percent_targets_at_1x = "N/A"
            percent_targets_at_20x = "N/A"
            percent_targets_at_100x = "N/A"
            percent_amplicons_at_500x = "N/A"
        try:
            target_regions = ts_api_selected_values['coverageAnalysis']['store']['Targeted Regions']
        except:
            target_regions = "N/A"
        try:
            number_of_amplicons = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][barcode]['Number of amplicons']
        except:
            number_of_amplicons = "N/A"

        def pull_other_barcode_stats(barcode, base_filepath):
    
            path = base_filepath + barcode + "_rawlib.ionstats_alignment.json"
            response = requests.get('http://%s%s'%(myhost,path),auth=(user,password), stream=True)
            response = response.json()
            
            # This information for mean_read_length is close, but not exact
            
            #mean_read_length = response['full']['mean_read_length']
            num_reads = response['full']['num_reads']
            num_bases = response['full']['num_bases']
            read_length_histogram = response['full']['read_length_histogram']
            
            # Recalculate mean_read_length based on histogram
            total_length, total_reads, counter = (0 for i in range(3))
            for x in read_length_histogram:
                total_length += (counter * int(x))
                total_reads += int(x)
                counter += 1
            mean_read_length = int(round(float(float(total_length)/float(total_reads))))
            
            tmp_list = [mean_read_length,
                        num_bases,
                        num_reads]
                          
            return tmp_list

        mean_read_length, num_bases, num_reads = (i for i in pull_other_barcode_stats(barcode, base_filepath))

        nested_dict = {
                       'sample_name' : sample_name,
                       'amplicon_uniformity' : amplicon_uniformity,
                       'base_uniformity' : base_uniformity,
                       'mapped_reads' : mapped_reads,
                       'percent_on_target' : percent_on_target,
                       'mean_depth' : mean_depth,
                       'percent_amplicons_at_1x' : percent_amplicons_at_1x,
                       'percent_amplicons_at_20x' : percent_amplicons_at_20x,
                       'percent_amplicons_at_100x' : percent_amplicons_at_100x,
                       'percent_amplicons_at_500x' : percent_amplicons_at_500x,
                       'percent_targets_at_1x' : percent_targets_at_1x,
                       'percent_targets_at_20x' : percent_targets_at_20x,
                       'percent_targets_at_100x' : percent_targets_at_100x,
                       'percent_targets_at_500x' : percent_amplicons_at_500x,
                       'target_regions' : target_regions,
                       'mean_read_length' : mean_read_length,
                       'num_bases' : num_bases,
                       'num_reads' : num_reads,
                       'num_amplicons' : number_of_amplicons
                       }
        
        coverage_analysis_stats[barcode] = nested_dict

    return coverage_analysis_stats


    
    
def collect_tf_metrics(base_filepath):
    
    path = base_filepath + "basecaller_results/TFStats.json"
    response = requests.get('http://%s%s'%(myhost,path),auth=(user,password), stream=True)
    response = response.json()
    tmp_dict = {}
    
    for k in response.keys():
        nested_dict = {}
        # This calculation below is UGLY.  But it basically calculates test fragment percentages and rounds to floor
        nested_dict['Percent_50AQ17'] = str(int((float(response[k]['50Q17']) / float(response[k]['Num'])) * 100)) + "%"
        nested_dict['Percent_100AQ17'] = str(int((float(response[k]['100Q17']) / float(response[k]['Num'])) * 100)) + "%"
        #nested_dict['Percent_50AQ17'] = '{0:.0%}'.format(float(response[k]['50Q17']) / float(response[k]['Num']))
        #nested_dict['Percent_100AQ17'] = '{0:.0%}'.format(float(response[k]['100Q17']) / float(response[k]['Num']))
        tmp_dict[k] = nested_dict
        
    tf_metrics = {}
    tf_metrics['tfmetrics'] = tmp_dict
     
    return tf_metrics

def collect_run_level_stats(ts_api_selected_values):
    """Takes the complete ts_api dict as input.  Collects run level stats and selects which values to print."""
    
    run_level_stats = {}
    
    percent_loading = '{:.0%}'.format(ts_api_selected_values['analysismetrics']['loading'] / 100)
    raw_accuracy = '{:.0%}'.format(ts_api_selected_values['libmetrics']['raw_accuracy'] / 100)
    reference_genome = ts_api_selected_values['coverageAnalysis']['store']['Reference Genome']
    total_reads = ts_api_selected_values['libmetrics']['totalNumReads']
    total_mapped_reads = ts_api_selected_values['libmetrics']['total_mapped_reads']
    total_mapped_target_bases = ts_api_selected_values['libmetrics']['total_mapped_target_bases']

    run_level_stats = {
                       'Percent loading' : percent_loading,
                       'Raw accuracy' : raw_accuracy,
                       'Reference genome' : reference_genome,
                       'Total reads' : total_reads,
                       'Total mapped reads' : total_mapped_reads,
                       'Total mapped target bases' : total_mapped_target_bases
                       }

    return run_level_stats



def percent2float(x):
    return round(float(x.strip('%'))/100, 3)

def remove_master_dict_keys_and_reformat_values(ts_api_selected_values):

    def restructure_sample_dict():
        
        restructured_barcode_dict = {}
        restructured_barcode_dict_list = []
    
        for k in ts_api_selected_values['samples'].keys():
            restructured_barcode_dict = ts_api_selected_values['samples'][k]
            restructured_barcode_dict['barcode'] = k
            restructured_barcode_dict['sampleName'] = restructured_barcode_dict['sample']
            restructured_barcode_dict.pop('sample')
            restructured_barcode_dict_list.append(restructured_barcode_dict)
            
        ts_api_selected_values.pop('samples')
        ts_api_selected_values['samples'] = restructured_barcode_dict_list

        return ts_api_selected_values

    def restructure_barcode_coverage_analysis_info():
        
        def determine_sample_names():
            sample_names = defaultdict(list)
            for sample in ts_api_selected_values['samples']:
                
                split_name = sample['sampleName'].split("_")
                sample_type = split_name[-1]
                sample_basename = "_".join(split_name[:-1])
                if not re.search("_", sample_basename):
                    sample_basename = split_name[0]
                    
                sample_names[sample_basename].append({'sampleName' : sample['sampleName'],
                                                      'sampleType' : sample_type,
                                                      'barcode' : sample['barcode'],
                                                      'numReads' : sample['read_count'],
                                                      'meanReadLength' : sample['mean_read_length']
                                                      })
             
            return sample_names
        
        # Determine sample basenames
        sample_names = determine_sample_names()
        # remove non-barcoded samples
        sample_names.pop('none', None)
        
        restructured_barcode_dict = defaultdict(lambda: defaultdict(dict))

        for sample_basename in sample_names.keys():
            for sample in sample_names[sample_basename]:
                sample_type = sample['sampleName'].split("_")[-1]
                if sample['barcode'] in ts_api_selected_values['coverageAnalysis']['store']['barcodes'].keys():
                    
                    if re.search("tumor", ts_api_selected_values['coverageAnalysis']['store']['barcodes'][sample['barcode']]['Sample Name'], re.IGNORECASE) or sample_type == "T":
                        sample_type = "tumorDNA"
                        try:
                            if re.search("fusion", ts_api_selected_values['coverageAnalysis']['store']['barcodes'][sample['barcode']]['Reference Genome']):
                                sample_type = "tumorRNA"
                            else:
                                sample_type = "tumorDNA"
                        except:
                            sample_type = "tumorDNA"
                        
                    elif re.search("fusion", ts_api_selected_values['coverageAnalysis']['store']['barcodes'][sample['barcode']]['Sample Name'], re.IGNORECASE) or re.search("RNA", ts_api_selected_values['coverageAnalysis']['store']['barcodes'][sample['barcode']]['Sample Name'], re.IGNORECASE):
                        sample_type = "tumorRNA"
                    elif re.search("normal", ts_api_selected_values['coverageAnalysis']['store']['barcodes'][sample['barcode']]['Sample Name'], re.IGNORECASE) or sample_type == "N":
                        sample_type = "normalDNA"
                    elif re.search("QC", ts_api_selected_values['coverageAnalysis']['store']['barcodes'][sample['barcode']]['Sample Name'], re.IGNORECASE):
                        sample_type = "tumorDNA"
                    else:
                        sample_type = "tumorDNA"
                else:

                    if re.search("tumor", sample['sampleName'], re.IGNORECASE) or sample_type == "T":
                        sample_type = "tumorDNA"
                    if re.search("QC", sample['sampleName'], re.IGNORECASE):
                        sample_type = "tumorDNA"
                    if re.search("fusion", sample['sampleName'], re.IGNORECASE) or re.search("RNA", sample['sampleName'], re.IGNORECASE) or ((re.search("tumor", sample['sampleName'], re.IGNORECASE)) and (sample['barcode'] not in ts_api_selected_values['coverageAnalysis']['store']['barcodes'].keys())):
                        sample_type = "tumorRNA"
                    if re.search("normal", sample['sampleName'], re.IGNORECASE) or sample_type == "T":
                        sample_type = "normalDNA"
                    else:
                        sample_type = "tumorRNA"
                
                try:
                    if not sample_type:
                        sample_type = "tumorDNA"
                except:
                    sample_type = "tumorDNA"
                
                
                restructured_barcode_dict['samples'][sample_basename][sample_type] = {}
                
                if sample['barcode'] in ts_api_selected_values['coverageAnalysis']['store']['barcodes'].keys():
                    
                    for k in ts_api_selected_values['coverageAnalysis']['store']['barcodes'][sample['barcode']].keys():
                        restructured_barcode_dict['samples'][sample_basename][sample_type][k] = ts_api_selected_values['coverageAnalysis']['store']['barcodes'][sample['barcode']][k]
                
                restructured_barcode_dict['samples'][sample_basename][sample_type]['numReads'] = sample['numReads']
                restructured_barcode_dict['samples'][sample_basename][sample_type]['meanReadLength'] = sample['meanReadLength']
                restructured_barcode_dict['samples'][sample_basename][sample_type]['barcode'] = sample['barcode']

        keys_convert_percents_to_floats = ['Amplicons reading end-to-end',
                                            'Amplicons with at least 1 read',
                                            'Amplicons with at least 10 reads',
                                            'Amplicons with at least 20 reads',
                                            'Amplicons with at least 100 reads',
                                            'Amplicons with at least 500 reads',
                                            'Amplicons with at least 10K reads',
                                            'Amplicons with at least 100K reads',
                                            'Amplicons with at least 1000 reads',
                                            'Amplicons with no strand bias',
                                            'Percent assigned amplicon reads',
                                            'Percent base reads on target',
                                            'Percent end-to-end reads',
                                            'Percent reads on target',
                                            'Target base coverage at 1x',
                                            'Target base coverage at 20x',
                                            'Target base coverage at 100x',
                                            'Target base coverage at 500x',
                                            'Target bases with no strand bias',
                                            'Uniformity of amplicon coverage',
                                            'Uniformity of base coverage']
        
        keys_convert_str_to_ints = ['Bases in target regions',
                                   'Total assigned amplicon reads',
                                   'Number of amplicons',
                                   'Number of mapped reads',
                                   'Total base reads on target',
                                   'Total aligned base reads']
        
        keys_convert_str_to_float = ['Average base coverage depth',
                                     'Average reads per amplicon'
                                     ]
        
        for sample_name in restructured_barcode_dict['samples'].keys():
            for sample_type in restructured_barcode_dict['samples'][sample_name].keys():
                for k in (keys_convert_percents_to_floats + keys_convert_str_to_ints + keys_convert_str_to_float):

                    if k in restructured_barcode_dict['samples'][sample_name][sample_type].keys():
                        if type(restructured_barcode_dict['samples'][sample_name][sample_type][k]) is int:
                            pass
                        elif (type(restructured_barcode_dict['samples'][sample_name][sample_type][k]) is unicode) or (type(restructured_barcode_dict['samples'][sample_name][sample_type][k]) is str):
                            if k in keys_convert_percents_to_floats:
                                restructured_barcode_dict['samples'][sample_name][sample_type][k] = percent2float(restructured_barcode_dict['samples'][sample_name][sample_type][k])
                            elif k in keys_convert_str_to_ints:
                                restructured_barcode_dict['samples'][sample_name][sample_type][k] = int(restructured_barcode_dict['samples'][sample_name][sample_type][k])
                            elif k in keys_convert_str_to_float:
                                restructured_barcode_dict['samples'][sample_name][sample_type][k] = float(restructured_barcode_dict['samples'][sample_name][sample_type][k])

        restructured_barcode_dict['resultName'] = ts_api_selected_values['coverageAnalysis']['resultName']
        ts_api_selected_values['coverageAnalysis'] = restructured_barcode_dict

        return ts_api_selected_values


    # Restructure samples
    ts_api_selected_values = restructure_sample_dict()

    # Pop "IonReporterUploader" - we don't need it
    if "IonReporterUploader" in ts_api_selected_values.keys():
        ts_api_selected_values.pop("IonReporterUploader")

    # Analysis Metrics
    ts_api_selected_values['analysismetrics'].pop('report')
    ts_api_selected_values['analysismetrics'].pop('resource_uri')
    
    
    # CoverageAnalysis Metrics
#     ts_api_selected_values['coverageAnalysis'].pop('apikey')
#     ts_api_selected_values['coverageAnalysis'].pop('duration')
#     ts_api_selected_values['coverageAnalysis'].pop('id')
#     ts_api_selected_values['coverageAnalysis'].pop('inodes')
#     ts_api_selected_values['coverageAnalysis'].pop('jobid')
#     ts_api_selected_values['coverageAnalysis'].pop('owner')
#     ts_api_selected_values['coverageAnalysis'].pop('path')
#     ts_api_selected_values['coverageAnalysis'].pop('plugin')
#     ts_api_selected_values['coverageAnalysis'].pop('reportLink')
#     ts_api_selected_values['coverageAnalysis'].pop('resource_uri')
#     ts_api_selected_values['coverageAnalysis'].pop('result')
#     ts_api_selected_values['coverageAnalysis'].pop('size')
#     ts_api_selected_values['coverageAnalysis']['config'].pop('launch_mode')
#     ts_api_selected_values['coverageAnalysis']['config'].pop('nonduplicates')
#     ts_api_selected_values['coverageAnalysis']['config'].pop('padtargets')
#     ts_api_selected_values['coverageAnalysis']['store'].pop('Launch Mode')
#     ts_api_selected_values['coverageAnalysis']['store'].pop('Library Type')
#     ts_api_selected_values['coverageAnalysis']['store'].pop('Sample Tracking')
#     ts_api_selected_values['coverageAnalysis']['store'].pop('Target Padding')
#     ts_api_selected_values['coverageAnalysis']['store'].pop('Use Only Non-duplicate Reads')
#     ts_api_selected_values['coverageAnalysis']['store'].pop('Use Only Uniquely Mapped Reads')
#     ts_api_selected_values['coverageAnalysis']['store']['Amplicons reading end-to-end'] = percent2float(ts_api_selected_values['coverageAnalysis']['store']['Amplicons reading end-to-end'])
#     ts_api_selected_values['coverageAnalysis']['store']['Percent end-to-end reads'] = percent2float(ts_api_selected_values['coverageAnalysis']['store']['Percent end-to-end reads'])

    ts_api_selected_values = restructure_barcode_coverage_analysis_info()


    # libmetrics
    
    ts_api_selected_values['libmetrics']['genomesize'] = int(ts_api_selected_values['libmetrics']['genomesize'])
    ts_api_selected_values['libmetrics']['q10_mapped_bases'] = int(ts_api_selected_values['libmetrics']['q10_mapped_bases'])
    ts_api_selected_values['libmetrics']['q17_mapped_bases'] = int(ts_api_selected_values['libmetrics']['q17_mapped_bases'])
    ts_api_selected_values['libmetrics']['q20_mapped_bases'] = int(ts_api_selected_values['libmetrics']['q20_mapped_bases'])
    ts_api_selected_values['libmetrics']['q47_mapped_bases'] = int(ts_api_selected_values['libmetrics']['q47_mapped_bases'])
    ts_api_selected_values['libmetrics']['q7_mapped_bases'] = int(ts_api_selected_values['libmetrics']['q7_mapped_bases'])
    ts_api_selected_values['libmetrics']['total_mapped_reads'] = int(ts_api_selected_values['libmetrics']['total_mapped_reads'])
    ts_api_selected_values['libmetrics']['total_mapped_target_bases'] = int(ts_api_selected_values['libmetrics']['total_mapped_target_bases'])
    
    ts_api_selected_values['libmetrics'].pop('report')
    ts_api_selected_values['libmetrics'].pop('resource_uri')
    
    # qualitymetrics

    ts_api_selected_values['qualitymetrics']['q0_bases'] = int(ts_api_selected_values['qualitymetrics']['q0_bases'])
    ts_api_selected_values['qualitymetrics']['q17_bases'] = int(ts_api_selected_values['qualitymetrics']['q17_bases'])
    ts_api_selected_values['qualitymetrics']['q20_bases'] = int(ts_api_selected_values['qualitymetrics']['q20_bases'])
    
    ts_api_selected_values['qualitymetrics'].pop('report')
    ts_api_selected_values['qualitymetrics'].pop('resource_uri')
    
    # tfmetrics
    
    # experiment metrics
    
    # Remove this TS metric because it is poorly formatted
    #ts_api_selected_values.pop('experiment')
    ts_api_selected_values['experiment']['project'] = ts_api_selected_values['experiment'][u'log'][u'project']
    ts_api_selected_values['experiment']['resultName'] = ts_api_selected_values['coverageAnalysis']['resultName']
    ts_api_selected_values['experiment'].pop('log')
    ts_api_selected_values['experiment'].pop('eas_set')
    ts_api_selected_values['experiment'].pop('samples')
#     ts_api_selected_values['experiment']['log'].pop('dac')
    
    # We dont need this re-calculation for now
    
def rename_elasticsearch_index_type(test_string):
    """Takes a string and gives a more detailed and appropriate index type."""
    
    if re.search("libmetrics", test_string):
        type_name = "torrentSuiteLibraryMetrics"
    elif re.search("tfmetrics", test_string):
        type_name = "torrentSuiteTFMetrics"
    elif re.search("analysismetrics", test_string):
        type_name = "torrentSuiteAnalysisMetrics"
    elif re.search("qualitymetrics", test_string):
        type_name = "torrentSuiteQualityMetrics"
    elif re.search("experiment", test_string):
        type_name = "torrentSuiteExperimentMetrics"
    elif re.search("coverageAnalysis", test_string):
        type_name = "torrentSuiteCoverageAnalysis"
    else:
        type_name = False
    
    return type_name
        
def connect_to_database(database_name):

    try:
        cnx = MySQLdb.connect("",
                              "root",
                              "*23Ft198",
                              database_name)
        #print "SUCCESSFULLY CONNECTED TO %s" % database_name
    except MySQLdb.Error as err:
        if err.errno == err.errno.errorcode.ER_ACCESS_DENIED_ERROR:
            print("Something is wrong with your user name or password")
        elif err.errno == err.errno.errorcode.ER_BAD_DB_ERROR:
            print("Database does not exist")
        else:
            print(err)
            
    return cnx

def determine_qc_status(ts_api_selected_values, sample):
    """Determines panel alias based on regex in panel target regions, 
    then applies appropriate QC parameters and derives a final PASS/FLAG/FAIL status.
    """

    try:
        target_regions = ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions']
    except KeyError:
        if not 'tumorDNA' in ts_api_selected_values['coverageAnalysis']['samples'][sample].keys():
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA'] = defaultdict(lambda: "")
            target_regions = ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions']
        else:
            sys.exit("ERROR: Target regions not defined for %s" % sample)
    
    # Assign panel alias name based on regex in Target Regions
    if ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions'] is not None:
            
        if re.search("CHP2", target_regions, re.IGNORECASE):
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'] = 'HSM'
        elif re.search("OCP", target_regions, re.IGNORECASE):
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'] = 'OCP'
        elif re.search("OCAv3", target_regions, re.IGNORECASE):
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'] = 'OCPv3'
        elif re.search("CCP", target_regions, re.IGNORECASE):
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'] = 'CCP'
        else:
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'] = 'UNKNOWN'

    # Check if normal is defined
    
    try:
        if not 'normalDNA' in ts_api_selected_values['coverageAnalysis']['samples'][sample].keys():
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA'] = defaultdict(lambda: defaultdict(dict))
        if not 'tumorRNA' in ts_api_selected_values['coverageAnalysis']['samples'][sample].keys():
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA'] = defaultdict(lambda: defaultdict(dict))
    except:
        sys.exit("ERROR: FAILED TO CHECK FOR NORMAL IN MASTERDICT")

    # Apply QC rules

    qc_comment = ""
    
    # RUN LEVEL
    if float(ts_api_selected_values['analysismetrics']['loading']) <= 0.3:
        qc_comment += "beadLoading <= 30%; "
    if int(ts_api_selected_values['libmetrics']['aveKeyCounts']) <= 30:
        qc_comment += "keySignal <= 30; "
    if float( float(ts_api_selected_values['analysismetrics']['libFinal']) / float(ts_api_selected_values['analysismetrics']['lib']) ) <= 0.3:
        qc_comment += "useableReads <= 30%; "
    if int(ts_api_selected_values['qualitymetrics']['q20_median_read_length']) < 100:
        qc_comment += "medianReadLength < 100bp; "
    # If the qc_comment isn't blank, then we have a matching failure
#     if qc_comment != "":
#         qc_comment = "FAIL: " + qc_comment
    
    
    # TARGET REGION ASSESSMENT
    # Define Oncomine aliases to match against
    oncomine_alias = re.compile('OCP|OCA')
    
    # TPL Hotspot Mutation Panel (HSM) Assessment
    if ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'] == 'HSM':
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Number_of_mapped_reads']) < 300000:
            qc_comment += "tumorTotalMappedReads < 300,000; "
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['meanReadLength']) < 75:
            qc_comment += "tumorMeanReadLength < 75bp; "
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Average_base_coverage_depth']) < 1250:
            qc_comment += "tumorMeanReadDepth < 1250x; "
        
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_1x']) < 0.99:
            qc_comment += "tumorTargetBaseCoverage1x < 99%; "
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_20x']) < 0.95:
            qc_comment += "tumorTargetBaseCoverage20x < 95%; "
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_100x']) < 0.90:
            qc_comment += "tumorTargetBaseCoverage100x < 90%; "

        if bool(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA']) is False:
            #print "WARNING: DNA only OCP for %s" % sample
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA'] = defaultdict(lambda: None)
        else:
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA']['meanReadLength']) < 60:
                qc_comment += "tumorRNAMeanReadLength < 60bp; "

        if bool(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']) is False:
            print "WARNING: No normal defined for %s" % sample
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA'] = defaultdict(lambda: None)

        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Uniformity_of_base_coverage']) < 0.9:
            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Uniformity_of_base_coverage']) < 0.8:
                qc_comment += "tumorBaseUniformity < 80%; "
            else:
#                 if qc_comment == "":
#                     qc_comment = "FLAG: "
                qc_comment += "tumorBaseUniformity < 90%; "
    
    # Oncomine Assessment
    if re.search('OCP', ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'], re.IGNORECASE) or \
        re.search('OCA', ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'], re.IGNORECASE):

        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Number_of_mapped_reads']) < 3000000:
            qc_comment += "tumorTotalMappedReads < 3,000,000; "
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['meanReadLength']) < 75:
            qc_comment += "tumorMeanReadLength < 75bp; "
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Average_base_coverage_depth']) < 1000:
            qc_comment += "tumorMeanReadDepth < 1000x; "
        
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_1x']) < 0.99:
            qc_comment += "tumorTargetBaseCoverage1x < 99%; "
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_20x']) < 0.95:
            qc_comment += "tumorTargetBaseCoverage20x < 95%; "
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_100x']) < 0.90:
            qc_comment += "tumorTargetBaseCoverage100x < 90%; "

        if bool(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA']) is False:
            #print "WARNING: DNA only OCP for %s" % sample
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA'] = defaultdict(lambda: None)
        else:
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA']['meanReadLength']) < 60:
                qc_comment += "tumorRNAMeanReadLength < 60bp; "

        if bool(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']) is False:
            #print "WARNING: No normal defined for %s" % sample
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA'] = defaultdict(lambda: None)
        else:
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Number_of_mapped_reads']) < 500000:
                qc_comment += "normalTotalMappedReads < 500,000; "
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['meanReadLength']) < 75:
                qc_comment += "normalMeanReadLength < 75bp; "
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Average_base_coverage_depth']) < 200:
                qc_comment += "normalMeanReadDepth < 200x; "
            
            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Target_base_coverage_at_1x']) < 0.98:
                qc_comment += "normalTargetBaseCoverage1x < 98%; "
            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Target_base_coverage_at_20x']) < 0.90:
                qc_comment += "normalTargetBaseCoverage20x < 90%; "

            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Uniformity_of_base_coverage']) < 0.9:
                if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Uniformity_of_base_coverage']) < 0.8:
                    qc_comment += "normalBaseUniformity < 80%; "
                else:
                    qc_comment += "normalBaseUniformity < 90%; "

        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Uniformity_of_base_coverage']) < 0.9:
            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Uniformity_of_base_coverage']) < 0.8:
                qc_comment += "tumorBaseUniformity < 80%; "
            else:
#                 if qc_comment == "":
#                     qc_comment = "FLAG: "
                qc_comment += "tumorBaseUniformity < 90%; "
                
    # TPL CCP ASSESSMENT
    if ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias'] == 'CCP':
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Number_of_mapped_reads']) < 3000000:
            qc_comment += "tumorTotalMappedReads < 3,000,000; "
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['meanReadLength']) < 75:
            qc_comment += "tumorMeanReadLength < 75bp; "
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Average_base_coverage_depth']) < 200:
            qc_comment += "tumorMeanReadDepth < 200x; "
        
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_1x']) < 0.98:
            qc_comment += "tumorTargetBaseCoverage1x < 98%; "
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_20x']) < 0.90:
            qc_comment += "tumorTargetBaseCoverage20x < 90%; "
        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_100x']) < 0.70:
            qc_comment += "tumorTargetBaseCoverage100x < 70%; "


        if bool(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA']) is False:
            #print "WARNING: DNA only OCP for %s" % sample
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA'] = defaultdict(lambda: None)
        else:
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA']['meanReadLength']) < 60:
                qc_comment += "tumorRNAMeanReadLength < 60bp; "


        if bool(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']) is False:
            #print "WARNING: No normal defined for %s" % sample
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA'] = defaultdict(lambda: None)
        else:
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Number_of_mapped_reads']) < 750000:
                qc_comment += "normalTotalMappedReads < 750,000; "
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['meanReadLength']) < 75:
                qc_comment += "normalMeanReadLength < 75bp; "
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Average_base_coverage_depth']) < 40:
                qc_comment += "normalMeanReadDepth < 40x; "
            
            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Target_base_coverage_at_1x']) < 0.95:
                qc_comment += "normalTargetBaseCoverage1x < 95%; "
            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Target_base_coverage_at_20x']) < 0.70:
                qc_comment += "normalTargetBaseCoverage20x < 70%; "

            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Uniformity_of_base_coverage']) < 0.9:
                if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Uniformity_of_base_coverage']) < 0.8:
                    qc_comment += "normalBaseUniformity < 80%; "
                else:
#                     if qc_comment == "":
#                         qc_comment = "FLAG: "
                    qc_comment += "normalBaseUniformity < 90%; "

        if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Uniformity_of_base_coverage']) < 0.9:
            if float(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Uniformity_of_base_coverage']) < 0.8:
                qc_comment += "tumorBaseUniformity < 80%; "
            else:
#                 if qc_comment == "":
#                     qc_comment = "FLAG: "
                qc_comment += "tumorBaseUniformity < 90%; "

    # OVERRIDE ALL FOR NTC
    if re.search('NTC', sample) or sample=='NTC' or re.search("NTC", ts_api_selected_values['coverageAnalysis']['samples'][sample]['projectName']):
        qc_comment = ""
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Number_of_mapped_reads']) >= 250000:
            qc_comment += "tumorTotalMappedReads >= 250,000"
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['meanReadLength']) >= 75:
            qc_comment += "tumorMeanReadLength >= 75bp; "
        if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Average_base_coverage_depth']) >= 80:
            qc_comment += "tumorMeanReadDepth >= 80x; "

        if bool(ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']) is False:
            #print "WARNING: No normal defined for %s" % sample
            ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA'] = defaultdict(lambda: None)
        else:
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Number_of_mapped_reads']) >= 250000:
                qc_comment += "tumorTotalMappedReads >= 250,000"
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['meanReadLength']) >= 75:
                qc_comment += "tumorMeanReadLength >= 75bp; "
            if int(ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Average_base_coverage_depth']) >= 80:
                qc_comment += "tumorMeanReadDepth >= 80x; "

    # Determine QC basename comment
    if qc_comment == "":
        qc_comment = None
        qc_status = "PASS"
    else:
        for comment in qc_comment.split("; "):
            if comment != "":
                flagged_comments = ['normalBaseUniformity < 90%',
                                    'tumorBaseUniformity < 90%']
                
                if comment in flagged_comments:
                    qc_status = "FLAGGED"
                else:
                    qc_status = "FAIL"
                    break
    
    ts_api_selected_values['coverageAnalysis']['samples'][sample]['qcComment'] = qc_comment
    ts_api_selected_values['coverageAnalysis']['samples'][sample]['qcStatus'] = qc_status

def assign_sample_to_project(sample_name):
    """Assigns sample to project based on regex in sample name."""
    
    if re.search("Val", sample_name):
        project_name = "Validation"
    elif re.search("NTC", sample_name):
        project_name = "Negative Control (NTC)"
    elif re.search("QC", sample_name):
        project_name = "Positive Control"
    else:
        project_name = "Clinical"
        
    return project_name
        
    

def tree():
    return defaultdict(tree)

def define_instrument_name_by_host(myhost):
    """Define an instrument name by host."""
    
    if myhost == "10.80.157.29":
        return "TPL PGM2"
    elif myhost == "10.80.61.111":
        return "TPL PGM1"
    elif myhost == "10.71.60.151":
        return "TPL S5XL"
    elif myhost == "10.71.60.152":
        return "TPL S5XL2"

def main():

    desc="""Custom plugin to push metrics from TS API to the TPL Elasticsearch instance"""
    parser = argparse.ArgumentParser(description=desc)
    parser.add_argument('--version', action='version', version='%(prog)s 1.0')
    
    general_arguments = parser.add_argument_group('GENERAL OPTIONS')
    general_arguments.add_argument("-a", help="Analysis name (Report Name) from TS.  This not the Run Name",dest='analysis_name',action='store',nargs=1, default=None)
    general_arguments.add_argument("--ip-address", help="IP address of TS server.  Defaults to localhost",dest='ip_address',action='store',nargs=1, default="localhost")
    general_arguments.add_argument("--no-email", help="Do not send TPTracker email confirmation of successful upload",dest='no_email',action='store_true', default=False)
    args = parser.parse_args()

    global user, password, myhost
    user, password, myhost = define_TS_login_credentials(args)
    instrument = define_instrument_name_by_host(myhost)
    runName = args.analysis_name[0]
    no_email = args.no_email
    
    #print runName
    
    #-------------------------------------------------------#
    #---------------TORRENT SERVER FUNCTIONS----------------#
    #-------------------------------------------------------#
    
    
    # Contact TS server for initial validation for resultsName.  If this fails, you probably selected the wrong server.
    try:
        resp = requests.get('http://%s/rundb/api/v1/results?format=json&resultsName=%s'%(myhost,runName), \
                auth=(user,password))
        resp = resp.json()
        run_data = resp[u'objects'][0]
        experLoc = run_data[u'experiment']
    except (KeyError, IndexError):
        print 'ERROR: Invalid name given.  Please check to make sure this run exists on this server.'
        sys.exit(1)
    
    # Gather additional variables
    expResult = requests.get('http://%s%s'%(myhost, experLoc),auth=(user,password))
    expData = expResult.json()
    base_filepath = determine_run_filepath(run_data)
    
    # Select metrics from TS API
    selected_metrics = ['analysismetrics','qualitymetrics','pluginresults','libmetrics','experiment']
    
    
    # Collect metrics
    ts_api_selected_values = defaultdict(lambda: defaultdict(dict))
    for metric in selected_metrics:
        tmp_dict = collect_metrics(run_data, metric)
        ts_api_selected_values.update(tmp_dict)
    
    tf_metrics = collect_tf_metrics(base_filepath)
    ts_api_selected_values.update(tf_metrics)
    barcode_sample_name = create_sample_dict(base_filepath)
    ts_api_selected_values.update({'samples' : barcode_sample_name})
    
    ## Initialize variables
    
    pp = PrettyPrinter(indent=4)
    
    # Reformat dict and remove unnecessary values
    remove_master_dict_keys_and_reformat_values(ts_api_selected_values)
    
    # Remove whitespace in keys
    ts_api_selected_values = removew(ts_api_selected_values)

    # Determine qcStatus

    # Connect to Elasticsearch and MySQL
    
    #es = Elasticsearch([{'host': 'localhost', 'port': 9200}])
    cnx = connect_to_database("tumor_profiling_lab")
    cursor = cnx.cursor()

    # Dump ts_api_selected_values into defaultdict
    # We could probably have done this earlier
    
    #pp.pprint(dict(ts_api_selected_values))

    pretty_obj = json.dumps(ts_api_selected_values, indent=4)
    print pretty_obj


    for index_type in ts_api_selected_values.keys():
        index_type_name = rename_elasticsearch_index_type(index_type)
        
        
        if index_type == 'coverageAnalysis':
            sample_counter = 0
            for sample in ts_api_selected_values['coverageAnalysis']['samples'].keys():
                sample_counter += 1
                # Assign projectName base on sample name
                ts_api_selected_values['coverageAnalysis']['samples'][sample]['projectName'] = assign_sample_to_project(sample)
                # Perform QC
                determine_qc_status(ts_api_selected_values, sample)
                ts_api_selected_values['coverageAnalysis']['samples'][sample]['torrentSuiteResultName'] = ts_api_selected_values['coverageAnalysis']['resultName']
                
                # Load into Elasticsearch
                pretty_obj = json.dumps(ts_api_selected_values['coverageAnalysis']['samples'][sample], indent=4)
                #print pretty_obj
                #es.index("tumor-profiling-lab-torrentsuiteqc", index_type_name, pretty_obj, sample)
                
                
                #print ts_api_selected_values
                # Load into mySQL
                try:
                    sql = """INSERT INTO targetedNGSRunQualityControlMetrics
                            (instrumentName,
                            projectName,
                            resultName,
                            sampleName,
                            percentLoading,
                            keySignal,
                            useableReads,
                            medianReadLength,
                            tumorSampleName,
                            tumorBarcode,
                            tumorTotalMappedReads,
                            tumorMeanReadLength,
                            tumorMeanReadDepth,
                            tumorBaseUniformity,
                            tumorTargetBaseCoverage1x,
                            tumorTargetBaseCoverage20x,
                            tumorTargetBaseCoverage100x,
                            normalSampleName,
                            normalBarcode,
                            normalTotalMappedReads,
                            normalMeanReadLength,
                            normalMeanReadDepth,
                            normalBaseUniformity,
                            normalTargetBaseCoverage1x,
                            normalTargetBaseCoverage20x,
                            tumorRNAMeanReadLength,
                            tumorRNABarcode,
                            runStatus,
                            runErrorNotes,
                            workflowStage,
                            workflowStatus,
                            creator,
                            modifier,
                            datetimeCreated,
                            lastModified,
                            targetRegionAlias
                            ) 
                            VALUES 
                            (%s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s,
                            %s)"""
                             
                             
                    cursor.execute(sql, (instrument,
                                         ts_api_selected_values['coverageAnalysis']['samples'][sample]['projectName'],
                                         ts_api_selected_values['coverageAnalysis']['samples'][sample]['torrentSuiteResultName'],
                                     sample,
                                     ts_api_selected_values['analysismetrics']['loading'],
                                     ts_api_selected_values['libmetrics']['aveKeyCounts'],
                                     float( float(ts_api_selected_values['analysismetrics']['libFinal']) / float(ts_api_selected_values['analysismetrics']['lib']) ),
                                     ts_api_selected_values['qualitymetrics']['q20_median_read_length'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Sample_Name'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['barcode'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Number_of_mapped_reads'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['meanReadLength'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Average_base_coverage_depth'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Uniformity_of_base_coverage'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_1x'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_20x'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_base_coverage_at_100x'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Sample_Name'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['barcode'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Number_of_mapped_reads'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['meanReadLength'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Average_base_coverage_depth'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Uniformity_of_base_coverage'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Target_base_coverage_at_1x'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['normalDNA']['Target_base_coverage_at_20x'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA']['meanReadLength'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorRNA']['barcode'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['qcStatus'],
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['qcComment'],
                                     "Bioinformatics",
                                     "In-Progress",
                                     "AUTO",
                                     "AUTO",
                                     datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
                                     datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
                                     ts_api_selected_values['coverageAnalysis']['samples'][sample]['tumorDNA']['Target_Regions_Alias']
                                     )
                               )
                    cnx.commit()
                    try:
                        if sample_counter == 1:
                            if no_email is False:
                                to_emails = ["michael.d'eletto@ynhh.org", 
                                             "Stephen.Hutchison@YNHH.ORG",
                                             "Taylor.Falk@YNHH.ORG",
                                              "Lori.Avery@ynhh.org",
                                              "rong.cong@ynhh.org",
                                              "jennifer.thomas@ynhh.org",
                                              "Jocelyn.Sadala@ynhh.org"
#                                              "tyler.washington@ynhh.org",
#                                              "DOMINIKA.BAJGUZ@ynhh.org"
                                             ]
                                email = smtplib.SMTP('localhost')
                                msg = "Subject: %s SEQUENCING RUN COMPLETE\n%s has completed on instrument %s" % (instrument, ts_api_selected_values['coverageAnalysis']['samples'][sample]['torrentSuiteResultName'],
                                                                             instrument)
                                email.sendmail("TPTracker@ynhh.org", to_emails, msg)
                                email.quit()
                    except Exception, e:
                        print "WARNING: Could not send email confirmation. %s" % str(e)
                    
                except MySQLdb.IntegrityError as err:
                    cnx.rollback()
                    # Ignore duplicate_key error, but raise exception otherwise
                    if err[0] != 1062:
                        raise

        else:
            if index_type_name is not False:
                pass
                #pretty_obj = json.dumps(ts_api_selected_values[index_type], indent=4)
                #print index_type_name
                #print pretty_obj
                #es.index("tumor-profiling-lab-torrentsuiteqc", index_type_name, pretty_obj, runName)
                
    cursor.close()
    cnx.close()




  


if __name__ == "__main__":
    main()
