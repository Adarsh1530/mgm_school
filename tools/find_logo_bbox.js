const puppeteer = require('puppeteer-core');
const fs = require('fs');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  
  // Load original jpeg and check pixel bounding box
  const imgBuffer = fs.readFileSync('assets/images/new-mgm-logo.jpeg');
  const base64Img = `data:image/jpeg;base64,${imgBuffer.toString('base64')}`;
  
  await page.setContent(`
    <canvas id="c" width="200" height="200"></canvas>
    <img id="img" src="${base64Img}" />
  `);
  
  const bbox = await page.evaluate(async () => {
    const img = document.getElementById('img');
    await img.decode();
    const canvas = document.getElementById('c');
    const ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);
    const data = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
    
    let minX = 200, maxX = 0, minY = 200, maxY = 0;
    
    // Background color is [247, 247, 247]
    for (let y = 0; y < 200; y++) {
      for (let x = 0; x < 200; x++) {
        const i = (y * 200 + x) * 4;
        const r = data[i], g = data[i+1], b = data[i+2];
        const diff = Math.sqrt((r - 247)**2 + (g - 247)**2 + (b - 247)**2);
        if (diff > 25) { // Non-background pixel
          if (x < minX) minX = x;
          if (x > maxX) maxX = x;
          if (y < minY) minY = y;
          if (y > maxY) maxY = y;
        }
      }
    }
    
    return { minX, maxX, minY, maxY, width: maxX - minX + 1, height: maxY - minY + 1 };
  });
  
  console.log('Actual emblem bounding box in original 200x200 image:', bbox);
  await browser.close();
})();
