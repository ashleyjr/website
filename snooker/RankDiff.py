import sys
from urllib import urlopen
from BeautifulSoup import BeautifulSoup
import re

def striphtml(data):
    p = re.compile(r'<.*?>')
    return p.sub('', data)







""" The ranking """

url = 'http://www.snooker.org/res/index.asp?template=31&season=2016'
text_soup = BeautifulSoup(urlopen(url).read()) #read in


""" Print all table lines """
#table = text_soup.findAll('td')
#for line in table:
#    print line


""" Find lines of interest """
players = text_soup.findAll('td', {'class':'player'})
positions = text_soup.findAll('td', {'class':'position'})
changes = text_soup.findAll('td', {'class':'change'})

#print changes

""" Check length of lines """
print "Found " + str(len(players)) + " players"
print "Found " + str(len(positions)) + " positions"
if len(positions) != len(players):
    print "Error: List lengths"
    sys.exit(0)


""" Remove double changes """
i = 1
while(i < len(players)+1):
    del changes[i]
    i += 1
for change in changes:
    print change
print "Found " + str(len(changes)) + " changes"
if len(positions) != len(changes):
    print "Error: List lengths"
    sys.exit(0)



""" Output the data of interest """
for i in range(len(players)):
    positions[i] = float(BeautifulSoup(str(positions[i])).text)
    players[i] = str(BeautifulSoup(str(players[i])).text)
    changes[i] = str(BeautifulSoup(str(changes[i])).text)
    if(len(changes[i])):
        if '+' == changes[i][1]:
            changes[i] = int(str(BeautifulSoup(str(changes[i][1:])).text))
        else:
            changes[i] = -int(str(BeautifulSoup(str(changes[i][1:])).text))
    else:
        changes[i] = 0

    print str(positions[i]) + "\t" + str(changes[i]) + "\t" + str(players[i])







""" The matches """

url = 'http://www.snooker.org/res/index.asp?template=24'
text_soup = BeautifulSoup(urlopen(url).read()) #read in


""" Print all table lines """
#table = text_soup.findAll('td')
#for line in table:
#    print line


""" Find lines of interest """
players = text_soup.findAll('td', {'class':'player '})

#print changes

""" Check length of lines """
print "Found " + str(len(players)) + " players"


""" Output the data of interest """
i = 0
while i < len(players):
    one = str(BeautifulSoup(str(players[i])).text)
    i += 1
    two = str(BeautifulSoup(str(players[i])).text)
    i += 1
    print one + "\t\tV\t\t" + two

