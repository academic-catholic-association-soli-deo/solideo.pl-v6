import fs from 'fs';
import { buildReactSite } from './build-react';

fs.mkdirSync('./public', {recursive: true});
fs.writeFileSync('./public/index.html', buildReactSite());