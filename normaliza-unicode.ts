import { getAllFiles, skipHiddenFilesFilter } from "./util.ts"
import * as path from "https://deno.land/std@0.139.0/path/mod.ts";

const src = "/Users/jedrzejlewandowski/git-repository/solideo.pl-v5/Strona"

const filepathsAbsolute = await getAllFiles(src, { filter: skipHiddenFilesFilter })
const filepathsRelative = filepathsAbsolute.map(fPath => path.relative(path.resolve(src), fPath))
filepathsRelative.sort()
for (const fPath of filepathsRelative) {
  const normalized = fPath.normalize("NFC")
  if (fPath !== normalized) {
    const mvSrc = `${src}/${fPath}`;
    const mvDst = `${src}/${normalized}`;
    Deno.renameSync(mvSrc, mvDst)
    console.log(`Normalized: ${normalized}`)
  }
}
