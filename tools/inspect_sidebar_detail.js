const fs = require('fs');
const html = fs.readFileSync('tools/ranijai_news.html', 'utf8');

const start = html.indexOf('Active Announcements Sidebar');
const end = html.indexOf('Site Footer');
console.log(html.substring(start, end));
