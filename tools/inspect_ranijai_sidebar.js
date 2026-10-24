const fs = require('fs');
const html = fs.readFileSync('tools/ranijai_news.html', 'utf8');

const sidebarStart = html.indexOf('Official Circulars');
if (sidebarStart !== -1) {
  console.log('--- SIDEBAR CIRCULARS SAMPLE ---');
  console.log(html.substring(sidebarStart - 100, sidebarStart + 1500));
} else {
  const announcementsStart = html.indexOf('announcement');
  if (announcementsStart !== -1) {
    console.log('--- ANNOUNCEMENTS SAMPLE ---');
    console.log(html.substring(announcementsStart - 50, announcementsStart + 1000));
  }
}

// Check CSS
const cssMatch = html.match(/<style[\s\S]*?<\/style>/g);
if (cssMatch) {
  console.log('Style tags count:', cssMatch.length);
  cssMatch.forEach((s, i) => console.log(`Style ${i}: ${s.substring(0, 300)}...`));
}
