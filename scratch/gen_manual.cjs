const fs = require('fs');
const path = require('path');

const mdPath = 'C:\\Users\\windows\\.gemini\\antigravity\\brain\\6ed58355-fe23-420a-b95e-62f62e134c67\\PROFESSIONAL_USER_MANUAL.md';
const outPath = 'C:\\Users\\windows\\.gemini\\antigravity\\brain\\6ed58355-fe23-420a-b95e-62f62e134c67\\PorciTrack_User_Manual.html';

let md = fs.readFileSync(mdPath, 'utf8');

function escapeHtml(str) {
  return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function mdToHtml(md) {
  let html = md;

  // Horizontal rules
  html = html.replace(/^---$/gm, '<hr>');

  // Headings
  html = html.replace(/^#### (.+)$/gm, '<h4>$1</h4>');
  html = html.replace(/^### (.+)$/gm, '<h3>$1</h3>');
  html = html.replace(/^## (.+)$/gm, '<h2>$1</h2>');
  html = html.replace(/^# (.+)$/gm, '<h1>$1</h1>');

  // Tables
  html = html.replace(/((?:^\|.+\|\n)+)/gm, (block) => {
    const lines = block.trim().split('\n');
    let table = '<table>';
    lines.forEach((line, i) => {
      if (line.match(/^\|[\s:\-|]+\|$/)) return;
      const cells = line.split('|').slice(1, -1);
      const tag = i === 0 ? 'th' : 'td';
      const row = cells.map(c => `<${tag}>${c.trim()}</${tag}>`).join('');
      table += `<tr>${row}</tr>`;
    });
    table += '</table>';
    return table;
  });

  // Blockquotes
  html = html.replace(/^> (.+)$/gm, '<blockquote>$1</blockquote>');

  // Bold
  html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');

  // Italic
  html = html.replace(/\*(.+?)\*/g, '<em>$1</em>');
  html = html.replace(/_(.+?)_/g, '<em>$1</em>');

  // Inline code
  html = html.replace(/`([^`]+)`/g, '<code>$1</code>');

  // Ordered lists
  html = html.replace(/((?:^\d+\. .+\n?)+)/gm, (block) => {
    const items = block.trim().split('\n').map(l => `<li>${l.replace(/^\d+\. /,'')}</li>`).join('');
    return `<ol>${items}</ol>`;
  });

  // Unordered lists
  html = html.replace(/((?:^[\*\-] .+\n?)+)/gm, (block) => {
    const items = block.trim().split('\n').map(l => `<li>${l.replace(/^[\*\-] /,'')}</li>`).join('');
    return `<ul>${items}</ul>`;
  });

  // Paragraphs (lines not already wrapped)
  html = html.split('\n').map(line => {
    if (!line.trim()) return '<br>';
    if (/^<(h[1-6]|ul|ol|li|table|tr|th|td|hr|blockquote|br)/.test(line.trim())) return line;
    return `<p>${line}</p>`;
  }).join('\n');

  return html;
}

const body = mdToHtml(md);

const css = `
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: Arial, sans-serif; font-size: 12pt; line-height: 1.75; color: #1a1a1a; background: #fff; padding: 50px 60px; max-width: 900px; margin: 0 auto; }
  h1 { font-size: 24pt; font-weight: 700; color: #14532d; border-bottom: 4px solid #16a34a; padding-bottom: 12px; margin: 24px 0 8px; }
  h2 { font-size: 16pt; font-weight: 700; color: #15803d; margin: 40px 0 10px; border-left: 6px solid #16a34a; padding-left: 14px; }
  h3 { font-size: 13pt; font-weight: 700; color: #166534; margin: 24px 0 8px; }
  h4 { font-size: 11pt; font-weight: 700; color: #1a1a1a; margin: 18px 0 6px; }
  p { margin: 8px 0; }
  ul, ol { margin: 8px 0 10px 28px; }
  li { margin: 5px 0; }
  table { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 10.5pt; }
  th { background: #15803d; color: #fff; padding: 10px 14px; text-align: left; font-weight: 700; }
  td { padding: 9px 14px; border-bottom: 1px solid #d1fae5; vertical-align: top; }
  tr:nth-child(even) td { background: #f0fdf4; }
  blockquote { background: #f0fdf4; border-left: 5px solid #16a34a; padding: 14px 18px; margin: 16px 0; border-radius: 4px; color: #374151; font-size: 10.5pt; }
  code { background: #f1f5f9; padding: 2px 6px; border-radius: 3px; font-family: Courier New, monospace; font-size: 10pt; color: #dc2626; }
  strong { font-weight: 700; }
  em { font-style: italic; }
  hr { border: none; border-top: 2px solid #d1fae5; margin: 30px 0; }
  br { display: block; margin: 4px 0; }
  .cover { text-align: center; padding: 100px 0 80px; border-bottom: 3px solid #16a34a; margin-bottom: 40px; }
  .cover h1 { border: none; font-size: 30pt; }
  @media print {
    h2 { page-break-before: always; }
    h2:first-of-type { page-break-before: avoid; }
    table { page-break-inside: avoid; }
    blockquote { page-break-inside: avoid; }
  }
`;

const fullHtml = `<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PorciTrack — Professional User Manual</title>
<style>${css}</style>
</head>
<body>
<div class="cover">
  <h1>PorciTrack</h1>
  <p style="font-size:16pt;color:#15803d;font-weight:600;margin-top:10px;">Professional User Manual</p>
  <p style="margin-top:20px;color:#6b7280;">System Version 1.0.0 &nbsp;|&nbsp; Official Operations Manual</p>
  <p style="color:#6b7280;">Prepared for: Farm Administrators &amp; Field Personnel</p>
  <p style="margin-top:30px;color:#9ca3af;font-size:10pt;">© 2026 PorciTrack. All rights reserved.</p>
</div>
${body}
</body>
</html>`;

fs.writeFileSync(outPath, fullHtml, 'utf8');
console.log('HTML manual generated at:', outPath);
