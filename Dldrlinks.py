import urllib2
import sys

url = urllib2.urlopen("http://labdasar.ee.itb.ac.id/index-4.html")
page = url.readlines()

try:
    with open("Links.txt", "w") as file_out:
        for line in page:
            file_out.write(line+"\n")
except IOError as e:
    print "couldn't write to file"
    #sys.exit(1)
