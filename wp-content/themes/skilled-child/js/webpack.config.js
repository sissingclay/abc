const path = require('path')
const src = {
  'input': path.resolve(__dirname, `./src/`)
}

process.env.UV_THREADPOOL_SIZE = 100

const config = {
  entry: {
    './abc-cart': `${src.input}/entry`
  },

  output: {
    filename: '[name].min.js' // string
  },

  module: {
    // configuration regarding modules

    rules: [
      // rules for modules (configure loaders, parser options, etc.)
      {
        test: /\.html$/,
        loader: 'raw-loader',
        exclude: [
          path.resolve(__dirname, 'node_modules')
        ]
      },

      {
        test: /\.js?$/,
        exclude: [
          path.resolve(__dirname, 'node_modules')
        ],
        loader: 'babel-loader',
        options: {
          presets: ['es2015'],
          cacheDirectory: true,
          compact: true
        }
      },
      {
        test: /\.ts?$/,
        exclude: [
          path.resolve(__dirname, 'node_modules')
        ],
        loaders: ['ts-loader']
      }
    ]
    /* Advanced module configuration (click to show) */
  },

  resolve: {
    extensions: ['.js', '.ts']
  },

  devtool: 'cheap-module-source-map',

  context: __dirname
}

module.exports = config
