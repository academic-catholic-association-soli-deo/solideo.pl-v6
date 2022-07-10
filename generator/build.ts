import fs from 'fs';
import { renderMDPage, renderMDXPage } from './build-react.jsx'
import { getAllFiles } from './utils/index.js';
import * as path from 'path'
import * as components from './components/index.js'
import { Layout } from './components/index.js'
import { wrapHtml } from './html.js';

(async function () {
  await generateStaticWebsite({
    contentDir: './content',
    targetDir: './public',
    mdxComponents: components,
    layouts: {
      single: Layout,
      list: Layout,
    },
    htmlWrapper: ({ html, title, frontmatter }: { html: string; title: string, frontmatter: Record<string, any> }) => (`<!DOCTYPE html>
  <html lang="pl">
  <head>
      <meta charset="utf-8">
      <title>${title} - ASK Soli Deo</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
      <link rel="manifest" href="/favicon/manifest.json">
      <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#23527c">
      <meta name="theme-color" content="#23527c">
      <meta name="msapplication-TileColor" content="#23527c">
      <meta name="msapplication-TileImage" content="/favicon/mstile-150x150.png">
      ${frontmatter.structuredData ?
        `<script type="application/ld+json">${JSON.stringify(frontmatter.structuredData)}</script>`
        : ''
      }
          <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CLora:400,700&amp;subset=latin-ext" rel="stylesheet">
          <link rel="stylesheet" href="/style.css">
  </head>
  <body>
      ${html}
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="/scripts.js"></script>
  </body>
  </html>
  `)
  })

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
