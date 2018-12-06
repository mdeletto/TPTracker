FROM mdeletto/tptracker-apache2-php5-config:latest

# Copy TPTracker source code
COPY . /var/www/html/TPTracker

# Add TPTRACKERPATH env variable
ENV TPTRACKERPATH /var/www/html/TPTracker

# Change permissions to 777 - Xataface complains about other permissions
RUN chmod -R 777 $TPTRACKERPATH

# Install dependencies
RUN apt-get update && apt-get install -y php5-ldap cron python-pip libmysqlclient-dev python-dev libffi-dev libssl-dev libxml2-dev libxslt1-dev libjpeg8-dev zlib1g-dev
WORKDIR $TPTRACKERPATH
RUN pip install -U setuptools
RUN pip install -r ./bin/requirements.txt

# Add crontab file in the cron directory
ADD crontab /etc/cron.d/hello-cron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/hello-cron

# Apply cron job
RUN crontab /etc/cron.d/hello-cron

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Make TPTracker log directories
RUN mkdir -p $TPTRACKERPATH/log/tplTorrentQC && chmod -R 777 $TPTRACKERPATH/log/

# Start apache2 in case it went down during ldap module install
service apache2 start

# Run the command on container startup
CMD cron && tail -f /var/log/cron.log
