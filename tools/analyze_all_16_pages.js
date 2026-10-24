const fs = require('fs');
const path = require('path');

const slugs = [
  'mandatory-disclosure', 'yoga', 'voice-of-mgm', 'hindustan-scouts-guides',
  'swimming-pool', 'ncc', 'attendance', 'admission-procedure',
  'alumni', 'merit-day', 'pta', 'courses-offered',
  'our-founder', 'gallery', 'our-mission', 'about-us'
];

const analysis = [];
const allMediaUrls = new Set();
const allDocUrls = new Set();

for (const slug of slugs) {
  const apiPath = path.join('audit', 'raw_pages', `${slug}_api.json`);
  const detPath = path.join('audit', 'raw_pages', `${slug}_details.json`);

  let api = {};
  let det = {};
  if (fs.existsSync(apiPath)) {
    try { api = JSON.parse(fs.readFileSync(apiPath, 'utf8')); } catch(e){}
  }
  if (fs.existsSync(detPath)) {
    try { det = JSON.parse(fs.readFileSync(detPath, 'utf8')); } catch(e){}
  }

  const title = (api.title && api.title.rendered) || det.title || slug;
  const content = (api.content && api.content.rendered) || '';

  // Extract images from content
  const imgMatches = content.match(/https?:\/\/[^\s"'<>]+\.(?:png|jpe?g|webp|gif|svg)/gi) || [];
  imgMatches.forEach(url => allMediaUrls.add(url));

  // Extract docs/PDFs from content
  const docMatches = content.match(/https?:\/\/[^\s"'<>]+\.(?:pdf|docx?|xlsx?)/gi) || [];
  docMatches.forEach(url => allDocUrls.add(url));

  // Extract text content cleanly (stripping HTML tags)
  const plainText = content.replace(/<style[\s\S]*?<\/style>/gi, '')
                           .replace(/<script[\s\S]*?<\/script>/gi, '')
                           .replace(/<[^>]+>/g, ' ')
                           .replace(/\s+/g, ' ')
                           .trim();

  analysis.push({
    slug,
    title,
    h1: det.h1 || '',
    breadcrumb: det.breadcrumb || '',
    bannerBg: det.bannerBg || '',
    tables: det.tables || [],
    imagesFound: imgMatches.length,
    sampleImages: imgMatches.slice(0, 5),
    docsFound: docMatches.length,
    docs: docMatches,
    textLength: plainText.length,
    textPreview: plainText.substring(0, 300)
  });
}

fs.writeFileSync('audit/page_analysis.json', JSON.stringify(analysis, null, 2));
fs.writeFileSync('audit/media_urls.json', JSON.stringify(Array.from(allMediaUrls), null, 2));
fs.writeFileSync('audit/doc_urls.json', JSON.stringify(Array.from(allDocUrls), null, 2));

console.log('Page analysis completed!');
console.log(`Total unique media URLs: ${allMediaUrls.size}`);
console.log(`Total unique doc URLs: ${allDocUrls.size}`);
console.log('\nPage Overview:');
analysis.forEach(p => {
  console.log(`- ${p.slug}: "${p.title}" | Tables: ${p.tables.length} | Images: ${p.imagesFound} | Docs: ${p.docsFound} | Text: ${p.textLength} chars`);
});
