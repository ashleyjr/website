import sys
import os
from urllib import urlopen
from BeautifulSoup import BeautifulSoup
import numpy as np


def main(url, csv_file):
    """ Main """

    print "Get today's matches\n"

    """ Remove old file if exists """
    try:
        os.remove(csv_file)
    except OSError:
        pass

    """ Create new file """
    f = open(csv_file, 'w+')
    f.write("Time,Player A,Player B\n")

    """ Read in the table """
    text_soup = BeautifulSoup(urlopen(url).read())          # read in
    player = text_soup.findAll('td', {'class': 'player '})
    datetime = text_soup.findAll('td', {'class': 'scheduled editcell'})

    """ Process the text to get the players and times today"""
    num_today = 0
    i = 0
    while i < len(datetime):
        today = False
        stamp = str(BeautifulSoup(str(datetime[i])).text)
        if "Today&nbsp;" == stamp[0:11]:
            t = stamp.split("&nbsp;")
            if 3 == len(t):
                f.write(str(t[1].split("m")[0]) + "m,")
                num_today += 1
                today = True
        if today:
            f.write(str(BeautifulSoup(str(player[i])).text.split('[')[0]) + ",")
        i += 1
        if today:
            f.write(str(BeautifulSoup(str(player[i])).text.split('[')[0]) + "\n")
        i += 1

    """ Print details """
    print "MATCHES: " + str(num_today) + " today"





if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2])
