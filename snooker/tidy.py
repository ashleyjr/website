import sys
import os
import xml.dom.minidom

def main(filename):
    print filename
    xml_str = xml.dom.minidom.parse(filename) # or xml.dom.minidom.parseString(xml_string)
    text = xml_str.toprettyxml()
    os.remove(filename)
    f = open(filename, 'w+')
    f.write(text)
    f.close()

if __name__ == "__main__":
    main(sys.argv[1])

