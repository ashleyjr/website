# Submit your local machine name and IP address to ajrobinson.org
import socket, urllib2
machine = socket.gethostname()
print "\nMachine: " + machine
ip = urllib2.urlopen("http://ipecho.net/plain").read()
print "IP: " + ip
print "Submitting...\n"
print "Response..."
print urllib2.urlopen("http://www.ajrobinson.org/ip.php?machine=" + machine + "&ip=" + ip).read()
