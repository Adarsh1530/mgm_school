const fs = require('fs');
const html = fs.readFileSync('tools/ranijai_news.html', 'utf8');

const parts = html.split('<!-- News Stories -->');
if (parts.length > 1) {
  const afterStories = parts[1].split('<!--');
  afterStories.forEach((part, i) => {
    console.log(`Part ${i}: ${part.substring(0, 300)}`);
  });
}
