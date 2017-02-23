import sys
import os
import xml.dom.minidom
import csv
from time import gmtime, strftime
import xml.etree.ElementTree as ET
from xml.dom import minidom
import lxml.etree as etree


def main(rank_file, match_file, predict_xml):
    """ Main """

    """ Handle file """
    if not os.path.isfile(predict_xml):
        p = open(predict_xml, 'w')
        p.write("<data></data>")
        p.close()

    """ Load the data """
    with open(rank_file) as f:
        ranks = f.readlines()
    with open(match_file) as f:
        matches = f.readlines()

    print ranks
    print matches

    for i in range(1, len(matches)):

        print matches[i]

        """ Draw on data from rank and upcoming match """#
        doc = ET.parse(predict_xml)
        root_node = doc.getroot()
        m = ET.SubElement(doc.getroot(), "match")

        stamp = ET.SubElement(m, "stamp")
        stamp.text = strftime("%y%d%m")

        name_a = ET.SubElement(m, "name_a")
        name_a.text = matches[i].split(",")[1].replace("\n","")

        for j in range(1, len(ranks)):
            if name_a.text == ranks[j].split(",")[3].replace("\n",""):
                rank_a = ET.SubElement(m, "rank_a")
                rank_a.text = ranks[j].split(",")[0].replace("\n","")

                change_a = ET.SubElement(m, "chnage_a")
                change_a.text = ranks[j].split(",")[1].replace("\n","")

                seed_a = ET.SubElement(m, "seed_a")
                seed_a.text = ranks[j].split(",")[2].replace("\n","")


        name_b = ET.SubElement(m, "name_b")
        name_b.text = matches[i].split(",")[2].replace("\n","")


        for j in range(1, len(ranks)):
            if name_b.text == ranks[j].split(",")[3].replace("\n",""):
                rank_b = ET.SubElement(m, "rank_b")
                rank_b.text = ranks[j].split(",")[0].replace("\n","")

                change_b = ET.SubElement(m, "chnage_b")
                change_b.text = ranks[j].split(",")[1].replace("\n","")

                seed_b = ET.SubElement(m, "seed_b")
                seed_b.text = ranks[j].split(",")[2].replace("\n","")


        predict = ET.SubElement(m, "predict")
        predict.text = "a"

        outcome = ET.SubElement(m, "outcome")
        outcome.text = "?"


        tree = ET.ElementTree(root_node)
        tree.write(predict_xml)

if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2], sys.argv[3])
