"use strict";
exports.__esModule = true;
var fs_1 = require("fs");
var build_react_1 = require("./build-react");
var recurisve_direcotry_listing_1 = require("./utils/recurisve-direcotry-listing");
var path = require("path");
fs_1["default"].rmSync('./public', { recursive: true });
fs_1["default"].mkdirSync('./public', { recursive: true });
var filesArr = (0, recurisve_direcotry_listing_1.getAllFiles)('./content', []);
for (var _i = 0, filesArr_1 = filesArr; _i < filesArr_1.length; _i++) {
    var file = filesArr_1[_i];
    var destinationPath = path.join('public', path.relative('content', file));
    fs_1["default"].mkdirSync(path.dirname(destinationPath), { recursive: true });
    if (/\.md$/.test(file)) {
        var markdownContent = fs_1["default"].readFileSync(file, 'utf8');
        var htmlContent = (0, build_react_1.markdownToHtml)(markdownContent);
        fs_1["default"].writeFileSync(destinationPath, htmlContent, 'utf8');
    }
    else {
        fs_1["default"].cpSync(file, destinationPath);
    }
}
