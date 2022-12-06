import React from 'react'

export function EmptySinglePageLayout({ children }: { children: React.ReactNode, frontmatter: Record<string, any> }) {
  return <>{children}</>
}

