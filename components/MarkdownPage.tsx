import React from 'react'
import ReactMarkdown from 'react-markdown'
import { Layout } from './Layout.jsx'

export function MarkdownPage({ markdownContent, title }: { markdownContent: string, title: string }) {
  return (
    <Layout>
      <h1>{title}</h1>
      <ReactMarkdown>
        {markdownContent}
      </ReactMarkdown>
    </Layout>
  )
}
