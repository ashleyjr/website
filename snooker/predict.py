import sys
import os
from urllib import urlopen
from BeautifulSoup import BeautifulSoup
import numpy as np


def main(rank_file, match_file, predict_file):
    """ Main """

    rank = np.genfromtxt(
        rank_file,                                          # file name
        skip_header=1,                                      # lines to skip at the top
        skip_footer=0,                                      # lines to skip at the bottom
        delimiter=',',                                      # column delimiter
        dtype='int',                                        # data type
        filling_values=0,                                   # fill missing values with 0
        usecols=(0, 1, 2, 3),                               # columns to read
        names=['Rank', 'Change', 'Seed', 'Name']            # column names
    )

    match = np.genfromtxt(
        match_file,                                         # file name
        skip_header=1,                                      # lines to skip at the top
        skip_footer=0,                                      # lines to skip at the bottom
        delimiter=',',                                      # column delimiter
        dtype='int',                                        # data type
        filling_values=0,                                   # fill missing values with 0
        usecols=(0, 1, 2),                                  # columns to read
        names=['Time', 'A', 'B']                            # column names
    )

    print rank
    print match



if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2], sys.argv[3])