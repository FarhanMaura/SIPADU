const fs = require('fs');
const filePath = 'd:/webfeb/resources/views/layouts/adminlte.blade.php';
let content = fs.readFileSync(filePath, 'utf8');

content = content.replace(/<style>[\s\S]*?<\/style>/, `<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">`);
content = content.replace(/<script>\s*\(\s*function\s*\(\)\s*\{[\s\S]*?\}\)\(\);\s*<\/script>/, `<script src="{{ asset('js/dashboard.js') }}"></script>`);

fs.writeFileSync(filePath, content);
console.log('adminlte.blade.php updated successfully');
