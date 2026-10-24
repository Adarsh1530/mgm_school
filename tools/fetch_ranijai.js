const https = require('https');
const fs = require('fs');

https.get('https://www.ranijaihssnirmalagiri.org/news.php', (res) => {
  let data = '';
  res.on('data', chunk => data += chunk);
  res.on('end', () => {
    fs.writeFileSync('tools/ranijai_news.html', data);
    console.log('Saved to tools/ranijai_news.html, length:', data.length);
  });
}).on('error', err => console.error(err));
