import socket
from urllib2 import urlopen, URLError, HTTPError
import netifaces as ni
import urllib
import re
import os


# Start
print "   Running startup.py"
print ""

# External address
f = urllib.urlopen("http://www.canyouseeme.org/")
html_doc = f.read()
f.close()
m = re.search('(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)',html_doc)
print "      IP Address:       " + m.group(0)

# Internal address
ni.ifaddresses('wlan0')
ip = ni.ifaddresses('wlan0')[2][0]['addr']
print "      Local IP Address: " + ip



# cronjobs
print ""
print "      Cronjobs..."
os.system("crontab -l")





# Finish
print ""
print "   Exiting startup.py"
