#!/usr/bin/python

import MySQLdb
import synapseclient
from collections import defaultdict, OrderedDict
import re
import requests
import json
from pprint import PrettyPrinter


def __main__():

    global pp
    global db

    pp = PrettyPrinter(indent=4)

    # Open database connection
    db = MySQLdb.connect("mysql","root","*23Ft198","tumor_profiling_lab" )
    
    # prepare a cursor object using cursor() method
    cursor = db.cursor()

    def update_TPTracker_with_synapse_definitions(cursor):
                
        statements_and_tables = {
                                 'GENIESex' : {
                                               'synapse_id' : 'syn7434222'                           
                                               },
                                 'GENIERace' : {
                                                'synapse_id' : 'syn7434236'
                                                },
                                 'GENIEEthnicity' : {
                                                     'synapse_id' : 'syn7434242'
                                                     },
                                 'GENIESampleType' : {
                                                      'synapse_id' : 'syn7434273'
                                                      }
                                }
        
        syn = synapseclient.Synapse()
        
        syn.login('michael.deletto@yale.edu', '*23Ft198')
        
        for table in statements_and_tables.keys():
            synapse_id = statements_and_tables[table]['synapse_id']
            columns = syn.getColumns(synapse_id)
            column_list = []
            for column in columns:
                column = column['name']
                column_list.append(column)

            cursor.execute("TRUNCATE TABLE %s" % table)
            
            results = syn.tableQuery("SELECT %s FROM %s" % (",".join(column_list), synapse_id))
            for row in results:
                row_subset = row[2:5]
                column_value_zip = dict(zip(column_list, row_subset))
                
                # Prepare SQL query to UPDATE required records
                sql = "INSERT INTO %s" % table
                sql = sql + " VALUES(%s,%s,%s)"
                
                try:
                    # Execute the SQL command
                    cursor.execute(sql, row_subset)
                    # Commit your changes in the database
                    db.commit()
                except:
                    # Rollback in case there is any error
                    db.rollback()
    
    def update_TPTracker_with_oncotree_codes(cursor):
                
        
        cancer_types = []
        with open("/home/michael/YNHH/Reference_Files/OncoTree/tumor_types.txt") as f:
            for line in f.readlines():
                line = line.strip()
                if not re.match("level", line):
                    split_line = line.split("\t")
                    subset = split_line[:7]
                    for item in subset:
                        if item != '':
                            cancer_types.append(item)
                
        for cancer_type in sorted(set(cancer_types)):
            oncotree_code = re.search("\((\w+?)\)", cancer_type).group(1)
            description = re.search("(.+?)\(", cancer_type).group(1)
            tmp_list = [cancer_type,
                        description,
                        oncotree_code]
            print tmp_list
            sql = "INSERT INTO GENIEOncotree VALUES(%s,%s,%s)"
            try:
                # Execute the SQL command
                cursor.execute(sql, tmp_list)
                # Commit your changes in the database
                db.commit()
            except:
                # Rollback in case there is any error
                db.rollback()
            
        # Code below uses the OncoTree API, but GENIE is using a versioned file, so this method is not necessary    
        
#         try:
#             r = requests.get('http://oncotree.mskcc.org/oncotree/api/tumorTypes?flat=true&deprecated=false')
#         except:
#             r = None
#         
#         if r:
#             try:
#                 cancer_types = []
#                 loaded = json.loads(json.dumps(r.json()))
#                 
#                 for cancer_type in loaded['data']:
#                     code = cancer_type['code']
#                     description = cancer_type['name']
#                     detailed_description = description + " (%s)" % code
#                     tmp_list = [code,
#                                 description,
#                                 detailed_description]
#                     cancer_types.append(tmp_list)
#             except:
#                 print "ERROR: Could not successfully parse Oncotree request"
#                 cancer_types = None
#             
#             if cancer_types:
#                 cursor.execute("TRUNCATE TABLE GENIEOncotree")
#                 for cancer_type in cancer_types:
#                     sql = "INSERT INTO GENIEOncotree VALUES(%s,%s,%s)"
#                     try:
#                         # Execute the SQL command
#                         cursor.execute(sql, cancer_type)
#                         # Commit your changes in the database
#                         db.commit()
#                     except:
#                         # Rollback in case there is any error
#                         db.rollback()
    
    def update_GENIE_IDs(cursor):
        
        columns = ['internalPatientID',
                   'copathID',
                   'patientID',
                   'sampleID',
                   'signoutDate'
                   ]
        
        sql = "SELECT %s FROM AACRGenie WHERE GENIEStage REGEXP 'QUEUE|READY|SUBMITTED'" % (",".join(columns))
    
        cursor.execute(sql)
        
        results = cursor.fetchall()

        patient_id_numbers = []
        for row in results:
            print row
            internal_patient_id, copath_id, patient_id, sample_id, signout_date = (i for i in row)
            try:
                patient_id = re.match("GENIE-YALE-TPL(\d+)", str(patient_id)).group(1)
                print patient_id
                patient_id_numbers.append(int(patient_id))
            # if unable to find a match, we don't have an ID
            except:
                pass
        try:
            max_patient_id = max(patient_id_numbers)
            print max_patient_id
        except:
            max_patient_id = 1
        
        print patient_id_numbers
        
        patient_id_counter = max_patient_id
        
        patient_id_dict = defaultdict(dict)
        for row in results:
            internal_patient_id, copath_id, patient_id, sample_id, signout_date = (i for i in row)
            if patient_id is None:
                # If not in patient_id_dict, assign new GENIE ID
                if internal_patient_id not in patient_id_dict.keys():
                    for _id in [n+1 for n in range(max_patient_id)]:
                        if _id not in patient_id_numbers and _id <= max_patient_id:
                            patient_id_dict[internal_patient_id].update({'patient_id' : "GENIE-YALE-TPL%s" % str(_id)})
                            patient_id_numbers.append(_id)
                            break
                        if _id in patient_id_numbers:
                            patient_id_counter += 1
                            patient_id_dict[internal_patient_id].update({'patient_id' : "GENIE-YALE-TPL%s" % str(patient_id_counter)})
                            break
            else:
                patient_id_dict[internal_patient_id].update({'patient_id' : patient_id})

        for patient_id in patient_id_dict.keys():
            patient_id_dict[patient_id]['samples'] = []
        
        for row in results:
            internal_patient_id, copath_id, patient_id, sample_id, signout_date = (i for i in row)
            patient_id_dict[internal_patient_id]['samples'].append({
                                                                    'copath_id' : copath_id,
                                                                    'sample_id' : sample_id,
                                                                    'signout_date' : signout_date
                                                                    })
        
        for internal_patient_id in patient_id_dict:
            patient_id_dict[internal_patient_id]['max_sample_id'] = 0
            for sample in patient_id_dict[internal_patient_id]['samples']:
                try:
                    sample_id = re.match("GENIE-YALE-TPL\d+?-(\d+?)", sample['sample_id']).group(1)
                    if int(sample_id) > patient_id_dict[internal_patient_id]['max_sample_id']:
                        patient_id_dict[internal_patient_id]['max_sample_id'] = int(sample_id)
                # if unable to find a match, we don't have an ID
                except:
                    pass
        
        for internal_patient_id in patient_id_dict:
            reconstructed_sample_list = []
            for sample in list(patient_id_dict[internal_patient_id]['samples']):
                if sample['sample_id'] is None:
                    patient_id_dict[internal_patient_id]['max_sample_id'] += 1
                    sample['sample_id'] = patient_id_dict[internal_patient_id]['patient_id'] + "-%s" % patient_id_dict[internal_patient_id]['max_sample_id']
                
                reconstructed_sample_list.append(sample)
                
            patient_id_dict[internal_patient_id]['samples'] = reconstructed_sample_list

        # Perform MySQL GENIE ID update
        for internal_patient_id in patient_id_dict:
            for sample in patient_id_dict[internal_patient_id]['samples']:
                try:
                    cursor.execute ("""UPDATE AACRGenie
                                       SET patientID=%s, sampleID=%s
                                       WHERE copathID=%s and signoutDate=%s""", (patient_id_dict[internal_patient_id]['patient_id'],
                                                              sample['sample_id'],
                                                              sample['copath_id'],
                                                              sample['signout_date']
                                                              ))
                    
                    db.commit()
                    
                except Exception, e:

                    print str(e)
                    db.rollback()
                    
    def update_datetime_fields(cursor):
        
        def calculate_date_fields_to_update(result_dict):
            
            if result_dict['DOB'] is not None:
                result_dict['birthYear'] = result_dict['DOB'].year
            if result_dict['DOB'] is not None and result_dict['signoutDate'] is not None:
                result_dict['ageAtSeqReport'] = result_dict['signoutDate'] - result_dict['DOB']
                result_dict['ageAtSeqReport'] = result_dict['ageAtSeqReport'].days
            if result_dict['technicalCompletionDate'] is not None:
                if result_dict['technicalCompletionDate'].month <= 3:
                    result_dict['seqDate'] = "Jan-%s" % result_dict['technicalCompletionDate'].year
                elif result_dict['technicalCompletionDate'].month <= 6:
                    result_dict['seqDate'] = "Apr-%s" % result_dict['technicalCompletionDate'].year
                elif result_dict['technicalCompletionDate'].month <= 9:
                    result_dict['seqDate'] = "Jul-%s" % result_dict['technicalCompletionDate'].year
                elif result_dict['technicalCompletionDate'].month <= 12:
                    result_dict['seqDate'] = "Oct-%s" % result_dict['technicalCompletionDate'].year 
            if ((result_dict['copathID'] is None or 
                result_dict['signoutDate'] is None or 
                result_dict['technicalCompletionDate'] is None or
                result_dict['internalPatientID'] is None) and not result_dict['GENIEstage'] in ["SUBMITTED","READY"]):
                result_dict['GENIEstage'] = "ERROR-I"
              
            return result_dict
        
        columns = ['copathID',
                   'sampleID',
                   'birthYear',
                   'DOB',
                   'ageAtSeqReport',
                   'signoutDate',
                   'technicalCompletionDate',
                   'seqDate',
                   'GENIEstage',
                   'internalPatientID'
                   ]
        
        sql = "SELECT %s FROM AACRGenie" % (",".join(columns))
    
        cursor.execute(sql)
        
        results = cursor.fetchall()
        
        for result in results:
            result_dict = dict(zip(columns,result))
            result_dict = calculate_date_fields_to_update(result_dict)
            pp.pprint(result_dict)
            try:
                cursor.execute ("""UPDATE AACRGenie
                                   SET birthYear=%s, ageAtSeqReport=%s, seqDate=%s, GENIEstage=%s
                                   WHERE copathID=%s""", (result_dict['birthYear'],
                                                           result_dict['ageAtSeqReport'],
                                                           result_dict['seqDate'],
                                                           result_dict['GENIEstage'],
                                                           result_dict['copathID']
                                                           
                                                          ))
                
                db.commit()
                
            except Exception, e:

                print str(e)
                db.rollback()
            
        
        
    #update_TPTracker_with_synapse_definitions(cursor)
    
    update_GENIE_IDs(cursor)
    
    #update_TPTracker_with_oncotree_codes(cursor)
    
    update_datetime_fields(cursor)
    
    # disconnect from server
    db.close()


if __name__ == "__main__":
    __main__()
