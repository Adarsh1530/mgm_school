const https = require('https');
const fs = require('fs');
const path = require('path');

const libs = [
  {
    url: 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js',
    dest: path.join(__dirname, '..', 'assets', 'js', 'swiper-bundle.min.js')
  },
  {
    url: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
    dest: path.join(__dirname, '..', 'assets', 'js', 'bootstrap.bundle.min.js')
  }
];

function download(u, dest) {
  return new Promise((resolve) => {
    https.get(u, (res) => {
      if (res.statusCode === 301 || res.statusCode === 302) {
        return download(res.headers.location, dest).then(resolve);
      }
      const stream = fs.createWriteStream(dest);
      res.pipe(stream);
      stream.on('finish', () => {
        stream.close(() => {
          console.log(`Saved ${path.basename(dest)} (${fs.statSync(dest).size} bytes)`);
          resolve();
        });
      });
    });
  });
}

async function run() {
  for (const item of libs) {
    await download(item.url, item.dest);
  }
}

run();
