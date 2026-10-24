const fs = require('fs');

let html = fs.readFileSync('audit/homepage_clean_extracted.html', 'utf8');
const originalLength = html.length;

console.log('Original extracted HTML length:', originalLength);

// 1. Remove video tour play button icon
const videoTourPattern = /<div class="tp-video-icon text-center">[\s\S]*?<p class="tp-el-v-title">Video Tour\s*<\/p>[\s\S]*?<\/div>/i;
if (videoTourPattern.test(html)) {
  html = html.replace(videoTourPattern, '<!-- Video tour play button icon removed -->');
  console.log('[1] Removed video tour play button icon');
} else {
  console.log('[1] Video tour pattern not matched directly, checking fallback...');
}

// 2. Banner "Apply Now" button
const bannerApplyPattern = /(<div class="elementor-element elementor-element-5b8def9[\s\S]*?<a\s+href=")#("[\s\S]*?Apply Now\s*<\/span>)/i;
if (bannerApplyPattern.test(html)) {
  html = html.replace(bannerApplyPattern, '$1admission-procedure/$2');
  console.log('[2] Updated Banner Apply Now button to admission-procedure/');
} else {
  console.log('[2] Banner Apply Now pattern not matched');
}

// 3. Hero buttons
html = html.replace('href="/admission-procedure/">\n                      Learn More About Our Campus', 'href="about-us/">\n                      Learn More About Our Campus');
html = html.replace('href="/courses-offered/">\n                      Explore Our Courses', 'href="courses-offered/">\n                      Explore Our Courses');
console.log('[3] Updated Hero buttons');

// 4. Card 1: Why study at MGM Model School
html = html.replace(
  '<h4 class="tp-service-title tp-el-title"><a href="#" target="_blank" rel="nofollow">Why study at MGM Model School</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="#" target="_blank" rel="nofollow">',
  '<h4 class="tp-service-title tp-el-title"><a href="about-us/">Why study at MGM Model School</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="about-us/">'
);
console.log('[4] Updated Card 1 Why study at MGM Model School');

// 5. Card 2: Certification Guarantee
html = html.replace(
  '<h4 class="tp-service-title tp-el-title"><a href="#" target="_blank" rel="nofollow">Certification  <br> Guarantee</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="#" target="_blank" rel="nofollow">',
  '<h4 class="tp-service-title tp-el-title"><a href="mandatory-disclosure/">Certification  <br> Guarantee</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="mandatory-disclosure/">'
);
console.log('[5] Updated Card 2 Certification Guarantee');

// 6. Card 3: Graduate Admissions
html = html.replace(
  '<h4 class="tp-service-title tp-el-title"><a href="#" target="_blank" rel="nofollow">Graduate  <br> Admissions</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="#" target="_blank" rel="nofollow">',
  '<h4 class="tp-service-title tp-el-title"><a href="admission-procedure/">Graduate  <br> Admissions</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="admission-procedure/">'
);
console.log('[6] Updated Card 3 Graduate Admissions');

// 7. Card 4: Scholarships & Fees
html = html.replace(
  '<h4 class="tp-service-title tp-el-title"><a href="#" target="_blank" rel="nofollow">Scholarships &amp;  <br> Fees</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="#" target="_blank" rel="nofollow">',
  '<h4 class="tp-service-title tp-el-title"><a href="courses-offered/">Scholarships &amp;  <br> Fees</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="courses-offered/">'
);
console.log('[7] Updated Card 4 Scholarships & Fees');

// 8. "Trusted by the worlds Best School"
const bestSchoolPattern = /(<div class="tp-btn-wrapper tp-program-all">\s*<a\s+href=")#("[\s\S]*?<span class="theme-btn-text">\s*Best School<\/span>)/i;
if (bestSchoolPattern.test(html)) {
  html = html.replace(bestSchoolPattern, '$1about-us/$2');
  console.log('[8] Updated Best School link to about-us/');
} else {
  console.log('[8] Best School link pattern not matched');
}

// 9. "Know More" button under Welcome section
const knowMorePattern = /(<div class="elementor-element elementor-element-c09a89c[\s\S]*?<a\s+href=")#("[\s\S]*?<span class="theme-btn-text">Know More<\/span>)/i;
if (knowMorePattern.test(html)) {
  html = html.replace(knowMorePattern, '$1about-us/$2');
  console.log('[9] Updated Know More button to about-us/');
} else {
  console.log('[9] Know More button pattern not matched directly, trying simpler replace');
  html = html.replace(
    /(<a\s+href=")#("\s+class="[^"]*"><span class="theme-btn-text">Know More<\/span>)/i,
    '$1about-us/$2'
  );
}

// 10. "Explore the most appropriate courses. View All ->"
const viewAllPattern = /(<div class="tp-btn-wrapper tp-program-all">\s*<a\s+href=")#("[\s\S]*?<span class="theme-btn-text">View All\s*<\/span>)/i;
if (viewAllPattern.test(html)) {
  html = html.replace(viewAllPattern, '$1courses-offered/$2');
  console.log('[10] Updated Courses View All link to courses-offered/');
} else {
  console.log('[10] View All link pattern not matched');
}

// 11. "See More Events ->"
const seeEventsPattern = /(<a\s+href=")#("[\s\S]*?<span class="theme-btn-text">See More Events<\/span>)/i;
if (seeEventsPattern.test(html)) {
  html = html.replace(seeEventsPattern, '$1merit-day/$2');
  console.log('[11] Updated See More Events button to merit-day/');
} else {
  console.log('[11] See More Events pattern not matched');
}

// 12. Event items (/etn/... links)
html = html.replaceAll('/etn/global-education-fall-meeting-for-everyone-2/', 'merit-day/');
html = html.replaceAll('/etn/acadia-global-in-education-fair/', 'merit-day/');
html = html.replaceAll('/etn/students-success-of-workshop/', 'merit-day/');
console.log('[12] Replaced all /etn/ links with merit-day/');

// Also fix any empty or '#' links inside the event cards
const eventsSectionStart = html.indexOf('Recent & Upcoming');
if (eventsSectionStart !== -1) {
  const eventsSectionEnd = html.indexOf('tp-footer-area', eventsSectionStart);
  let eventsBlock = html.substring(eventsSectionStart, eventsSectionEnd !== -1 ? eventsSectionEnd : eventsSectionStart + 6000);
  
  // Replace <a href="#" with <a href="merit-day/" inside the events block
  const updatedEventsBlock = eventsBlock.replaceAll('href="#"', 'href="merit-day/"').replaceAll('href=""', 'href="merit-day/"');
  html = html.substring(0, eventsSectionStart) + updatedEventsBlock + html.substring(eventsSectionStart + eventsBlock.length);
  console.log('[13] Replaced remaining dead links inside Events section');
}

fs.writeFileSync('audit/homepage_clean_extracted.html', html, 'utf8');
console.log('Saved updated audit/homepage_clean_extracted.html successfully!');
