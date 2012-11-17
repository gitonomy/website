#!/bin/bash
set -e
cd "$(dirname $0)"

if [ "$1" == "" ]; then
    echo "You must specify version to build"
    exit 1
fi

if [ ! -d ../cache/pack ]; then
    mkdir -p ../cache/pack
fi

cd ../cache/pack

if [ ! -d repository ]; then
    git clone https://github.com/gitonomy/gitonomy.git repository
    cd repository
else
    cd repository
    git fetch origin
fi

git checkout origin/$1
./pack.sh

cd ../../.. # back to project root

if [ ! -d web/downloads ]; then
    mkdir web/downloads
fi

mv cache/pack/repository/pack.tar.gz web/downloads/$1.tar.gz
