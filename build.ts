import fs from 'fs';
// @ts-ignore
import { markdownToHtml } from './build-react.tsx'
// @ts-ignore
import { getAllFiles } from './utils/recurisve-direcotry-listing.ts';
import * as path from 'path'

fs.rmSync('./public', {recursive: true});
fs.mkdirSync('./public', {recursive: true});

const filesArr = getAllFiles('./content', []);

for (const file of filesArr) {
  const destinationPath = path.join('public', path.relative('content', file));
  fs.mkdirSync(path.dirname(destinationPath), {recursive: true});
  if (/\.md$/.test(file)){
    const htmlDestinationPath = destinationPath.replace('.md', '.html');
    const markdownContent = fs.readFileSync(file, 'utf8');
    const htmlContent = markdownToHtml(markdownContent);
    fs.writeFileSync(htmlDestinationPath, htmlContent, 'utf8');
  } else {
    fs.cpSync(file, destinationPath);
  }
}
