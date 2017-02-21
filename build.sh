#!/bin/sh

git pull
ng build --environment=prod --target=production --aot
cd dist
ln -s ../src/api
