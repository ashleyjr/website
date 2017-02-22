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

    """ Tidy up xml """
    f = open(predict_xml, 'w')
    f.write(minidom.parseString(ET.tostring(root_node, 'utf-8')).toprettyxml(indent="").replace("\n",""))
    f.close()

    x = etree.parse(predict_xml)
    f = open(predict_xml, 'w')
    f.write(etree.tostring(x, pretty_print = True))
    f.close()

if __name__ == "__main__":
    main(sys.argv[1], sys.argv[2], sys.argv[3])
