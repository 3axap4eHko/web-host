#/bin/sh
cd `dirname $0`
WEBHOST=`pwd`/web-host.sh
if [ -f /usr/bin/web-host ]
then
    sudo rm /usr/bin/web-host
fi
sudo sh -c "echo '$WEBHOST $*'>/usr/bin/web-host"
sudo chmod +x /usr/bin/web-host