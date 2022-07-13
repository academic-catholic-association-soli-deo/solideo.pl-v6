import { LayoutComponentListPage, LayoutComponentSinglePage } from "./types.js";
import React from 'react';
import { getAllFiles } from "./utils/recursive-directory-listing.js";
import * as path from "path";
import { isMarkdownFile, readMarkdownFile } from "./utils/markdown.js";
import { renderMDPage } from "./build-react.js";
import { EmptySinglePageLayout } from "./EmptySinglePageLayout.js";

export async function ListLayoutWithItems(ListLayout: LayoutComponentListPage, file: string): Promise<LayoutComponentSinglePage> {
  const items = await parseListItems(file)

  return ({ children, frontmatter }: { children: React.ReactNode, frontmatter: Record<string, any> }): JSX.Element => {
    return ListLayout({ frontmatter, children, items })
  }
}

async function parseListItems(file: string) {
  const items: Parameters<LayoutComponentSinglePage>[0][] = []
  const dirPath = path.dirname(file)
  for (const child of getAllFiles(dirPath)) {
    if (child != file && isMarkdownFile(child)) {
      items.push(await fileToItem(child))
    }
  }
  return items
}

async function fileToItem(file: string): Promise<Parameters<LayoutComponentSinglePage>[0]> {
  const { frontmatter } = readMarkdownFile(file)
  const excerpt = frontmatter.excerpt || ""
  const children = await renderMDPage({
    contents: excerpt,
    frontmatter,
    layout: EmptySinglePageLayout,
  })
  return {
    frontmatter,
    children,
  }
}
