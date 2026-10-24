const fs = require('fs');

const admTableHtml = fs.readFileSync('audit/admission_table_rendered.html', 'utf8');
const crsTableHtml = fs.readFileSync('audit/courses_table_rendered.html', 'utf8');
const pages = JSON.parse(fs.readFileSync('audit/all_pages_clean.json', 'utf8'));

// Connect using mysql2 or write a SQL updater script
let updateSql = '';

function cleanHtml(html) {
  let h = html;
  // Replace remote PDF urls with local relative paths
  h = h.replace(/https?:\/\/mgm-school\.nbtksa.in\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/([^\s"'<>]+\.pdf)/gi, 'assets/docs/$1');
  // Replace remote image urls with local relative paths
  h = h.replace(/https?:\/\/mgm-school\.nbtksa.in\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/([^\s"'<>]+\.(?:jpg|jpeg|png|webp|gif|svg))/gi, 'assets/images/$1');
  h = h.replace(/https?:\/\/mgm-school\.nbtksa.in\/wp-content\/plugins\/[^\s"'<>]+\/([^\s"'<>]+\.(?:jpg|jpeg|png|webp|gif|svg))/gi, 'assets/images/$1');
  h = h.replace(/https?:\/\/mgm-school\.nbtksa.in/g, '');
  return h;
}

// 1. Admission Procedure
let admHtml = cleanHtml(pages['admission-procedure'].rawHtml);
// Replace empty table tag with rendered table
admHtml = admHtml.replace(/<table[\s\S]*?<\/table>/i, admTableHtml);
// Append admission enquiry form styled seamlessly within the elementor container
const formSnippet = `
<div class="elementor-element e-con-full e-flex e-con mt-4" style="max-width: 700px; margin: 40px auto 0 auto;">
  <div class="mgm-form-card" style="width: 100%;">
    <h3 class="fw-bold mb-2 text-dark" style="font-size: 22px;">Online Admission Enquiry</h3>
    <p class="text-muted small mb-4">Submit your details to request admission information and syllabus.</p>
    <form action="/admission-procedure/" method="POST">
      <input type="hidden" name="action" value="admission_enquiry">
      <div class="mgm-form-group">
        <label class="mgm-form-label">Student / Parent Name *</label>
        <input type="text" name="name" class="mgm-form-control" placeholder="Full Name" required>
      </div>
      <div class="mgm-form-group">
        <label class="mgm-form-label">Contact Phone Number *</label>
        <input type="tel" name="phone" class="mgm-form-control" placeholder="Mobile Number" required>
      </div>
      <div class="mgm-form-group">
        <label class="mgm-form-label">Email Address</label>
        <input type="email" name="email" class="mgm-form-control" placeholder="name@example.com">
      </div>
      <div class="mgm-form-group">
        <label class="mgm-form-label">Grade / Class Seeking Admission</label>
        <select name="grade_applied" class="mgm-form-control">
          <option value="">-- Select Grade --</option>
          <option value="Kids School">Kids School</option>
          <option value="LKG">LKG</option>
          <option value="UKG">UKG</option>
          <option value="Class I - V">Class I - V (Primary)</option>
          <option value="Class VI - VIII">Class VI - VIII (Middle)</option>
          <option value="Class IX - X">Class IX - X (Secondary)</option>
          <option value="Class XI - XII Science">Class XI - XII (Science)</option>
          <option value="Class XI - XII Commerce">Class XI - XII (Commerce)</option>
          <option value="Class XI - XII Humanities">Class XI - XII (Humanities)</option>
        </select>
      </div>
      <div class="mgm-form-group">
        <label class="mgm-form-label">Message / Queries</label>
        <textarea name="message" class="mgm-form-control" rows="3" placeholder="Any specific questions..."></textarea>
      </div>
      <button type="submit" class="tp-btn-primary w-100 py-3 mt-2">
        Submit Admission Enquiry
      </button>
    </form>
  </div>
</div>
`;
admHtml = admHtml.replace(/<\/div>\s*<\/div>\s*$/, formSnippet + '</div></div>');

// 2. Courses Offered
let crsHtml = cleanHtml(pages['courses-offered'].rawHtml);
crsHtml = crsHtml.replace(/<table[\s\S]*?<\/table>/i, crsTableHtml);

// 3. Alumni
let alumniHtml = cleanHtml(pages['alumni'].rawHtml);
const alumniFormSnippet = `
<div class="elementor-element e-con-full e-flex e-con mt-4" style="max-width: 700px; margin: 40px auto 0 auto;">
  <div class="mgm-form-card" style="width: 100%;">
    <h3 class="fw-bold mb-2 text-dark" style="font-size: 22px;">MGM Alumni Registration</h3>
    <p class="text-muted small mb-4">Stay connected with your alma mater and fellow alumni.</p>
    <form action="/alumni/" method="POST">
      <input type="hidden" name="action" value="alumni_join">
      <div class="mgm-form-group">
        <label class="mgm-form-label">Full Name *</label>
        <input type="text" name="name" class="mgm-form-control" placeholder="Your Name" required>
      </div>
      <div class="mgm-form-group">
        <label class="mgm-form-label">Year of Passing (Batch) *</label>
        <input type="text" name="passing_year" class="mgm-form-control" placeholder="e.g. 2018" required>
      </div>
      <div class="mgm-form-group">
        <label class="mgm-form-label">Current Profession / University</label>
        <input type="text" name="profession" class="mgm-form-control" placeholder="e.g. Software Engineer">
      </div>
      <div class="mgm-form-group">
        <label class="mgm-form-label">Phone Number *</label>
        <input type="tel" name="phone" class="mgm-form-control" placeholder="Mobile Number" required>
      </div>
      <div class="mgm-form-group">
        <label class="mgm-form-label">Email Address</label>
        <input type="email" name="email" class="mgm-form-control" placeholder="name@example.com">
      </div>
      <button type="submit" class="tp-btn-primary w-100 py-3 mt-2">
        Register as Alumni Member
      </button>
    </form>
  </div>
</div>
`;
alumniHtml = alumniHtml.replace(/<\/div>\s*<\/div>\s*$/, alumniFormSnippet + '</div></div>');

function escapeSql(str) {
  if (str === null || str === undefined) return 'NULL';
  return "'" + String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";
}

// Generate SQL update statements
let sql = '';
for (const [slug, p] of Object.entries(pages)) {
  let content = cleanHtml(p.rawHtml);
  if (slug === 'admission-procedure') content = admHtml;
  if (slug === 'courses-offered') content = crsHtml;
  if (slug === 'alumni') content = alumniHtml;

  sql += `UPDATE pages SET content_html = ${escapeSql(content)} WHERE slug = ${escapeSql(slug)};\n`;
}

fs.writeFileSync('audit/update_pages.sql', sql);
console.log('Generated audit/update_pages.sql');
