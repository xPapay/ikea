#!/bin/bash

sed -i -e "s@SERVER_NAME@$SERVER_NAME@g" /etc/apache2/sites-available/${SERVER_NAME}.conf
sed -i -e "s@DOCUMENT_ROOT@$DOCUMENT_ROOT@g" /etc/apache2/sites-available/${SERVER_NAME}.conf