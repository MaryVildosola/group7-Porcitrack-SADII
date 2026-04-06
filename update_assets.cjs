const fs = require('fs');
const file = 'c:/laragon/www/porcitrack/resources/views/users/welcome.blade.php';
let content = fs.readFileSync(file, 'utf8');

// The original paths are "../assets/..."
// E.g. <script src="../assets/libs/@popperjs/core/umd/popper.min.js"></script>
content = content.replace(/(href|src)="(\.\.\/assets\/[^"]+)"/g, (match, attr, path) => {
    return `${attr}="{{ asset('${path.replace('../assets/', 'assets/')}') }}"`;
});

// Write to file
fs.writeFileSync(file, content);
console.log('Replaced asset paths successfully!');

// Let's also print out any anchor tags that might be Login or Register links
const links = content.match(/<a[^>]*>(.*?)<\/a>/gi);
if (links) {
    let count = 0;
    links.forEach(link => {
        if (/log.?in|sign.?in|register|sign.?up/i.test(link)) {
            console.log('Found Auth Link:', link);
            count++;
        }
    });
    if (count === 0) console.log('No Auth Links found?!');
}
