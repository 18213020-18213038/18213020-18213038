import org.jsoup.Jsoup;
import org.jsoup.helper.Validate;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import java.io.*;
import java.net.MalformedURLException;
import java.net.URL;

import java.io.IOException;

/**
 * Example program to list links from a URL.
 */
public class DldrLinks {
    public static void main(String[] args) throws IOException {
       // Validate.isTrue(args.length == 1, "usage: supply url to fetch");
        String url = "http://www.itb.ac.id";
        print("Fetching %s...", url);
		BufferedWriter writer = new BufferedWriter(new FileWriter("DownloadLink.txt"));
		String line;
        Document doc = Jsoup.connect(url).get();
        Elements links = doc.select("a[href]");
        Elements media = doc.select("[src]");
        Elements imports = doc.select("link[href]");

        print("\nMedia: (%d)", media.size());
        for (Element src : media) {
            if (src.tagName().equals("img"))
                print(" * %s: <%s> %sx%s (%s)",
                        src.tagName(), src.attr("abs:src"), src.attr("width"), src.attr("height"),
                        trim(src.attr("alt"), 20));
            else
                print(" * %s: <%s>", src.tagName(), src.attr("abs:src"));
        }

        print("\nImports: (%d)", imports.size());
        for (Element link : imports) {
            print(" * %s <%s> (%s)", link.tagName(),link.attr("abs:href"), link.attr("rel"));
        }

        print("\nLinks: (%d)", links.size());
        for (Element link : links) {
            print(" * a: <%s>  (%s)", line = link.attr("abs:href"), trim(link.text(), 35));
			//line = link.attr("abs:href");
			writer.write(line);
			writer.newLine();
        }
		writer.close();
		System.out.println("\n\n********** Fetching done! Now continue to download all Links **********\n\n");
		DownloadURL();
    }

	private static void DownloadURL(){
	try {
			BufferedReader br = new BufferedReader(new FileReader("Link.txt"));
 
			String line1;
			int fileNumber = 1;
			while ((line1 = br.readLine()) != null) {
				System.out.println("downloading " + line1 + "...");
				URL url = new URL(line1);
				System.out.println("1. Open the page");
				BufferedReader reader = new BufferedReader(new InputStreamReader(url.openStream()));
				System.out.println("2. Make a new html file");
				BufferedWriter writer = new BufferedWriter(new FileWriter(String.format("%d.html",fileNumber)));
				String line2;
				System.out.println("3. Copy the html page into the file");
				while ((line2 = reader.readLine()) != null) {
					writer.write(line2);
					writer.newLine();
				}
				System.out.println("done!");
				reader.close();
				writer.close();
				fileNumber++;
			}
			br.close();
			System.out.println(String.format("total: %d file downloaded",fileNumber-1));
		}
	catch (MalformedURLException e) {
		 e.printStackTrace();
	}
	catch (IOException e) {
		 e.printStackTrace();
	}
}
	
    private static void print(String msg, Object... args) {
        System.out.println(String.format(msg, args));
    }

    private static String trim(String s, int width) {
        if (s.length() > width)
            return s.substring(0, width-1) + ".";
        else
            return s;
            
            
    }
}
