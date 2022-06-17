import fs from 'fs';
import { markdownToHtml } from './build-react.jsx'
import { getAllFiles } from './utils/index.js';
import * as path from 'path'

if (fs.existsSync('./public')) fs.rmSync('./public', { recursive: true });
fs.mkdirSync('./public', { recursive: true });

const filesArr = getAllFiles('./content', []);

for (const file of filesArr) {
  const destinationPath = path.join('public', path.relative('content', file));
  fs.mkdirSync(path.dirname(destinationPath), { recursive: true });
  if (/\.mdx?$/.test(file)) {
    const htmlDestinationPath = destinationPath.replaceAll(/\.mdx?$/g, '.html');
    const markdownContent = fs.readFileSync(file, 'utf8');
    const htmlContent = markdownToHtml(markdownContent);
    fs.writeFileSync(htmlDestinationPath, htmlContent, 'utf8');
  } else {
    fs.cpSync(file, destinationPath);
  }
}
