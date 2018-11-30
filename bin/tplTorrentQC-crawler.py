#!/usr/bin/python

import requests
import dateutil.parser
import datetime
import subprocess
import os
from pprint import PrettyPrinter

# Used for testing
#date1 = datetime.datetime.strptime("Nov 21 2016", "%b %d %Y")


pp = PrettyPrinter(indent=4)

server_list = [#'10.80.157.20',  
               '10.71.60.152', # TPL S5XL2
               '10.71.60.151' # TPL S5XL
               ]


for ip_address in server_list:
    print ip_address
    ts_api_request = requests.get("http://%s/rundb/api/v1/results" % ip_address, 
                                  params={"format": "json", "order_by" : "-timeStamp"}, 
                                  auth=("downstream","downstream"))
    
    ts_api_response = ts_api_request.json()

    for obj in ts_api_response['objects']:

        timestamp = dateutil.parser.parse(obj['timeStamp'])
        
        # Used for testing
        if  timestamp.date() == datetime.date.today() and obj['status'] == 'Completed':
        #if  timestamp.date() == date1.date() and obj['status'] == 'Completed': 
               
            resultsName = obj['resultsName']
            if resultsName.endswith("_tn"):
                pass
            else:
                print resultsName
                log_stdout = open("%s/log/tplTorrentQC/%s.%s.stdout.log" % (os.environ['TPTRACKERPATH'], resultsName, datetime.datetime.now().strftime('%Y%m%dT%H%M%S')), 'a+')
                log_stderr = open("%s/log/tplTorrentQC/%s.%s.stderr.log" % (os.environ['TPTRACKERPATH'], resultsName, datetime.datetime.now().strftime('%Y%m%dT%H%M%S')), 'a+')
                
                log_stdout.write(("-" * len(resultsName))+"\n")
                log_stdout.write("ATTEMPTING TO PROCESS QC DATA FOR: %s\n" % resultsName)
                log_stdout.write(("-" * len(resultsName))+"\n")
                
                coverage_analysis_detected = False
                for pluginresults in obj['pluginresults']:
                    plugin_result_request = requests.get("http://%s%s" % (ip_address, pluginresults), 
                                                         params={"format": "json", "order_by" : "-timeStamp"}, 
                                                         auth=("downstream","downstream"))
                    plugin_result_response = plugin_result_request.json()
                    
                    if plugin_result_response['pluginName'] == "coverageAnalysis":
                        try:
                            if plugin_result_response['state'] == "Completed":
                                if coverage_analysis_detected is False:
                                    print resultsName
                                    coverage_analysis_detected = True
                                    log_stdout.write("OK: coverageAnalysis plugin results detected for %s\n" % resultsName)
                                    log_stdout.write("OK: Proceeding with tplTorrentQC.py\n")
                                    log_stdout.flush()
                                    print resultsName
                                    subprocess.call("/var/www/TPL/TPTracker/bin/tplTorrentQC.py -a %s --ip-address %s" % (resultsName, ip_address), stdout=log_stdout, stderr=log_stderr, shell=True)
                                    print resultsName
                                else:
                                    log_stderr.write("ERROR: Multiple coverageAnalysis results detected.  This option is unsupported for now.  Please delete extra coverageAnalysis results.  Exiting...\n")
                            else:
                                log_stderr.write("ERROR: Unrecognized plugin state for coverageAnalysis.  Exiting...\n")
                        except KeyError:
                            log_stderr.write("ERROR: 'state' does not exist as key through API for this plugin.  Exiting...\n")
                        except Exception, e:
                            log_stderr.write("ERROR: %s\n" % str(e))
                
                log_stdout.close()
                log_stderr.close()   
