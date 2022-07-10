import { readdirSync, statSync } from 'fs';
import { join } from 'path';


export const getAllFiles = function (dirPath: string, arrayOfFiles_?: string[]) {
  const files = readdirSync(dirPath);

  let arrayOfFiles = arrayOfFiles_ || []

  files.forEach(function (file: string) {
    if (statSync(dirPath + "/" + file).isDirectory()) {
      arrayOfFiles = getAllFiles(dirPath + "/" + file, arrayOfFiles)
    } else {
      arrayOfFiles.push(join(dirPath, "/", file))
    }
  })

  return arrayOfFiles
}
