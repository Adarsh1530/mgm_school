const fs = require('fs');
const home = fs.readFileSync('views/home.php', 'utf8');
const lines = home.split('\n');
lines.forEach((l, i) => {
  if (l.includes('Explore Our Courses') || l.includes('ab0c2f') || l.includes('hero') || l.includes('scroll') || l.includes('ticker') || l.includes('marquee')) {
    console.log((i + 1) + ': ' + l.trim().substring(0, 100));
  }
});
