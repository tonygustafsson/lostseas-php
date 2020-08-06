const path = require('path');

const mode = 'development';
const watch = true;

console.log(`Building JS in ${mode} mode.`);

module.exports = [
    {
        name: 'scripts',
        entry: './src/js/main.js',
        mode: mode,
        watch: watch,
        watchOptions: {
            ignored: /node_modules/,
            poll: 500
        },
        output: {
            filename: 'main.js',
            path: path.resolve(__dirname, 'assets', 'js')
        },
        module: {
            rules: [
                {
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                [
                                    '@babel/preset-env',
                                    {
                                        targets: {
                                            chrome: '80',
                                            edge: '80',
                                            firefox: '75',
                                            safari: '13'
                                        }
                                    }
                                ]
                            ]
                        }
                    }
                }
            ]
        },
        stats: {
            entrypoints: false,
            modules: false
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
                    test: /\.(png|jpe?g|gif|otf|svg|eot|woff|woff2|ttf)$/i,
                    loader: 'file-loader',
                    options: {
                        emitFile: false,
                        publicPath: '/',
                        name: '[path][name].[ext]'
                    }
                }
            ]
        },
        plugins: []
    }
];
