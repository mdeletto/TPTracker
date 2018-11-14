#!/bin/bash

for server in 10.71.60.151 10.71.60.152
do
	rsync -av --ignore-existing --exclude "block*" --include "*/" --include "*.png" --exclude "*" ionadmin@$server:/results/analysis/output/Home/ /var/www/html/TPTracker/images/TSruns
done
