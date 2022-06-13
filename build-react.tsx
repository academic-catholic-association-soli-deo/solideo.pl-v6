import { renderToStaticMarkup } from 'react-dom/server';
import React, { ReactNode } from 'react'
import ReactMarkdown from 'react-markdown'
import yaml from 'yaml';
import { string } from 'yaml/dist/schema/common/string'

function MarkdownPage({ markdownContent, title }: {markdownContent: string, title: string}) {
    return (
        <Layout>
          <h1>{title}</h1>
          <ReactMarkdown>
            {markdownContent}
          </ReactMarkdown>
        </Layout>
    )
}

function Layout({children}: {children: ReactNode}) {
  return (
    <React.StrictMode>
      <div>
        <h1>Soli Deo</h1>
        {children}
      </div>
    </React.StrictMode>
  )
}

export function markdownToHtml(markdownContent: string) {
  const matchedGroups = /^---(?<frontmatter>[\s\S]*)---(?<markdown>[\s\S]*)$/gmy.exec(markdownContent);
  const frontmatter = yaml.parse(matchedGroups?.groups?.frontmatter || '');
  const markdown = matchedGroups?.groups?.markdown as string;
  return wrapHtml({
    html: renderToStaticMarkup(<MarkdownPage markdownContent={markdown} title={frontmatter.title}/>),
    title: frontmatter.title,
  })
};

function HomePage() {
  return (
    <Layout>
      <h1>Hello!</h1>
    </Layout>
  )
}

function wrapHtml({ html, title }: { html: string; title: string }): string {
  return (`<!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>${title} - ASK Soli Deo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
        ${html}
    </body>
    </html>
`)
}

export function renderHomePage() {
  return wrapHtml(  { html: renderToStaticMarkup(<HomePage/>), title: 'Strona główna'});
}
