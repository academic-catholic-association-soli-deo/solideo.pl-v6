import fs from 'fs';
import { buildReactSite } from './build-react';
import { getAllFiles } from './utils/recurisve-direcotry-listing';
import * as path from 'path'

fs.rmSync('./public', {recursive: true});
fs.mkdirSync('./public', {recursive: true});
fs.writeFileSync('./public/index.html', buildReactSite());

const filesArr = getAllFiles('./content', []);

for (const file of filesArr) {
  const destinationPath = path.join('public', path.relative('content', file));
  fs.mkdirSync(path.dirname(destinationPath), {recursive: true});
  if (/\.md$/.test(file)){
    //TODO: implement transformation
  } else {
    fs.cpSync(file, destinationPath);
  }
}
