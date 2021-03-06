import { renderToStaticMarkup } from 'react-dom/server';
import React from 'react'
import * as jsxRuntime from 'react/jsx-runtime'
import { Layout, SinglePageContent } from './components/index.js';
import { wrapHtml } from './html.js';
import { extractFrontMatter } from './utils/index.js';
import { evaluate } from '@mdx-js/mdx';
import ReactMarkdown from 'react-markdown'
import { MDXProvider } from '@mdx-js/react';
import * as components from './components/index.js'
import rehypeRaw from 'rehype-raw'

export async function renderMDPage(fileContents: string) {
  const { contents, frontmatter } = extractFrontMatter(fileContents)
  const component =
    <ReactMarkdown rehypePlugins={[rehypeRaw]}>{contents}</ReactMarkdown>
  return renderReact(component, frontmatter)
};

export async function renderMDXPage(fileContents: string) {
  const { contents, frontmatter } = extractFrontMatter(fileContents)
  const { default: MDXContent } = await evaluate(contents, { ...(jsxRuntime as any) })
  return renderReact(<MDXProvider><MDXContent components={components} /></MDXProvider >, frontmatter)
};

function renderReact(component: React.ReactNode, frontmatter: Record<string, any>) {
  const title = frontmatter.title
  const html = renderToStaticMarkup(
    <Layout>
      <SinglePageContent frontmatter={frontmatter}>
        {component}
      </SinglePageContent>
    </Layout >
  )
  return wrapHtml({ html, title, frontmatter })
}
