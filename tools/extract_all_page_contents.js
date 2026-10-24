const fs = require('fs');
const path = require('path');

const slugs = [
  'mandatory-disclosure', 'yoga', 'voice-of-mgm', 'hindustan-scouts-guides',
  'swimming-pool', 'ncc', 'attendance', 'admission-procedure',
  'alumni', 'merit-day', 'pta', 'courses-offered',
  'our-founder', 'gallery', 'our-mission', 'about-us'
];

const cleaned = {};

for (const slug of slugs) {
  const apiPath = path.join('audit', 'raw_pages', `${slug}_api.json`);
  const api = JSON.parse(fs.readFileSync(apiPath, 'utf8'));
  const html = api.content ? api.content.rendered : '';

  // Extract all image links from HTML
  const images = [];
  const imgRegex = /<img[^>]+src=["']([^"']+)["'][^>]*>/gi;
  let im;
  while ((im = imgRegex.exec(html)) !== null) {
    const fullTag = im[0];
    const src = im[1];
    const altMatch = fullTag.match(/alt=["']([^"']*)["']/i);
    images.push({ src, alt: altMatch ? altMatch[1] : '' });
  }

  // Also check gallery items if any
  const galleryRegex = /<a[^>]+class=["'][^"']*elementor-gallery-item[^"']*["'][^>]+href=["']([^"']+)["']/gi;
  let gm;
  while ((gm = galleryRegex.exec(html)) !== null) {
    images.push({ src: gm[1], alt: 'Gallery Image' });
  }

  // Extract all pdf links
  const pdfs = [];
  const pdfRegex = /<a[^>]+href=["']([^"']+\.pdf)["'][^>]*>([\s\S]*?)<\/a>/gi;
  let pm;
  while ((pm = pdfRegex.exec(html)) !== null) {
    pdfs.push({
      url: pm[1],
      title: pm[2].replace(/<[^>]+>/g, '').trim()
    });
  }

  cleaned[slug] = {
    id: api.id,
    title: api.title.rendered,
    slug: api.slug,
    rawHtml: html,
    images,
    pdfs
  };
}

fs.writeFileSync('audit/all_pages_clean.json', JSON.stringify(cleaned, null, 2));
console.log('Saved audit/all_pages_clean.json');
