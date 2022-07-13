import fs from 'fs';
import { renderMDPage, renderMDXPage } from './build-react.js'
import { cleanTargetDirectory, copyFile, getAllFiles, getParentDirectory, hasSubdirectories, isMarkdownFile, isMDXFile, makePath, readMarkdownFile, transposePath, writeFile } from './utils/index.js';
import * as path from 'path'
import { Config } from './types.js';
import { ListLayoutWithItems } from './lists.js';

export async function generateStaticWebsite(config: Config) {
  const cleanConfig = sanitizeConfig(config)
  cleanTargetDirectory(cleanConfig.targetDir)
  for (const file of getAllFiles(cleanConfig.contentDir)) {
    makePath(transposePath(file, { sourceDir: cleanConfig.contentDir, targetDir: cleanConfig.targetDir }))
    await transformFile(file, cleanConfig)
  }
}

function sanitizeConfig(config: Config): Config {
  if (!fs.existsSync(config.contentDir)) {
    throw new Error(`Content directory ${config.contentDir} does not exist`)
  }
  const contentDir = path.resolve(config.contentDir)
  const targetDir = path.resolve(config.targetDir)
  return {
    mdxComponents: config.mdxComponents,
    htmlWrapperFn: config.htmlWrapperFn,
    layouts: config.layouts,
    contentDir: path.resolve(contentDir),
    targetDir: path.resolve(targetDir)
  }
}

async function transformFile(file: string, config: Config) {
  if (isMarkdownFile(file)) {
    await transformMarkdownFile(file, config)
  } else {
    copyFile(file, transposePath(file, { sourceDir: config.contentDir, targetDir: config.targetDir }))
  }
}

async function transformMarkdownFile(file: string, config: Config) {
  const { contentDir: sourceDir, targetDir } = config
  const targetPath = transposePath(file, { sourceDir, targetDir, extension: 'html' })
  const contents = await markdownFileToHtml(file, config)
  writeFile({ file: targetPath, contents })
}

async function markdownFileToHtml(file: string, config: Config) {
  const { mdxComponents, layouts } = config
  let layout = layouts.single;
  if (hasSubdirectories(getParentDirectory(file))) {
    layout = await ListLayoutWithItems(layouts.list, file)
  }
  const { contents, frontmatter } = readMarkdownFile(file)
  const title = frontmatter.title || ''
  const html = isMDXFile(file) ? await renderMDXPage({ contents, frontmatter, components: mdxComponents, layout })
    : await renderMDPage({ contents, frontmatter, layout })
  return config.htmlWrapperFn({ html, frontmatter, title })
}
