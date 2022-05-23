import fs from 'fs';
fs.mkdirSync('./public', {recursive: true});
fs.writeFileSync('./public/index.html', '<h1>SOli Deo</h1>')