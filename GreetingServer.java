import java.io.*;
import java.net.*;
import java.util.Scanner;

class GreetingServer{
	private static GreetingServer server;
	static int Port = 3535;
	static ServerSocket Socket;
	
	public GreetingServer(){
		try{
			Socket = new ServerSocket(setSocket());
		}catch(Exception e){
			System.out.println("Error: "+e.getMessage());
		}
	}
	
	private int setSocket(){
		Scanner in = new Scanner(System.in);
		System.out.print("Enter socket number:");
		Port = in.nextInt();
		System.out.println("Socket number "+Port+" created.");
		System.out.println("Listening...");
		return Port;
	}
	
	public static void main(String argv[]) throws Exception {
		server = new GreetingServer();
		String clientSentence;          
		String capitalizedSentence;          
		while(true){             
			Socket connectionSocket = Socket.accept();             
			BufferedReader inFromClient = new BufferedReader(new InputStreamReader(connectionSocket.getInputStream()));
			DataOutputStream outToClient = new DataOutputStream(connectionSocket.getOutputStream());             
			clientSentence = inFromClient.readLine();             
			System.out.println("Received: " + clientSentence);             
			capitalizedSentence = clientSentence.toUpperCase() + " from "+Port+'\n';             
			outToClient.writeBytes(capitalizedSentence);         
		}       
	}
}
