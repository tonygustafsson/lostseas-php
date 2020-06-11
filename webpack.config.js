const path = require('path');

const mode = 'development';
const watch = true;

module.exports = [
    {
        name: 'scripts',
        entry: './src/js/main.js',
        mode: mode,
        watch: watch,
        output: {
            filename: 'main.js',
            path: path.resolve(__dirname, 'assets', 'js')
        },
        plugins: []
    },
    {
        name: 'styles',
        entry: './src/scss/main.scss',
        mode: mode,
        watch: watch,
        output: {
            filename: 'styles.js',
            path: path.resolve(__dirname, 'assets', 'js')
        },
        module: {
            rules: [
                {
                    test: /\.s[ac]ss$/i,
                    use: ['style-loader', 'css-loader', 'sass-loader']
                },
                {
                    test: /\.(png|jpe?g|gif|otf|svg|eot|woff|ttf)$/i,
                    loader: 'file-loader',
                    options: {
                        name: '[path][name].[ext]'
                    }
                }
            ]
        },
        plugins: []
    }
];
