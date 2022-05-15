import { getAllFiles, skipHiddenFilesFilter } from "./util.ts"
import * as path from "https://deno.land/std@0.139.0/path/mod.ts";
import * as yaml from "https://deno.land/std@0.139.0/encoding/yaml.ts";

const src = "content"

const filepaths = await getAllFiles(src, { filter: skipHiddenFilesFilter })
const mdFiles = filepaths.filter(fPath => /\.txt$/gui.exec(fPath) !== null)

for (const fPath of mdFiles) {
  console.log()
  console.log("---")
  console.log(fPath)
  const transformedMd = await transformBundleFile(fPath)
  console.log(transformedMd)
}

async function transformBundleFile(mdPath: string) {
  let contents = await Deno.readTextFile(mdPath)
  const frontMatterData = await readImportDataOfContentBundle(mdPath)

  const time = readTimeFromMdContents(contents)
  contents = stripTimeFromMdContents(contents)
  if (time) {
    frontMatterData.time = time
  }

  const title = readTitleFromMdContents(contents)
  contents = stripTitleFromMdContents(contents)
  frontMatterData.title = title

  const coverPhoto = readCoverPhotoFromMdContents(contents)
  contents = stripCoverPhotoFromMdContents(contents)
  if (coverPhoto) {
    frontMatterData.coverPhoto = coverPhoto
  }

  return `---\n${yaml.stringify(frontMatterData).trim()}\n---\n${contents.trim()}`
}

async function readImportDataOfContentBundle(mdPath: string): Promise<Record<string, unknown>> {
  const parentDir = path.dirname(mdPath)
  const importDataFilepath = `${parentDir}/import-data.json`
  let importDataContents = ""
  try {
    importDataContents = await Deno.readTextFile(importDataFilepath)
  } catch (err) {
    if (`${err}`.indexOf("NotFound") !== -1) {
      return {}
    }
    throw err
  }
  return JSON.parse(importDataContents) as Record<string, unknown>
}

function readTimeFromMdContents(mdContents: string): string | null {
  const match = /<time>(?<time>[^<]+)<\/time>/gmui.exec(mdContents)
  if (match?.groups?.time !== null) {
    return match?.groups?.time?.trim() || null
  }
  return null
}

function stripTimeFromMdContents(mdContents: string): string {
  return mdContents.replace(/<time>(?<time>[^<]+)<\/time>/gmui, "")
}

function readTitleFromMdContents(mdContents: string): string {
  const match = /^#(?<title>[^#].*)$/gmui.exec(mdContents)
  if (match?.groups?.title) {
    return match?.groups?.title?.trim().replace("\n", "")
  }
  throw new Error(`Title missing`)
}

function stripTitleFromMdContents(mdContents: string): string {
  return mdContents.replace(/^#(?<title>[^#].*)\n?/gmui, "")
}

function readCoverPhotoFromMdContents(mdContents: string) {
  const match = /^!\[(?<alt>[^\]]+)\]\((?<path>[^\)]+)\)/gmui.exec(mdContents)
  const alt = match?.groups?.alt
  const path = match?.groups?.path
  if (alt && path) {
    return { alt, path }
  }
}

function stripCoverPhotoFromMdContents(mdContents: string): string {
  return mdContents.replace(/^!\[(?<alt>[^\]]+)\]\((?<path>[^\)]+)\)\n?/gmui, "")
}
