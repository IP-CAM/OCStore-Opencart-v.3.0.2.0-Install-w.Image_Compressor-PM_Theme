const gulp = require('gulp');
const plumber = require('gulp-plumber');
const uglify = require('gulp-uglify-es').default;
const flatten = require('gulp-flatten');
// const concat = require('gulp-concat');
// const rename = require('gulp-rename');


function makeJs(TEMPLATE_PATH) {
  return gulp.src('source_frontend/**/*.js')
    .pipe(flatten())
    .pipe(plumber())
    // .pipe(concat('script.js'))
    .pipe(uglify())
    // .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(TEMPLATE_PATH + '/js'));
}


module.exports = makeJs;
