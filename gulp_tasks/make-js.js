const gulp = require('gulp');
const plumber = require('gulp-plumber');
const webpack = require('webpack-stream');
const CircularDependencyPlugin = require('circular-dependency-plugin');
const DuplicatePackageCheckerPlugin = require('duplicate-package-checker-webpack-plugin');

const isDev = true;

const webpackConfig = {
  mode: isDev ? 'development' : 'production',
  output: {
    filename: 'script.js'
  },
  watch: false,
  devtool: isDev ? 'eval-source-map' : 'none',
  module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [['@babel/preset-env', {
              debug: true,
              corejs: 3,
              useBuiltIns: 'usage'
            }]]
          }
        }
      }
    ]
  },
  plugins: [
    new CircularDependencyPlugin(),
    new DuplicatePackageCheckerPlugin()
  ]
};

function makeJs(server, TEMPLATE_PATH) {
  return gulp.src('source_frontend/js/index.js')
    .pipe(plumber())
    .pipe(webpack(webpackConfig))
    .pipe(gulp.dest(TEMPLATE_PATH + '/js'))
    .pipe(server.stream());
}


module.exports = makeJs;
