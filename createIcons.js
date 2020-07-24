const path = require('path');
const { exec } = require('child_process');
const fs = require('fs');
const dom = require('cheerio');

const svgToObj = (dir, destination) => {
    const $ = dom.load(
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="0" height="0" style="display:none;"></svg>'
    );

    const parse = (file) => {
        if (path.extname(file) !== '.svg') {
            return;
        }

        let fileName = file.slice(0, -4);
        let fileContent = fs.readFileSync(path.join(dir, file), 'utf8');
        let svgNode = $(fileContent);

        let $symbol = $('<symbol></symbol>');
        $symbol.attr('viewBox', svgNode.attr('viewBox'));
        $symbol.attr('id', 'icon-' + fileName);
        $symbol.append(svgNode.contents());

        $('svg').append($symbol);
    };

    fs.readdir(dir, function (err, files) {
        files.forEach(parse);

        const output = $('svg').parent().html();
        fs.writeFileSync(destination, output);
    });
};

const source = path.resolve(__dirname, './src/svg');
const destination = path.resolve(__dirname, './assets/images/icon-map.svg');

const svgoBin = path.resolve(__dirname, './node_modules/svgo/bin/svgo');
const svgoConf = path.resolve(__dirname, './svgo.json');

console.log(`Start compiling SVG icons from ${source} to ${destination}`);

exec(`${svgoBin} ${source} --config=${svgoConf}`, function () {
    svgToObj(source, destination);
});
