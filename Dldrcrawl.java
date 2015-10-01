package progif2;

/**
 *
 * @author acer
 */

import org.jsoup.Jsoup;
import org.jsoup.helper.Validate;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.IOException;
import static progif2.Crawling.tulisFile;

/**
 * Example program to list links from a URL.
 */
public class Dldrcrawl {
    
    public static void main(String[] args) throws IOException {
        //Validate.isTrue(args.length == 1, "http://www.itb.ac.id");
        String url = "http://www.itb.ac.id";
        print("Fetching %s...", url);

        Document doc = Jsoup.connect(url).get();
        //Elements links = doc.select("a[href]");
        Elements links = doc.getElementsByTag("a");
        Elements media = doc.select("[src]");
        Elements imports = doc.select("link[href]");
        //String namafile = "listlink.txt";

        print("\nMedia: (%d)", media.size());
        for (Element src : media) {
            if (src.tagName().equals("img"))
                print(" * %s: <%s> %sx%s (%s)",
                        src.tagName(), src.attr("abs:src"), src.attr("width"), src.attr("height"),
                        trim(src.attr("alt"), 20));
                        //tulisFile(line,namaFile);
            else
                print(" * %s: <%s>", src.tagName(), src.attr("abs:src"));
        }

        print("\nImports: (%d)", imports.size());
        for (Element link : imports) {
            print(" * %s <%s> (%s)", link.tagName(),link.attr("abs:href"), link.attr("rel"));
        }

        print("\nLinks: (%d)", links.size());
        for (Element link : links) {
            print(" * a: <%s>  (%s)", link.attr("abs:href"), trim(link.text(), 35));
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
