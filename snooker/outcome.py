import sys
import os
from urllib import urlopen
from BeautifulSoup import BeautifulSoup
import numpy as np


def main(url, csv_file):
    """ Main """

    print "\nGet outcome of previous matches\n"

    """ Remove old file if exists """
    try:
        os.remove(csv_file)
    except OSError:
        pass

    """ Create new file """
    f = open(csv_file, 'w+')
    f.write("Winner,\t\t\t\tLoser\n")

    """ Read in the table """
    text_soup = BeautifulSoup(urlopen(url).read())  # read in
    player = text_soup.findAll('td', {'class': 'player '})

    """ Process """
    i = 0
    while i < len(player):
        f.write(str(BeautifulSoup(str(player[i])).text).split('[')[0] + ",\t\t\t")
        i += 1
        f.write(str(BeautifulSoup(str(player[i])).text).split('[')[0] + "\n")
        i += 1

    """"""

if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2])
