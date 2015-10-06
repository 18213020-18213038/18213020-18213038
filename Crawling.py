import re, urllib

textfile = file('crawled.txt','wt')
print "Enter the URL you wish to crawl!"
print 'How to use:  - "http://abc.com/" <-- With the double quotes'
myurl = input("@> ") #user enters the beginning url
for i in re.findall('''href=["'](.[^"']+)["']''', urllib.urlopen(myurl).read(), re.I):
    print i #crawler goes in, and goes through the source code, gethering all URL's inside
        #for ee in re.findall('''href=["'](.[^"']+)["']''', urllib.urlopen(i).read(), re.I):
        #    print ee
    textfile.write(i+'\n')
textfile.close()

