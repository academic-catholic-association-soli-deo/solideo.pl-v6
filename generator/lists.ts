import { LayoutComponentListPage, LayoutComponentSinglePage } from "./types.js";
import React from 'react';

export function ListLayoutWithItems(ListLayout: LayoutComponentListPage): LayoutComponentSinglePage {
  return ({ children, frontmatter }: { children: React.ReactNode, frontmatter: Record<string, any> }): JSX.Element => {
    return ListLayout({ frontmatter, children, items: [] })
  }
}
