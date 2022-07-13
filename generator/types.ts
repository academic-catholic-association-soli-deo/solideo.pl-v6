import React from "react"

export interface Config {
  contentDir: string,
  targetDir: string,
  mdxComponents: Record<string, React.ReactNode | JSX.Element | React.FC<any>>,
  layouts: {
    single: LayoutComponentSinglePage,
    list: LayoutComponentListPage,
  },
  htmlWrapperFn: HtmlWrapperFn
}

interface LayoutComponentSinglePageProps {
  frontmatter: Record<string, any>,
  children: React.ReactNode
}
export type LayoutComponentSinglePage = (props: LayoutComponentSinglePageProps) => JSX.Element

export type LayoutComponentListPage = (props: {
  frontmatter: Record<string, any>,
  children: React.ReactNode,
  items: LayoutComponentSinglePageProps[]
}) => JSX.Element

export type HtmlWrapperFn = (props: { html: string, title: string, frontmatter: Record<string, any> }) => string
