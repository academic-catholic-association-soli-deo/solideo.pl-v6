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
  return renderToStaticMarkup(<MarkdownPage markdownContent={markdownContent}/>);
}

function HomePage() {
  return (
    <Layout>
      <h1>Hello!</h1>
    </Layout>
  )
}

export function renderHomePage() {
  return renderToStaticMarkup(<HomePage/>);
}
