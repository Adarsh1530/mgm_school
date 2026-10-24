const fs = require('fs');
const html = fs.readFileSync('tools/ranijai_news.html', 'utf8');

const noticeMatch = html.match(/<div class="top-notice-bar"[\s\S]*?<\/div>/);
if (noticeMatch) {
  console.log('--- NOTICE BAR ---');
  console.log(noticeMatch[0]);
}

const gridStart = html.indexOf('class="news-announcements-grid"');
if (gridStart !== -1) {
  console.log('--- NEWS GRID SAMPLE ---');
  console.log(html.substring(gridStart - 50, gridStart + 2500));
}
