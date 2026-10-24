const fs = require('fs');
const path = require('path');

const slugs = [
  'mandatory-disclosure', 'yoga', 'voice-of-mgm', 'hindustan-scouts-guides',
  'swimming-pool', 'ncc', 'attendance', 'admission-procedure',
  'alumni', 'merit-day', 'pta', 'courses-offered',
  'our-founder', 'gallery', 'our-mission', 'about-us'
];

const results = {};

for (const slug of slugs) {
  const apiPath = path.join('audit', 'raw_pages', `${slug}_api.json`);
  const api = JSON.parse(fs.readFileSync(apiPath, 'utf8'));
  const html = (api.content && api.content.rendered) || '';

  // Extract headings
  const headings = [];
  const hRegex = /<h([1-6])[^>]*>([\s\S]*?)<\/h\1>/gi;
  let hm;
  while ((hm = hRegex.exec(html)) !== null) {
    headings.push({ level: hm[1], text: hm[2].replace(/<[^>]+>/g, '').trim() });
  }

  // Extract paragraphs
  const paragraphs = [];
  const pRegex = /<p[^>]*>([\s\S]*?)<\/p>/gi;
  let pm;
  while ((pm = pRegex.exec(html)) !== null) {
    const text = pm[1].replace(/<[^>]+>/g, '').trim();
    if (text) paragraphs.push(text);
  }

  // Extract images
  const images = [];
  const imgRegex = /<img[^>]+src=["']([^"']+)["'][^>]*>/gi;
  let im;
  while ((im = imgRegex.exec(html)) !== null) {
    const fullTag = im[0];
    const src = im[1];
    const altMatch = fullTag.match(/alt=["']([^"']*)["']/i);
    images.push({
      src,
      alt: altMatch ? altMatch[1] : ''
    });
  }

  // Extract links
  const links = [];
  const aRegex = /<a[^>]+href=["']([^"']+)["'][^>]*>([\s\S]*?)<\/a>/gi;
  let am;
  while ((am = aRegex.exec(html)) !== null) {
    links.push({
      href: am[1],
      text: am[2].replace(/<[^>]+>/g, '').trim()
    });
  }

  // Check tables
  const tableRegex = /<table[\s\S]*?<\/table>/gi;
  const tables = html.match(tableRegex) || [];

  results[slug] = {
    title: api.title.rendered,
    headings,
    paragraphs,
    images,
    links,
    tablesCount: tables.length,
    tables
  };
}

fs.writeFileSync('audit/full_page_specs.json', JSON.stringify(results, null, 2));
console.log('Saved audit/full_page_specs.json');
