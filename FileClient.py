import socket               # Import socket module

s = socket.socket()         # Create a socket object
#host = socket.gethostname() # Get local machine name
#port = 12345                 # Reserve a port for your service.

host, port = "localhost", 8888

s.connect((host, port))

print("Pilih file yang ingin dikirim! \n")
print("1. List Nama.txt \n")
print("2. List NIM.txt \n")
a = raw_input("Pilihan : ")

if a in ["1"]:
	s.send("Hello server! \r\n ")
	f = open('Nama.txt','rb')
	print 'Sending...'
	l = f.read(1024)
	while (l):
		print 'Sending...'
		s.send(l)
		l = f.read(1024)
	f.close()
	print "Done Sending"
	print s.recv(1024)
	
else:
	s.send("Hello server! \r\n ")
	f = open('NIM.txt','rb')
	print 'Sending...'
	l = f.read(1024)
	while (l):
		print 'Sending...'
		s.send(l)
		l = f.read(1024)
	f.close()
	print "Done Sending"
	print s.recv(1024)
	
s.close                     # Close the socket when done
