#!/usr/bin/python

import MySQLdb
import re

def __main__():

    def automatic_care_center_reassignment():
        """Assign care centers based on ordering physician's last name."""
        
        tables = ['sequencing_cases', 'taqmanCases']
    
        for table in tables:
            # Prepare SQL query to UPDATE required records
            sql = """UPDATE %s \
                        SET care_center_name = CASE
                            WHEN requesting_physician REGEXP 'NGUYEN|ORELL' THEN 'Derby'
                            WHEN requesting_physician REGEXP 'TALSANIA|BRANDT|GOMEZ|HARVEY' THEN 'Torrington'
                            WHEN requesting_physician REGEXP 'SABBATH|CHANG|KATOCH' THEN 'Waterbury'
                            WHEN requesting_physician REGEXP 'ZAHEER|HAEDICKE|LIM' THEN 'Guilford'
                            WHEN requesting_physician REGEXP 'LASALA|CHUNG' THEN 'Orange'
                            WHEN requesting_physician REGEXP 'KORTMANSKY|FYNAN|SORCINELLI|BOBER' THEN 'North Haven'
                            WHEN requesting_physician REGEXP 'TARA|FISCHBACH|MALEFATTO|WITT|PERSICO' THEN 'Trumbull/Fairfield'
                            WHEN requesting_physician REGEXP 'NEWTON|HELLMAN|KANOWITZ|HALDAS' THEN 'Waterford'
                            ELSE 'Other'
                    END
                    WHERE requesting_physician IS NOT NULL and care_center_name IS NULL
                    """ % table
    
            try:
                # Execute the SQL command
                cursor.execute(sql)
                # Commit your changes in the database
                db.commit()
            except:
                # Rollback in case there is any error
                db.rollback()

    def automatic_case_status_update():
        """Fetch cases that have a signout dates and check to make sure they are marked as completed."""
        
        # AUTOMATIC CASE STATUS OVERRIDE
    
        columns = ['copath_id',
                   'case_status',
                   'signout_date'
                   ]
        
        # To save time, select only cases with a signout date, but have not yet been marked as Completed
        sql = "SELECT %s FROM sequencing_cases WHERE signout_date IS NOT NULL and (case_status NOT LIKE 'Completed' OR case_status IS NULL)" % (",".join(columns))
        cursor.execute(sql)
        results = cursor.fetchall()
        
        for result in results:
            # zip columns and values together
            result_dict = dict(zip(columns,result))
        
            # Only modify if case is signed out, but not marked as complete
            # These should've been filtered out already by the MySQL SELECT statement
            if result_dict['signout_date'] is not None:
                
                # If no one has filled out case status, then assign it
                if result_dict['case_status'] is None:
                    result_dict['case_status'] = "Completed"
                else:
                    # multiple checkboxes from TPTracker, use substitution instead
                    if re.search("\n", result_dict['case_status']):
                        result_dict['case_status'] = re.sub("Pending", "Completed", result_dict['case_status'])
                    # if single field selection, just override
                    else:
                        # If incorrectly marked as Pending, then override
                        if result_dict['case_status'] == 'Pending':
                            result_dict['case_status'] = 'Completed'
                        # If marked as Cancelled but still signed out, then append Completed
                        if result_dict['case_status'] == 'Cancelled':
                            result_dict['case_status'] += "\nCompleted"
            
                # Prepare SQL query to UPDATE required records
                sql = """UPDATE sequencing_cases
                        SET case_status = %s
                        WHERE copath_id = %s AND signout_date = %s
                        """
                try:
                    # Execute the SQL command
                    cursor.execute(sql, (result_dict['case_status'],
                                         result_dict['copath_id'],
                                         result_dict['signout_date']))
                    # Commit your changes in the database
                    db.commit()
                except Exception, e:
                    print str(e)
                    # Rollback in case there is any error
                    db.rollback()

    def delete_blank_sequencing_cases():
        
        sql = "DELETE FROM sequencing_cases WHERE name IS NULL AND copath_id IS NULL AND DATEDIFF(NOW(), lastModified) >= 14" 
        try:
            # Execute the SQL command
            cursor.execute(sql)
            # Commit your changes in the database
            db.commit()
        except Exception, e:
            print str(e)
            # Rollback in case there is any error
            db.rollback()

    def add_popnorm():
        """Adds PopNorm controls to TPTracker analyses in case no population normal was selected.
           NOTE: Uses CNV detection boolean to determine if case was run as a paired analysis.
        """
        
        sql = """UPDATE targetedNGSRunQualityControlMetrics SET normalSampleName = 
                 CASE
                     WHEN targetRegionAlias LIKE 'HSM' THEN 'PopulationNormalHSMv1'
                     WHEN targetRegionAlias LIKE 'OCPv3' THEN 'PopulationNormalOCPv3'
                     WHEN targetRegionAlias LIKE 'OCP' THEN 'PopulationNormalOCPv2'
                     ELSE 'PopulationNormal'
                END
                WHERE cnvAssessment = 1 and workflowStatus LIKE 'In-Progress' and normalSampleName IS NULL
            
            """ 
        try:
            # Execute the SQL command
            cursor.execute(sql)
            # Commit your changes in the database
            db.commit()
        except Exception, e:
            print str(e)
            # Rollback in case there is any error
            db.rollback()  

    # Open database connection
    db = MySQLdb.connect("mysql","root","*23Ft198","tumor_profiling_lab" )
    
    # prepare a cursor object using cursor() method
    cursor = db.cursor()
    
    # Perform updates
    automatic_case_status_update()
    automatic_care_center_reassignment()
    delete_blank_sequencing_cases()
    add_popnorm()
 
    db.close()
    
    # # Prepare SQL query to UPDATE required records
    # sql = """UPDATE sequencing_cases \
    #             SET targetCompletionDate = CASE
    #                 WHEN tumor_to_tpl_date is NOT NULL THEN DATE_SUB(tumor_to_tpl_date, INTERVAL -10 DAY)
    #                 WHEN req_date is NOT NULL THEN DATE_SUB(req_date, INTERVAL -14 DAY)
    #                 ELSE NULL
    #         END
    #         WHERE case_status NOT REGEXP 'Cancelled'
    #         """
    # 
    # try:
    #     # Execute the SQL command
    #     cursor.execute(sql)
    #     # Commit your changes in the database
    #     db.commit()
    # except:
    #     # Rollback in case there is any error
    #     db.rollback()
    # 
    # # Prepare SQL query to UPDATE required records
    # sql = """UPDATE sequencing_cases \
    #             SET dueDateCountdown = CASE
    #                 WHEN signout_date is NOT NULL THEN NULL    
    #                 ELSE DATEDIFF(targetCompletionDate, CURDATE())
    #         END
    #         WHERE case_status NOT REGEXP 'Cancelled' AND targetCompletionDate IS NOT NULL
    #         """
    # 
    # try:
    #     # Execute the SQL command
    #     cursor.execute(sql)
    #     # Commit your changes in the database
    #     db.commit()
    # except:
    #     # Rollback in case there is any error
    #     db.rollback()
    # 
    # # disconnect from server
    # db.close()

if __name__ == "__main__":
    __main__()
