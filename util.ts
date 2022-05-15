export async function getAllFiles(
  currentPath: string,
  o: { filter: (e: Deno.DirEntry) => boolean }
) {
  const paths = await _getAllFiles(currentPath, o)
  return paths.map(path => Deno.realPathSync(path))
}

export const skipHiddenFilesFilter = (e: Deno.DirEntry) => !e.name.startsWith(".")

async function _getAllFiles(
  currentPath: string,
  o: { filter: (e: Deno.DirEntry) => boolean }
) {
  const names: string[] = [];

  for await (const dirEntry of Deno.readDir(currentPath)) {
    if (!o.filter(dirEntry)) continue;
    const entryPath = `${currentPath}/${dirEntry.name}`;
    names.push(entryPath);
    if (dirEntry.isDirectory) {
      names.push(...(await getAllFiles(entryPath, o)));
    }
  }

  return names;
}

export function getTitleFromPath(path: string): string {
  const match = /\/?(?<title>[^\/]+)\.[^.]+$/gmi.exec(path)
  if (match && !!match.groups?.title) {
    return match.groups?.title
  }
  throw new Error(`Could not get title from filepath ${path}`)
}

export function convertMdUriToHtml(href: string) {
  return href.trim().replace(/\.md$/ui, ".html")
}
