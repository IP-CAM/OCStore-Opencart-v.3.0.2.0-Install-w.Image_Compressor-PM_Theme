const gulp = require('gulp');
const plumber = require('gulp-plumber');
// const sourcemap = require('gulp-sourcemaps');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const csso = require('gulp-csso');
const rename = require('gulp-rename');


function makeCSS (server, TEMPLATE_PATH) {
  return gulp.src('source_frontend/sass/style.scss')
    .pipe(plumber())
    // .pipe(sourcemap.init())
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(csso())
    .pipe(rename({ suffix: '.min' }))
    // .pipe(sourcemap.write('.'))
    .pipe(gulp.dest(TEMPLATE_PATH + '/stylesheet'))
    .pipe(server.stream());
}


module.exports = makeCSS;
