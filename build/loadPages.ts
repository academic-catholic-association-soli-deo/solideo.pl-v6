import { getChildFiles, getDirsRecursive, readMarkdownFile } from "./utils"

export function loadPages(contentDir: string): SourcePageBundle[] {
  const allFiles = getDirsRecursive(contentDir)
  return allFiles.map(dirToBundle)
}

export interface SourcePageBundle {
  markdown: MarkdownFile | null
  assets: Asset[]
}

export interface MarkdownFile {
  sourcePath: string
  contents: string
  frontmatter: Record<string, string>
}

export interface Asset {
  sourcePath: string
  filename: string
}

function dirToBundle(dirPath: string): SourcePageBundle {
  const childFiles = getChildFiles(dirPath)
  const markdown = getMarkdown(childFiles)
  const assets = getAssets(childFiles)
  return { markdown, assets }
}

function getMarkdown(childFiles: string[]) {
  const sourcePath = childFiles.find(file => file.endsWith('.md'))
  if (!sourcePath) return null
  const { contents, frontmatter } = readMarkdownFile(sourcePath)
  return { sourcePath, contents, frontmatter }
}

function getAssets(childFiles: string[]): Asset[] {
  return childFiles.filter(isAsset).map(file => {
    return {
      sourcePath: file,
      filename: file.split('/').pop()!
    }
  })
}

function isAsset(filePath: string) {
  const assetExtensions = ['.png', '.jpg', '.jpeg', '.gif', '.svg', '.webp', '.mp3', '.pdf']
  return assetExtensions.some(ext => filePath.endsWith(ext))
}
