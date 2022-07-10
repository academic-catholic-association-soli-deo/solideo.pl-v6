import yaml from 'yaml';

export function extractFrontMatter(contentsWithFrontmatter: string): { frontmatter: Record<string, any>, contents: string } {
  const matchedGroups = /^---(?<frontmatter>[\s\S]*)---(?<contents>[\s\S]*)$/gmy
    .exec(contentsWithFrontmatter);
  const frontmatter = yaml.parse(matchedGroups?.groups?.frontmatter || '');
  const contents = matchedGroups?.groups?.contents as string;
  return { frontmatter, contents }
}
