#!/bin/bash
set -e
DIR=`php -r "echo dirname(dirname(realpath('$0')));"`
cd "$DIR"

# Check argument
if [ -z "$1" ]; then
    echo "Specify one argument: gitlib, gitonomy"
    exit 1
fi

# Configuration, according to project
if [ "$1" == "gitlib" ]; then
    VERSIONS="master"
    URL="git@github.com:gitonomy/gitlib.git"
    REPOSITORY_DIR="doc"
    PROJECT="gitlib"
elif [ "$1" == "gitonomy" ]; then
    echo "Not implemented yet..."
    exit 1
else
    echo "Unknown project"
    exit 1
fi

# Move to project
if [ ! -d cache/doc/$PROJECT ]; then
    mkdir -p "cache/doc/$PROJECT"
fi

cd "cache/doc/$PROJECT"

# Remove old temporary cache
if [ -d __tmp ]; then
    echo "- Remove previous generated cache"
    rm -rf __tmp
fi

echo "- Created temporary folder"
mkdir -p __tmp

if [ ! -d repository ]; then
    echo "- Clone repository"
    git clone "$URL" repository
else
    echo "- Update repository"
    cd repository
    git fetch
    cd ..
fi

for VERSION in $VERSIONS; do
    echo "- Start version $VERSION"
    cd repository
    git checkout origin/$VERSION
    cd ..

    echo "- Building JSON"
    sphinx-build -b json -E -c ../../../bin "repository/$REPOSITORY_DIR" "__tmp/$VERSION"
done

echo "- Cache directory generated"

if [ -d json ]; then
    echo "- Switching folders"
    mv json __old
    mv __tmp json
    rm -rf __old
else
    echo "- Installing cache"
    mv __tmp json
fi
