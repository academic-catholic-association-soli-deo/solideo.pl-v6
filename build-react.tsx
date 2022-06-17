import { renderToStaticMarkup } from 'react-dom/server';
import React from 'react'
import { MarkdownPage, wrapHtml } from './components/index.js';
import { extractFrontMatter } from './utils/index.js';

export function markdownToHtml(markdownContent: string) {
  const { contents, frontmatter } = extractFrontMatter(markdownContent)
  return wrapHtml({
    html: renderToStaticMarkup(<MarkdownPage markdownContent={contents} title={frontmatter.title} />),
    title: frontmatter.title,
  })
};
