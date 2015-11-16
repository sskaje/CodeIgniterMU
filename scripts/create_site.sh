#!/bin/sh

SCRIPT=$(realpath $0)
WEBROOT=$(dirname $(dirname $(realpath $0)))

if [ $# -lt 1 ]
then
	echo -e Create new site from template
	echo -e $'\e[32m'Usage:$'\e[0m' $SCRIPT SITE_NAME
	exit
fi

TPLPATH=$WEBROOT/apps/template
TO_PATH=$WEBROOT/apps/$1

if [ $TPLPATH = $TO_PATH ];
then
    echo -e $'\e[31mError: NO CHANGES MADE ON "template" \e[0m'
    exit
fi

if [ -e $TO_PATH ];
then 
	echo -e $'\e[31mError:\e[0m' $TO_PATH already exists.
	exit
fi

if [ ! -d $TPLPATH ];
then 
	echo -e $'\e[31mError:\e[0m' $TPLPATH not found.
	exit
fi 

cp -R $TPLPATH $TO_PATH

echo Done: $TO_PATH created.
