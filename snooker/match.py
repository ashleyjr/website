import sys
import os
from urllib import urlopen
from BeautifulSoup import BeautifulSoup
import numpy as np


def main(url, csv_file):
    """ Main """

    print "Get upcoming  matches\n"

    """ Remove old file if exists """
    try:
        os.remove(csv_file)
    except OSError:
        pass

    """ Create new file """
    f = open(csv_file, 'w+')
    f.write("Timestamp,Player A,Player B\n")

    """ Read in the table """
    page = urlopen(url).read()
    text_soup = BeautifulSoup(page)          # read in
    player = text_soup.findAll('td', {'class': 'player '})
    datetime = text_soup.findAll('td', {'class': 'scheduled editcell'})

    """ Process the text to get the players and times today"""
    found = 0
    d_ptr = 0
    p_ptr = 0
    while d_ptr < len(datetime):
        good = False
        stamp = str(BeautifulSoup(str(datetime[d_ptr])).text)
        d_ptr += 1

        """ Get the date and time """
        ests = stamp.split(" ")
        stamps = stamp.split("&nbsp;")
        if ests[0] != "Est.":
            if len(stamps) > 2:
                f.write(stamps[0] + " " + stamps[1] + " " + stamps[2] + ",")
                found += 1
                good = True

        """ Player names """
        if good:
            f.write(str(BeautifulSoup(str(player[p_ptr])).text.split('[')[0]) + ",")
        p_ptr += 1
        if good:
            f.write(str(BeautifulSoup(str(player[p_ptr])).text.split('[')[0]) + "\n")
        p_ptr += 1

    """ Print details """
    print "MATCHES: " + str(found) + " matches found"

if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2])
