import React from 'react'
import { Layout } from './Layout.jsx'

export function ListPageLayout(
  { children, frontmatter, items }:
    { children: React.ReactNode, frontmatter: Record<string, any>, items: { children: React.ReactNode, frontmatter: Record<string, any> } }
) {
  return <Layout>
    <h1>List</h1>
  </Layout>
}
