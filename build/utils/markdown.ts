import yaml from 'yaml';
import * as fs from 'fs';

export function readMarkdownFile(file: string): { frontmatter: Record<string, any>, contents: string } {
  const contents = fs.readFileSync(file, "utf-8")
  return extractFrontMatter(contents)
}

export function isMarkdownFile(file: string) {
  return /\.mdx?$/.test(file)
}

export function isMDXFile(file: string) {
  return /\.mdx$/.test(file)
}

function extractFrontMatter(contentsWithFrontmatter: string): { frontmatter: Record<string, any>, contents: string } {
  const matchedGroups = /^---(?<frontmatter>[\s\S]*)---(?<contents>[\s\S]*)$/gmy
    .exec(contentsWithFrontmatter);
  const frontmatter = yaml.parse(matchedGroups?.groups?.frontmatter || '');
  const contents = matchedGroups?.groups?.contents as string;
  return { frontmatter, contents }
}

