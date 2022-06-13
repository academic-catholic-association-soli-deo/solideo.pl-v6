"use strict";
exports.__esModule = true;
exports.getAllFiles = void 0;
var fs_1 = require("fs");
var path_1 = require("path");
var getAllFiles = function (dirPath, arrayOfFiles) {
    var files = (0, fs_1.readdirSync)(dirPath);
    arrayOfFiles = arrayOfFiles || [];
    files.forEach(function (file) {
        if ((0, fs_1.statSync)(dirPath + "/" + file).isDirectory()) {
            arrayOfFiles = (0, exports.getAllFiles)(dirPath + "/" + file, arrayOfFiles);
        }
        else {
            arrayOfFiles.push((0, path_1.join)(dirPath, "/", file));
        }
    });
    return arrayOfFiles;
};
exports.getAllFiles = getAllFiles;
