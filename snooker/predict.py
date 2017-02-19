import sys
import os
import xml.dom.minidom
import csv
from time import gmtime, strftime
import xml.etree.ElementTree as ET
from xml.dom import minidom


def xml_format(f):
    rough_string = ET.tostring(f, 'utf-8')
    reparsed = minidom.parseString(rough_string)
    return minidom.parseString(rough_string).toprettyxml(indent="\t")

def main(rank_file, match_file, predict_xml):
    """ Main """

    """ Handle file """
    if not os.path.isfile(predict_xml):
        p = open(predict_xml, 'w')
        p.write("<data>\n</data>\n")
        p.close()


    """ Draw on data from rank and upcoming match """#

    doc = ET.parse(predict_xml)
    root_node = doc.getroot()
    m = ET.SubElement(doc.getroot(), "match")
    d = ET.SubElement(m, "date")
    d.text = "today"
    t = ET.SubElement(m, "time")
    t.text = "now"
    tree = ET.ElementTree(root_node)
    tree.write(predict_xml)

    f = open(predict_xml, 'w')
    f.write(minidom.parseString(ET.tostring(root_node, 'utf-8')).toprettyxml(indent="\t"))
    f.close()



    # p = open(predict_f, 'a+')
    # match = csv.reader(open(match_file))
    # for m in match:
    #     found_a = []
    #     found_b = []
    #     rank = csv.reader(open(rank_file))
    #     for r in rank:
    #         if m[1] == r[3]:
    #             found_a = r
    #         if m[2] == r[3]:
    #             found_b = r
    #     if len(found_a):
    #         if len(found_b):
    #             p.write(str(strftime("%Y-%m-%d", gmtime())))
    #             p.write(",")
    #             p.write(m[0])
    #             p.write(",")
    #             p.write(found_a[0])
    #             p.write(",")
    #             p.write(found_a[1])
    #             p.write(",")
    #             p.write(found_a[2])
    #             p.write(",")
    #             p.write(found_a[3])
    #             p.write(",")
    #             p.write(found_b[0])
    #             p.write(",")
    #             p.write(found_b[1])
    #             p.write(",")
    #             p.write(found_b[2])
    #             p.write(",")
    #             p.write(found_b[3])
    #             p.write(",")
    #             p.write("A")
    #             p.write(",")
    #             p.write("")
    #             p.write("\n")



if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2], sys.argv[3])