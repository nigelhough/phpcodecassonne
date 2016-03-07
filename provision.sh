#!/usr/bin/env bash

#
# Set up the package repository, with PHP 5.6.
#
apt-get update
apt-get install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt-get update

#Install PHP7
sudo apt-get install -y php7.0

#Test
echo "Hello World"