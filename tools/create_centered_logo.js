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
    <canvas id="c"></canvas>
    <img id="img" src="${base64Img}" />
  `);
  
  // Crop tightly to emblem
  const croppedDataUrl = await page.evaluate(async () => {
    const img = document.getElementById('img');
    await img.decode();
    
    // Find precise bounding box of non-background pixels
    const tempCanvas = document.createElement('canvas');
    tempCanvas.width = img.naturalWidth;
    tempCanvas.height = img.naturalHeight;
    const tempCtx = tempCanvas.getContext('2d');
    tempCtx.drawImage(img, 0, 0);
    const data = tempCtx.getImageData(0, 0, tempCanvas.width, tempCanvas.height).data;
    
    let minX = img.naturalWidth, maxX = 0, minY = img.naturalHeight, maxY = 0;
    for (let y = 0; y < img.naturalHeight; y++) {
      for (let x = 0; x < img.naturalWidth; x++) {
        const i = (y * img.naturalWidth + x) * 4;
        const r = data[i], g = data[i+1], b = data[i+2];
        const diff = Math.sqrt((r - 247)**2 + (g - 247)**2 + (b - 247)**2);
        if (diff > 22) {
          if (x < minX) minX = x;
          if (x > maxX) maxX = x;
          if (y < minY) minY = y;
          if (y > maxY) maxY = y;
        }
      }
    }
    
    // Create tight canvas with padding
    const pad = 4;
    const cropW = maxX - minX + 1;
    const cropH = maxY - minY + 1;
    
    // Make a square canvas centered
    const size = Math.max(cropW, cropH) + (pad * 2);
    const canvas = document.getElementById('c');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');
    
    // Draw transparent
    const offsetX = Math.round((size - cropW) / 2);
    const offsetY = Math.round((size - cropH) / 2);
    
    // Draw cropped region
    ctx.drawImage(img, minX, minY, cropW, cropH, offsetX, offsetY, cropW, cropH);
    
    // Make background transparent
    const imgData = ctx.getImageData(0, 0, size, size);
    const d = imgData.data;
    for (let i = 0; i < d.length; i += 4) {
      const r = d[i], g = d[i+1], b = d[i+2];
      const diff = Math.sqrt((r - 247)**2 + (g - 247)**2 + (b - 247)**2);
      if (diff < 18) {
        d[i+3] = 0;
      } else if (diff < 35) {
        const alpha = (diff - 18) / (35 - 18);
        d[i+3] = Math.round(alpha * 255);
      }
    }
    ctx.putImageData(imgData, 0, 0);
    return {
      dataUrl: canvas.toDataURL('image/png'),
      bbox: { minX, maxX, minY, maxY, cropW, cropH, size }
    };
  });
  
  console.log('Cropped details:', croppedDataUrl.bbox);
  const base64Data = croppedDataUrl.dataUrl.replace(/^data:image\/png;base64,/, "");
  fs.writeFileSync('assets/images/new-mgm-logo-centered.png', base64Data, 'base64');
  console.log('Saved assets/images/new-mgm-logo-centered.png');
  await browser.close();
})();
