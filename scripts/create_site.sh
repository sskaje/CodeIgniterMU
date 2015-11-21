#!/bin/sh
#
# CodeIgniter MUltiple Site Management Scripts - Create Site from Templates
#
# This content is released under the MIT License (MIT)
#
# Copyright (c) 2015 sskaje
#
# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the "Software"), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in all
# copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
# SOFTWARE.
#
#

SCRIPT=$(realpath $0)
WEBROOT=$(dirname $(dirname $(realpath $0)))

if [ $# -lt 1 ]
then
	echo -e Create new site from template
	echo -e Author: sskaje
	echo -e $'\e[32m'Usage:$'\e[0m' $SCRIPT SITE_NAME
	exit
fi

TPL_ROOT=$WEBROOT/apps/template
SHARED_ROOT=$WEBROOT/apps/shared
TARGET_ROOT=$WEBROOT/apps/$1

if [ $TARGET_ROOT = $TPL_ROOT ];
then
    echo -e $'\e[31mError: NO CHANGES MADE ON "template" \e[0m'
    exit
fi
if [ $TARGET_ROOT = $SHARED_ROOT ];
then
    echo -e $'\e[31mError: NO CHANGES MADE ON "shared" \e[0m'
    exit
fi

if [ -e $TARGET_ROOT ];
then 
	echo -e $'\e[31mError:\e[0m' $TARGET_ROOT already exists.
	exit
fi

if [ ! -d $TPL_ROOT ];
then 
	echo -e $'\e[31mError:\e[0m' $TPLPATH not found.
	exit
fi 

cp -R $TPL_ROOT $TARGET_ROOT

echo Done: $TARGET_ROOT created.
