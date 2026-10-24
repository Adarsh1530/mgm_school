const https = require('https');
const fs = require('fs');
const path = require('path');

const themepureUrls = [
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/iconservice-1.png',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/iconservice-2.png',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/iconservice-3.png',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/iconservice-4.png',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/testimonial-shape-1.png'
];

function download(url) {
  return new Promise((resolve, reject) => {
    const filename = path.basename(new URL(url).pathname);
    const dest = path.join(__dirname, '..', 'assets', 'images', filename);
    const file = fs.createWriteStream(dest);

    https.get(url, { headers: { 'User-Agent': 'Mozilla/5.0' } }, (res) => {
      if (res.statusCode !== 200) {
        console.error(`Failed ${filename}: status ${res.statusCode}`);
        resolve(false);
        return;
      }
      res.pipe(file);
      file.on('finish', () => {
        file.close(() => {
          console.log(`Saved ${filename} (${fs.statSync(dest).size} bytes)`);
          resolve(true);
        });
      });
    }).on('error', (err) => {
      console.error(`Error ${filename}:`, err.message);
      resolve(false);
    });
  });
}

async function run() {
  for (const u of themepureUrls) {
    await download(u);
  }
}

run();
