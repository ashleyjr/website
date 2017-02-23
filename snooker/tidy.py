import sys
import os
import xml.dom.minidom

def main(filename):
    print filename
    f = open(filename, 'r')
    data = f.read()
    f.close()
    data = data.replace("\n","")
    data = data.replace("\t","")
    os.remove(filename)
    f = open(filename, 'w+')
    f.write(data)
    f.close()
    xml_str = xml.dom.minidom.parse(filename) # or xml.dom.minidom.parseString(xml_string)
    text = xml_str.toprettyxml()
    os.remove(filename)
    f = open(filename, 'w+')
    f.write(text)
    f.close()

if __name__ == "__main__":
    main(sys.argv[1])

