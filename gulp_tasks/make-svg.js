const gulp = require('gulp');
const imagemin = require('gulp-imagemin');


function makeSvg (TEMPLATE_PATH) {
  return gulp.src([
    'source_frontend/img/svg/others/**/*.svg'
  ])
    .pipe(imagemin([
      imagemin.svgo({
        plugins: [{
          removeViewBox: false
        },
        {
          cleanupNumericValues: {
            floatPrecision: 1
          }
        },
        {
          convertPathData: {
            floatPrecision: 1
          }
        },
        {
          cleanupListOfValues: {
            floatPrecision: 1
          }
        }
        ]
      })
    ]))
    .pipe(gulp.dest(TEMPLATE_PATH + '/img/svg'));
}


module.exports = makeSvg;
