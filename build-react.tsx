import { renderToStaticMarkup } from 'react-dom/server';
import React from 'react'
import yaml from 'yaml';
import { HomePage, MarkdownPage, wrapHtml } from './components/index.js';

export function markdownToHtml(markdownContent: string) {
  const matchedGroups = /^---(?<frontmatter>[\s\S]*)---(?<markdown>[\s\S]*)$/gmy.exec(markdownContent);
  const frontmatter = yaml.parse(matchedGroups?.groups?.frontmatter || '');
  const markdown = matchedGroups?.groups?.markdown as string;
  return wrapHtml({
    html: renderToStaticMarkup(<MarkdownPage markdownContent={markdown} title={frontmatter.title} />),
    title: frontmatter.title,
  })
};

export function renderHomePage() {
  return wrapHtml({ html: renderToStaticMarkup(<HomePage />), title: 'Strona główna' });
}
