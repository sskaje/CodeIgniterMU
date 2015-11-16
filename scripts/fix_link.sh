#!/bin/sh

SCRIPT=$(realpath $0)
WEBROOT=$(dirname $(dirname $(realpath $0)))

if [ $# -lt 1 ]
then
	echo -e Fix site symbolic links
	echo -e $'\e[32m'Usage:$'\e[0m' $SCRIPT SITE_NAME
	exit
fi

SHARED_ROOT=$WEBROOT/apps/shared
TARGET_ROOT=$WEBROOT/apps/$1

if [ $SHARED_ROOT = $TARGET_ROOT ];
then
    echo -e $'\e[31mError: NO CHANGES MADE ON "shared" \e[0m'
    exit
fi

if [ ! -d $TARGET_ROOT ]; 
then 
	echo -e $'\e[31mError:\e[0m' $TARGET_ROOT not found!
	exit
else
    echo -e $'\e[33m'Processing $TARGET_ROOT $'\e[0m'
fi 


LINK_DIR=( core helpers hooks language libraries models third_party )
LINK_CONFIG=( constants.php database.php memcached.php redis.php )
LINK_CI_CONFIG=( doctypes.php foreign_chars.php mimes.php smileys.php user_agents.php )

function relate_path()
{
	echo $1 | sed -E 's#^/.+/apps#apps#g'
}

function fix_dir()
{
	F=$TARGET_ROOT/$1
	rF=$(relate_path $F)
	LT=../shared/$1

	if [ -h $F ];
	then
		NLT=$(readlink $F)
		if [ "$NLT" != "$LT" ];
		then
			echo -e $'\e[32m'  $rF $'\e[0m' is linked to $'\e[31m'$NLT$'\e[0m' not $'\e[32m'$LT$'\e[0m'
			unlink $F
			cd $TARGET_ROOT
			ln -s $LT $1
			echo -e $'\e[32m'  $rF $'\e[0m' is linked to $'\e[32m'$LT$'\e[0m'
		else
			echo -e $'\e[32m'  $rF $'\e[0m' is linked to $'\e[32m'$LT$'\e[0m'
		fi;

	elif [ ! -e $F ];
	then 
		cd $TARGET_ROOT
		ln -s $LT $1
		echo -e $'\e[32m'  $rF $'\e[0m' is now linked to $'\e[31m'../shared/$1$'\e[0m'

	elif [ -d $F ];
	then
		echo -e $'\e[31m'  $rF exists and is NOT a symbolic link!$'\e[0m'
		rsync -rlv $F $SHARED_ROOT
		rm -rf $F
		cd $TARGET_ROOT
		ln -s LT $1
		echo -e $'\e[32m'  $rF $'\e[0m' is now linked to $'\e[31m'../shared/$1$'\e[0m'
	else 
		echo -e $'\e[31m'  $rF exists and is a FILE!$'\e[0m'
		rm -f $F
		cd $TARGET_ROOT
		ln -s $LT $1
		echo -e $'\e[32m'  $rF $'\e[0m' is now linked to $'\e[31m'../shared/$1$'\e[0m'
	fi

}

function fix_config()
{
	F=$TARGET_ROOT/config/$1
	rF=$(relate_path $F)
    LT=../../shared/config/$1

	if [ -h $F ];
	then
		NLT=$(readlink $F)
		if [ "$NLT" != "$LT" ];
		then
			echo -e $'\e[32m'  $rF $'\e[0m' is linked to $'\e[31m'$NLT$'\e[0m' not $'\e[32m'$LT$'\e[0m'
			unlink $F
			cd $TARGET_ROOT/config
			ln -s $LT $1
			echo -e $'\e[32m'  $rF $'\e[0m' is linked to $'\e[32m'$LT$'\e[0m'
		else
			echo -e $'\e[32m'  $rF $'\e[0m' is linked to $'\e[32m'$LT$'\e[0m'
		fi;
	elif [ ! -e $F ];
	then 
		cd $TARGET_ROOT/config
		ln -s $LT $1
		echo -e $'\e[32m'  $rF $'\e[0m' is now linked to $'\e[31m'../shared/$1$'\e[0m'
	elif [ -f $F ];
	then
		echo -e $'\e[31m'  $rF exists and is NOT a symbolic link!$'\e[0m'
		cp $F $SHARED_ROOT/config/
		rm -f $F
		cd $TARGET_ROOT/config
		ln -s $LT $1
		echo -e $'\e[32m'  $rF $'\e[0m' is now linked to $'\e[31m'../shared/$1$'\e[0m'
	else 
		echo -e $'\e[31m'  $rF exists and is a FILE!$'\e[0m'
		rm -rf $F
		cd $TARGET_ROOT/config
		ln -s $LT $1
		echo -e $'\e[32m'  $rF $'\e[0m' is now linked to $'\e[31m'../shared/$1$'\e[0m'
	fi
}


for i in ${LINK_DIR[@]}; do
	fix_dir $i;
done

for i in ${LINK_CONFIG[@]}; do
	fix_config $i;
done 

for i in ${LINK_CI_CONFIG[@]}; do
	fix_config $i;
done


