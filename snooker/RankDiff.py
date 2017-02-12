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
matches = text_soup.findAll('td', {'class':'player '})

#print changes

""" Check length of lines """
print "Found " + str(len(matches)) + " matches"


""" Output the data of interest """
i = 0
while i < len(matches):
    one = str(BeautifulSoup(str(matches[i])).text)
    i += 1
    two = str(BeautifulSoup(str(matches[i])).text)
    i += 1

    for j in range(0,len(players)):
        if players[j] in one:
            one_position = positions[j],
            one_change = changes[j]
            one_player = players[j]
    for j in range(0,len(players)):
        if players[j] in two:
            two_position = positions[j],
            two_change = changes[j]
            two_player = players[j]
    print "---------- Match " + str(i/2) + " ----------"
    print "Difference:        " + str(abs(one_position[0] - two_position[0]))
    print "Player one:        " + str(one_player)
    print "Player one rank:   " + str(one_position[0])
    print "Player one change: " + str(one_change)
    print "Player two:        " + str(two_player)
    print "Player two rank:   " + str(two_position[0])
    print "Player two change: " + str(two_change)
    print "\n\n"

