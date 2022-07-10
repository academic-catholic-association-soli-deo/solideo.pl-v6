import React from 'react'
import { ImagePlaceholderGifPattern } from './ImagePlaceholderGifPattern.js'
import { Layout } from './Layout.jsx'

export function SinglePageLayout({ children, frontmatter }: { children: React.ReactNode, frontmatter: Record<string, any> }) {
  return <Layout>
    <SinglePageContent frontmatter={frontmatter}>{children}</SinglePageContent>
  </Layout>
}

function SinglePageContent({ children, frontmatter }: { children: React.ReactNode, frontmatter: Record<string, any> }) {
  return <Layout>
    <article>
      <div className="post-above">
        {frontmatter.time && <Time time={frontmatter.time} />}
      </div>
      <div className="post post-complete">
        <div className="text-container">
          <CoverPhoto frontmatter={frontmatter} />
          {frontmatter.title && <h2>{frontmatter.title}</h2>}
          {children}
        </div>
      </div>
    </article>
  </Layout>
}

function CoverPhoto({ frontmatter }: { frontmatter: Record<string, any> }) {
  if (frontmatter.coverPhoto) {
    return <img src={frontmatter.coverPhoto.path} alt={frontmatter.coverPhoto.alt || ''} />
  }
  return <ImagePlaceholderGifPattern />
}

function Time({ time }: { time: string }) {
  const date = new Date(Date.parse(time))
  return <time dateTime={date.toISOString()}>{time}</time>
}
