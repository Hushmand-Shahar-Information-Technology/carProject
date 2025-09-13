#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

# FTP server details
HOSTINGER_HOST="46.28.46.86"
HOSTINGER_PORT="65002"
HOSTINGER_USER="u285585646"
FTP_PASSWORD="Wardak@1161997"

# Change these to your local and remote directories
LOCAL_DIR="."
REMOTE_DIR="/home/u285585646/domains/topmotar.com/public_html/beta"

# Print debug information
echo "FTP_HOST: $HOSTINGER_HOST"
echo "FTP_PORT: $HOSTINGER_PORT"
echo "FTP_USERNAME: $HOSTINGER_USER"
echo "LOCAL_DIR: $LOCAL_DIR"
echo "REMOTE_DIR: $REMOTE_DIR"

# Use lftp to mirror the local directory to the remote directory, skipping SSL verification
"/c/Users/DELL XPS/scoop/shims/lftp" -d -c "
set ssl:verify-certificate no;
open -p $HOSTINGER_PORT -u $HOSTINGER_USER,$FTP_PASSWORD $HOSTINGER_HOST;
mirror -R --verbose --only-newer --parallel=10 $LOCAL_DIR $REMOTE_DIR;
bye;
"