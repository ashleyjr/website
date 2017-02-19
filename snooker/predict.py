import sys
import os
import csv
from time import gmtime, strftime


def main(rank_file, match_file, predict_file):
    """ Main """

    """ Handle file """
    if os.path.isfile(predict_file):
        p = open(predict_file, 'w')
        p.write("Date,Time,RankA,ChangeA,SeedA,PlayerA,RankB,ChangeB,SeedB,PlayerB,Prediction,Outcome\n")
        p.close()


    """ Draw on data from rank and upcoming match """
    p = open(predict_file, 'a+')
    match = csv.reader(open(match_file))
    for m in match:
        found_a = []
        found_b = []
        rank = csv.reader(open(rank_file))
        for r in rank:
            if m[1] == r[3]:
                found_a = r
            if m[2] == r[3]:
                found_b = r
        if len(found_a):
            if len(found_b):
                p.write(str(strftime("%Y-%m-%d", gmtime())))
                p.write(",")
                p.write(m[0])
                p.write(",")
                p.write(found_a[0])
                p.write(",")
                p.write(found_a[1])
                p.write(",")
                p.write(found_a[2])
                p.write(",")
                p.write(found_a[3])
                p.write(",")
                p.write(found_b[0])
                p.write(",")
                p.write(found_b[1])
                p.write(",")
                p.write(found_b[2])
                p.write(",")
                p.write(found_b[3])
                p.write(",")
                p.write("A")
                p.write(",")
                p.write("")
                p.write("\n")



if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2], sys.argv[3])