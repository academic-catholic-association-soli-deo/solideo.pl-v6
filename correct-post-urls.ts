import yaml from 'yaml';
import * as fs from "fs";
import { readdirSync, statSync } from 'fs';
import { join } from 'path';


const urlSlugsReplacetable: Record<string, string> = {
  "ą": "a",
  "ę": "e",
  "ś": "s",
  "ć": "c",
  "ó": "o",
  "ń": "n",
  "ź": "z",
  "ż": "z",
  "ł": "l",
  "'": "",
  "\"": "",
  "---": "-",
  "\u2014": "-",
  "\u2013": "-",
  "[": "",
  "]": ""
}

const contentDir = "content"

for (const file of getAllDirs(contentDir)) {
  let newName = file.normalize().toLocaleLowerCase().replaceAll(" ", "-")
  for (const slugPart of Object.keys(urlSlugsReplacetable)) {
    newName = newName.replaceAll(slugPart, urlSlugsReplacetable[slugPart])
  }
  fs.renameSync(file, newName)
}

function getAllDirs(dirPath: string, arrayOfFiles_?: string[]) {
  const files = readdirSync(dirPath);

  let arrayOfFiles = arrayOfFiles_ || []

  files.forEach(function (file: string) {
    if (statSync(dirPath + "/" + file).isDirectory()) {
      arrayOfFiles.push(join(dirPath, "/", file))
      arrayOfFiles = getAllDirs(dirPath + "/" + file, arrayOfFiles)
    }
  })

  return arrayOfFiles
}
