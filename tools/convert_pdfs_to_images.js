const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const pdfs = [
  { file: 'Rajyapuraskar-2019.pdf', out: 'rajyapuraskar-2019.jpg' },
  { file: 'Rajyapuraskar-2022.pdf', out: 'rajyapuraskar-2022.jpg' },
  { file: 'Rajyapuraskar-2023.pdf', out: 'rajyapuraskar-2023.jpg' },
  { file: 'Rajyapuraskar-2024.pdf', out: 'rajyapuraskar-2024.jpg' }
];

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox', '--window-size=1200,1600']
  });
  
  const page = await browser.newPage();
  await page.setViewport({ width: 1000, height: 1400 });

  for (const item of pdfs) {
    const url = `http://localhost/MGM%20SCHOOL/assets/docs/${item.file}`;
    console.log(`Loading PDF: ${url}`);
    await page.goto(url, { waitUntil: 'networkidle2' });
    await new Promise(r => setTimeout(r, 1500));
    
    const outPath = path.join(__dirname, '..', 'assets', 'images', item.out);
    await page.screenshot({ path: outPath, quality: 85 });
    console.log(`Saved: ${outPath} (${fs.statSync(outPath).size} bytes)`);
  }

  await browser.close();
  console.log('All 4 PDFs converted to images!');
})();
