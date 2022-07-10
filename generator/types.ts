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

export type LayoutComponentSinglePage = (props: {
  frontmatter: Record<string, any>,
  children: React.ReactNode
}) => JSX.Element

export type LayoutComponentListPage = (props: {
  frontmatter: Record<string, any>,
  children: React.ReactNode,
  items: Parameters<LayoutComponentSinglePage>[]
}) => JSX.Element

export type HtmlWrapperFn = (props: { html: string, title: string, frontmatter: Record<string, any> }) => string
