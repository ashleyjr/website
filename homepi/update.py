#import commands
import socket
#import urllib
from urllib2 import urlopen, URLError, HTTPError
import netifaces as ni
from ftplib import FTP

# Get ip address
ni.ifaddresses('wlan0')
ip = ni.ifaddresses('wlan0')[2][0]['addr']


# Get tail of syslog
#log = commands.getoutput("tail -10 /var/log/syslog.1")
#log = urllib.quote(log, safe='')

#log = "test"
# make update for website
url = "http://www.ajrobinson.org/ip.php?machine=pi&ip=" + ip
print url


# Send the update
socket.setdefaulttimeout( 23 )  # timeout in seconds
response = urlopen( url )

#print response

# Send the log file
ftp = FTP('ftp.ajrobinson.org')                 # connect to host, default port
ftp.login('username','password')               # user anonymous, passwd anonymous@

file = open('/var/log/syslog','rb')             # file to send
ftp.storbinary('STOR pi.log', file)             # send the file
file.close()                                    # close file and FTP

file = open('/var/log/syslog.1','rb')           # send slihtly older sys log
ftp.storbinary('STOR pi1.log', file)
file.close()

ftp.close()

