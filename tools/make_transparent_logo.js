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
  
  const imgBuffer = fs.readFileSync('assets/images/new-mgm-logo.jpeg');
  const base64Img = `data:image/jpeg;base64,${imgBuffer.toString('base64')}`;
  
  await page.setContent(`
    <canvas id="c" width="200" height="200"></canvas>
    <img id="img" src="${base64Img}" />
  `);
  
  const pngDataUrl = await page.evaluate(async () => {
    const img = document.getElementById('img');
    await img.decode();
    const canvas = document.getElementById('c');
    const ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);
    const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const data = imgData.data;
    
    // Check background color at corners
    // [247, 247, 247]
    const bgR = 247, bgG = 247, bgB = 247;
    
    for (let i = 0; i < data.length; i += 4) {
      const r = data[i], g = data[i+1], b = data[i+2];
      const diff = Math.sqrt((r - bgR)**2 + (g - bgG)**2 + (b - bgB)**2);
      if (diff < 18) {
        data[i+3] = 0; // Transparent
      } else if (diff < 35) {
        const alpha = (diff - 18) / (35 - 18);
        data[i+3] = Math.round(alpha * 255);
      }
    }
    ctx.putImageData(imgData, 0, 0);
    return canvas.toDataURL('image/png');
  });
  
  const base64Data = pngDataUrl.replace(/^data:image\/png;base64,/, "");
  fs.writeFileSync('assets/images/new-mgm-logo.png', base64Data, 'base64');
  console.log('Saved transparent assets/images/new-mgm-logo.png successfully!');
  await browser.close();
})();
