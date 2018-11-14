#!/bin/bash

for server in 10.80.61.55 10.80.157.20
do
	rsync -av --ignore-existing --exclude "block*" --include "*/" --include "*.png" --exclude "*" ionadmin@$server:/results/analysis/output/Home/ /var/www/TPL/TPTracker/images
done
