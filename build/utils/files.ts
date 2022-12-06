import * as fs from 'fs';
import * as path from 'path';

export function getChildFiles(dirPath: string) {
  const files = fs.readdirSync(dirPath);
  return files.filter(file => {
    const fullPath = path.join(dirPath, file)
    return fs.statSync(fullPath).isFile()
  }).map(filename => path.join(dirPath, filename))
}

export function cleanTargetDirectory(targetDir: string) {
  if (fs.existsSync(targetDir)) fs.rmSync(targetDir, { recursive: true });
  fs.mkdirSync(targetDir, { recursive: true });
}

export function makePath(file: string) {
  fs.mkdirSync(path.dirname(file), { recursive: true });
}

export function hasSubdirectories(dir: string) {
  for (const childFile of fs.readdirSync(dir)) {
    if (fs.statSync(path.join(dir, childFile)).isDirectory()) {
      return true
    }
  }
  return false
}

export function getParentDirectory(file: string) {
  return path.dirname(file)
}

export function transposePath(
  filepath: string,
  { sourceDir, targetDir, extension }: { sourceDir: string, targetDir: string, extension?: string }
) {
  const sourceDirResolved = path.resolve(sourceDir)
  const targetDirResolved = path.resolve(targetDir)
  const filepathResolved = path.resolve(filepath)
  const destPath = path.join(targetDirResolved, path.relative(sourceDirResolved, filepathResolved));
  if (extension) {
    return destPath.replaceAll(/\.[a-zA-Z0-9]+$/gmi, '.' + extension)
  }
  return destPath
}

export function copyFile(fromFile: string, toFile: string) {
  return fs.cpSync(fromFile, toFile);
}


export function writeFile({ file, contents }: { file: string, contents: string }) {
  fs.writeFileSync(file, contents)
}
