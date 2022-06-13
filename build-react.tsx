import { renderToStaticMarkup } from 'react-dom/server';
import React, { ReactNode } from 'react'
import ReactMarkdown from 'react-markdown'
import children = ReactMarkdown.propTypes.children

function MarkdownPage({ markdownContent }: {markdownContent: string}) {
    return (
        <Layout>
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
  return wrapHtml(renderToStaticMarkup(<MarkdownPage markdownContent={markdownContent}/>));
}

function HomePage() {
  return (
    <Layout>
      <h1>Hello!</h1>
    </Layout>
  )
}

function wrapHtml(html: string): string {
  return (`<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Solideo</title>
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
  return wrapHtml(renderToStaticMarkup(<HomePage/>));
}
