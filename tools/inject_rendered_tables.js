const fs = require('fs');

const admDetails = JSON.parse(fs.readFileSync('audit/raw_pages/admission-procedure_details.json', 'utf8'));
const crsDetails = JSON.parse(fs.readFileSync('audit/raw_pages/courses-offered_details.json', 'utf8'));

// Build complete HTML for admission-procedure table
function buildAdmissionTable(tbl) {
  let html = `<div class="ninja_table_wrapper"><table class="foo-table ninja_footable foo_table_16000 ui table celled striped selectable fixed">`;
  html += `<thead><tr><th class="ninja_column_0" style="width: 25%;">Classes</th><th class="ninja_column_1">Documents Required</th></tr></thead><tbody>`;
  
  // Skip first row if it is header
  for (let i = 1; i < tbl.rows.length; i++) {
    const row = tbl.rows[i];
    if (row.length >= 2) {
      html += `<tr><td class="ninja_column_0 fw-bold">${row[0].text}</td><td class="ninja_column_1">${row[1].text}</td></tr>`;
    }
  }
  html += `</tbody></table></div>`;
  return html;
}

// Build complete HTML for courses-offered table
function buildCoursesTable(tbl) {
  let html = `
  <div class="ninja_table_wrapper">
    <div class="ninja-tables-header mb-3">
      <input type="text" id="courseTableSearch" class="form-control" placeholder="Search courses and subjects..." style="max-width: 350px;">
    </div>
    <table class="foo-table ninja_footable foo_table_15963 ui table selectable striped" id="coursesTable">
      <thead>
        <tr>
          <th class="ninja_column_0" style="width: 25%;">Classes</th>
          <th class="ninja_column_1">Subjects taught</th>
        </tr>
      </thead>
      <tbody>`;

  // Start from row index 2 (skipping search bar and header rows)
  for (let i = 2; i < tbl.rows.length; i++) {
    const row = tbl.rows[i];
    if (row.length >= 2) {
      html += `<tr><td class="ninja_column_0 fw-bold">${row[0].text}</td><td class="ninja_column_1">${row[1].text}</td></tr>`;
    }
  }
  html += `</tbody></table></div>`;
  return html;
}

const admTableHtml = buildAdmissionTable(admDetails.tables[0]);
const crsTableHtml = buildCoursesTable(crsDetails.tables[0]);

fs.writeFileSync('audit/admission_table_rendered.html', admTableHtml);
fs.writeFileSync('audit/courses_table_rendered.html', crsTableHtml);
console.log('Built complete rendered tables for admission-procedure and courses-offered.');
