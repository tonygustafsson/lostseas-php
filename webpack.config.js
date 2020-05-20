const path = require('path');

const mode = 'development';
const watch = true;

module.exports = [
    {
        name: 'game',
        entry: './src/js/main.js',
        mode: mode,
        watch: watch,
        output: {
            filename: 'main.js',
            path: path.resolve(__dirname, 'assets', 'js'),
        },
        module: {
            rules: [
                {
                    test: /.js$/,
                    exclude: /node_modules/,
                    use: ['babel-loader'],
                },
            ],
        },
        plugins: [],
    },
];
