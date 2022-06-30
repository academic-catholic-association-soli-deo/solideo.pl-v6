import fs from 'fs';
import { renderMDPage, renderMDXPage } from './build-react.jsx'
import { getAllFiles } from './utils/index.js';
import * as path from 'path'

(async function () {
  if (fs.existsSync('./public')) fs.rmSync('./public', { recursive: true });
  fs.mkdirSync('./public', { recursive: true });

  const filesArr = getAllFiles('./content', []);

  for (const file of filesArr) {
    const destinationPath = path.join('public', path.relative('content', file));
    fs.mkdirSync(path.dirname(destinationPath), { recursive: true });
    if (/\.mdx$/.test(file)) {
      renderFile(file, destinationPath.replace('.mdx', '.html'), renderMDXPage)
    }
    else if (/\.md$/.test(file)) {
      renderFile(file, destinationPath.replace('.md', '.html'), renderMDPage)
    }
    else {
      fs.cpSync(file, destinationPath);
    }
  }
})().catch(console.error)

async function renderFile(sourcePath: string, destinationPath: string, renderer: (contents: string) => Promise<string>) {
  const htmlDestinationPath = destinationPath.replace('.md', '.html');
  const contents = fs.readFileSync(sourcePath, "utf-8")
  const html = await renderer(contents)
  fs.writeFileSync(htmlDestinationPath, html)
}
