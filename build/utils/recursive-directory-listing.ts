import { readdirSync, statSync } from 'fs';
import { join } from 'path';


export const getDirsRecursive = function (dirPath: string, arrayOfFiles_?: string[]) {
  const files = readdirSync(dirPath);

  let arrayOfFiles = arrayOfFiles_ || []

  files.forEach(function (file: string) {
    if (statSync(dirPath + "/" + file).isDirectory()) {
      arrayOfFiles.push(join(dirPath, "/", file))
      arrayOfFiles = getDirsRecursive(dirPath + "/" + file, arrayOfFiles)
    }
  })

  return arrayOfFiles
}

