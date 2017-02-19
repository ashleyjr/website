import sys
import os
from urllib import urlopen
from BeautifulSoup import BeautifulSoup
import numpy as np


def main(url, csv_file):
    """ Main """

    print "Get player rankings\n"

    """ Remove old file if exists """
    try:
        os.remove(csv_file)
    except OSError:
        pass

    """ Create new file """
    f = open(csv_file, 'w+')
    f.write("Rank,Change,Seed,Name\n")

    """ Read in table """
    text_soup = BeautifulSoup(urlopen(url).read())  # read in
    player = text_soup.findAll('td', {'class': 'player'})
    position = text_soup.findAll('td', {'class': 'position'})
    change = text_soup.findAll('td', {'class': 'change'})
    seeding = text_soup.findAll('td', {'class': 'seeding'})

    """ Remove repeated row for change """
    i = 1
    while i < len(change):
        del change[i]
        i += 1

    """ Confirm the lengths match"""
    length_mismatch = False
    if len(player) != len(position):
        length_mismatch = True
    if len(position) != len(change):
        length_mismatch = True
    if len(change) != len(seeding):
        length_mismatch = True
    if length_mismatch:
        print "ERROR: Length mismatch"
        sys.exit(1)

    """ Dig out data of interest """
    for i in range(len(player)):
        player[i] = str(BeautifulSoup(str(player[i])).text)
        position[i] = float(BeautifulSoup(str(position[i])).text)
        change[i] = str(BeautifulSoup(str(change[i])).text)
        if len(change[i]):
            if '+' == change[i][1]:
                change[i] = int(str(BeautifulSoup(str(change[i][1:])).text))
            else:
                change[i] = -int(str(BeautifulSoup(str(change[i][1:])).text))
        else:
            change[i] = 0
        seeding[i] = float(BeautifulSoup(str(seeding[i])).text)

    """ Write download to csv file """
    for i in range(len(player)):
        f.write(str(position[i]) + ",")
        f.write(str(change[i]) + ",")
        f.write(str(seeding[i]) + ",")
        f.write(str(player[i]) + "\n")
    f.close()

    """ Validate the csv file """
    data = np.genfromtxt(
        csv_file,                                   # file name
        skip_header=1,                              # lines to skip at the top
        skip_footer=0,                              # lines to skip at the bottom
        delimiter=',',                              # column delimiter
        dtype='int',                                # data type
        filling_values=0,                           # fill missing values with 0
        usecols=(0, 1, 2, 3),                       # columns to read
        names=['Rank', 'Change', 'Seed', 'Name']    # column names
    )
    print "ENTRIES: " + str(len(data['Rank']))
    for i in range(1, len(data['Rank'])):
        num = list(data['Rank']).count(i)
        if 0 == num:
            print "   RANK: no player ranked " + str(i)
        if 1 < num:
            print "   RANK: " + str(i) + " shared by " + str(num) + " players"

if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2])
