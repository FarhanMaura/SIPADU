const fs = require('fs');

const file = fs.readFileSync('d:/webfeb/resources/views/layouts/adminlte.blade.php', 'utf8');

const cssMatch = file.match(/<style>([\s\S]*?)<\/style>/);
if (cssMatch) {
    if (!fs.existsSync('d:/webfeb/public/css')) {
        fs.mkdirSync('d:/webfeb/public/css', { recursive: true });
    }
    fs.writeFileSync('d:/webfeb/public/css/dashboard.css', cssMatch[1].trim());
    console.log('Created dashboard.css');
}

const jsMatch = file.match(/<script>\s*\(\s*function\s*\(\)\s*\{([\s\S]*?)\}\)\(\);\s*<\/script>/);
if (jsMatch) {
    if (!fs.existsSync('d:/webfeb/public/js')) {
        fs.mkdirSync('d:/webfeb/public/js', { recursive: true });
    }
    const jsContent = `(function() {\n${jsMatch[1]}\n})();`;
    fs.writeFileSync('d:/webfeb/public/js/dashboard.js', jsContent);
    console.log('Created dashboard.js');
}
