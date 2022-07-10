import { renderToStaticMarkup } from 'react-dom/server';
import React from 'react'
import * as jsxRuntime from 'react/jsx-runtime'
import { evaluate } from '@mdx-js/mdx';
import ReactMarkdown from 'react-markdown'
import { MDXProvider } from '@mdx-js/react';
import rehypeRaw from 'rehype-raw'
import { LayoutComponentSinglePage } from './types.js';

export async function renderMDPage(
  { contents, frontmatter, layout }: { contents: string, frontmatter: Record<string, any>, layout: LayoutComponentSinglePage }
) {
  const component = <ReactMarkdown rehypePlugins={[rehypeRaw]}>{contents}</ReactMarkdown>
  return renderReact(component, frontmatter, layout)
};

export async function renderMDXPage(
  { contents, frontmatter, components, layout }:
    { contents: string, frontmatter: Record<string, any>, components: Record<string, React.ReactNode | JSX.Element | React.FC<any>>, layout: LayoutComponentSinglePage }
) {
  const { default: MDXContent } = await evaluate(contents, { ...(jsxRuntime as any) })
  return renderReact(<MDXProvider><MDXContent components={components as any} /></MDXProvider >, frontmatter, layout)
};

function renderReact(component: React.ReactNode, frontmatter: Record<string, any>, Layout: LayoutComponentSinglePage) {
  return renderToStaticMarkup(
    <Layout frontmatter={frontmatter}>
      {component}
    </Layout >
  )
}
