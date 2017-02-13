import sys
from urllib import urlopen
from BeautifulSoup import BeautifulSoup
import re


def results(url):
    text_soup = BeautifulSoup(urlopen(url).read()) #read in
    timehtml = text_soup.findAll('td', {'class':'time'})
    players = text_soup.findAll('td', {'class':'player '})
    times = []
    for time in timehtml:
        times.append(str(BeautifulSoup(str(time)).text).replace("&nbsp;", ""))
    winners = []
    losers = []
    i = 0
    while(i < len(players)):
        winners.append(str(BeautifulSoup(str(players[i])).text))
        i += 1
        losers.append(str(BeautifulSoup(str(players[i])).text))
        i += 1
    return times,winners,losers



def getRank(find_player):
    url = 'http://www.snooker.org/res/index.asp?template=31&season=2016'
    text_soup = BeautifulSoup(urlopen(url).read()) #read in
    """ Find lines of interest """
    players = text_soup.findAll('td', {'class':'player'})
    positions = text_soup.findAll('td', {'class':'position'})
    changes = text_soup.findAll('td', {'class':'change'})
    """ Check length of lines """
    #print "Found " + str(len(players)) + " players"
    #print "Found " + str(len(positions)) + " positions"
    if len(positions) != len(players):
        #print "Error: List lengths"
        sys.exit(0)
    """ Remove double changes """
    i = 1
    while(i < len(players)+1):
        del changes[i]
        i += 1
    #for change in changes:
    #    print change
   # print "Found " + str(len(changes)) + " changes"
    if len(positions) != len(changes):
        #print "Error: List lengths"
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

        #print str(positions[i]) + "\t" + str(changes[i]) + "\t" + str(players[i])
    """ Find and return """
    for i in range(0,len(positions)):
        if players[i] in find_player:
            return players[i],positions[i],changes[i]

times,winners,losers = results("http://www.snooker.org/res/index.asp?template=22&season=2016")
#getRank("test")

for i in range(0,len(times)):
    try:
        win_rank = getRank(winners[i])
        lose_rank = getRank(losers[i])
        print str(times[i]),
        print ",",
        print str(win_rank[0]),
        print ",",
        print str(win_rank[1]),
        print ",",
        print str(lose_rank[0]),
        print ",",
        print str(lose_rank[1]),
        print "\n\r",
    except:
        pass
