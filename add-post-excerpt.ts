import { getAllFiles, readMarkdownFile } from "./generator/utils/index.js"
import yaml from 'yaml';
import * as fs from "fs";

const contentDir = "content"

for (const file of getAllFiles(contentDir)) {
  if (file.endsWith(".md")) {
    const { contents, frontmatter } = readMarkdownFile(file)
    frontmatter.excerpt = contentsToExcerpt(contents)
    const yamlText = yaml.stringify(frontmatter, {

    })
    const newContents = `---\n${yamlText.trim()}\n---\n${contents.trim()}`
    fs.writeFileSync(file, newContents)
  }
}

function contentsToExcerpt(contents: string) {
  const extracted = contents.replaceAll(/<!--(.*)-->/gmi, "")
    .replaceAll(/<style>(.*)<\/style>/gms, "")
    .replaceAll(/<script>(.*)<\/script>/gms, "")
    .replaceAll(/<time>(.*)<\/time>/gms, "")
    .replaceAll(/<\/?[a-zA-Z0-9]+([^>])*>/gmi, "")
    .replaceAll(/!\[[^\]]*\]\([^)]+\)/gmi, "")
    .replaceAll(/\[([^\]]*)\]\([^)]+\)/gmi, "$1")
    .replaceAll(/^#+\s?/gmi, "")
    .replaceAll(/^>\s?/gmi, "")
    .replaceAll("***", "")
    .replaceAll("**", "")
    .replaceAll(/^[ \t]+/gms, "")
    .replaceAll("\r", "")
    .replaceAll("\n\n\n\n\n", "\n")
    .replaceAll("\n\n\n\n", "\n")
    .replaceAll("\n\n\n", "\n")
    .replaceAll("\n\n", "\n")
    .replaceAll("\n\n", "\n")
    .replaceAll("\n\n", "\n")
    .trim()
  if (extracted.length <= 300) {
    return extracted
  }
  return extracted.substring(0, 300) + '...'
}
