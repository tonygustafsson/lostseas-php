const fs = require('fs-extra');
const path = require('path');
const { exec } = require('child_process');

// Path settings
const distFolder = path.join(__dirname, '..', 'dist');
const webpackConfFile = path.join(__dirname, '..', 'webpack.config.build.js');
const configPhpFileSrc = path.join(__dirname, 'config', 'config.php');
const configPhpFileDest = path.join(__dirname, '..', 'dist', 'application', 'config', 'config.php');
const databasePhpFileSrc = path.join(__dirname, 'config', 'database.php');
const databasePhpFileDest = path.join(__dirname, '..', 'dist', 'application', 'config', 'database.php');

const rootDirsToCopy = ['application', 'system', 'assets'];

const rootFilesToCopy = [
    '.htaccess',
    'googleba12a4206fcbec0e.html',
    'index.php',
    'offline.html',
    'robots.txt',
    'serviceWorker.js',
    'site.webmanifest'
];

// Create a new empty folder ./dist
fs.rmdirSync(`${distFolder}`, { recursive: true });
fs.mkdirSync(distFolder);

// Copy folders
rootDirsToCopy.forEach((dir) => {
    const dirSrc = path.join(__dirname, '..', dir);
    const dirDest = path.join(__dirname, '..', 'dist', dir);

    fs.copySync(dirSrc, dirDest);
});

console.log('Copied folders to ./dist');

// Copy root files
rootFilesToCopy.forEach((file) => {
    const fileSrc = path.join(__dirname, '..', file);
    const fileDest = path.join(__dirname, '..', 'dist', file);

    fs.copyFileSync(fileSrc, fileDest);
});

console.log('Copied root files to ./dist');

// Replace config files with build configs
console.log('Replacing config files with files from ./config');
fs.copyFileSync(configPhpFileSrc, configPhpFileDest);
fs.copyFileSync(databasePhpFileSrc, databasePhpFileDest);

console.log('Built application to ./dist');

// Build JS and SCSS to dist
exec(`webpack --config ${webpackConfFile}`);

console.log('Built JS/SCSS to ./dist');
console.log('Done.');
