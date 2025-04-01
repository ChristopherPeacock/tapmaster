import FirecrawlApp from "@mendable/firecrawl-js";


export default async function test() {
    
    const app = new FirecrawlApp({
        apiUrl: "http://192.168.10.205:3002",
    
    });
    
    console.log('trying second fucntion')
    
    const  scrapeResponse = await app.scrapeUrl("https://www.trypetals.com/", {
        formats: ['markdown']
    
    });
    console.log('scrape response')
    console.log(scrapeResponse);
}


test();
