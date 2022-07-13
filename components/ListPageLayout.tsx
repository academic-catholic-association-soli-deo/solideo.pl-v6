import React from 'react'
import { Layout } from './Layout.jsx'

export function ListPageLayout(
  { children, frontmatter, items }:
    { children: React.ReactNode, frontmatter: Record<string, any>, items: { children: React.ReactNode, frontmatter: Record<string, any> }[] }
) {
  return <Layout><>
    <h1>{frontmatter.title}</h1>
    {children}
    {items.map((item, i) => (
      <div key={i}>
        <h2>{item.frontmatter.title || "No title"}</h2>
        {item.children}
      </div>))
    }
  </></Layout>
}
