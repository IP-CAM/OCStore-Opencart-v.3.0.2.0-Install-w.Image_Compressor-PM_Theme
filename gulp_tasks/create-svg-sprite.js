const gulp = require('gulp');
const gulpMerge = require('gulp-merge');
const cheerio = require('gulp-cheerio');
const imagemin = require('gulp-imagemin');
const svgsprite = require('gulp-svg-sprite');


function createSvgSprite(TEMPLATE_PATH) {
  /* В одноцветных иконках, которым надо менять цвет в css,
  необходимо удалить атрибуты fill, style и, возможно, stroke
  Иконки, которым надо менять два цвета или вообще не изменять цвета
  удаление атрибутов необходимо делать вручную при необходимости.
  После удаления автоматического удаления атрибутов потоки сливаются */
  return gulpMerge(
    gulp.src('source_frontend/img/svg/sprited/remove-attr/**/*.svg')
      .pipe(cheerio({
        run: function ($) {
          $('[fill]').removeAttr('fill');
          $('[style]').removeAttr('style');
        },
        parserOptions: {
          xmlMode: true
        }
      })),
    gulp.src('source_frontend/img/svg/sprited/as-is/**/*.svg'))
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
    .pipe(svgsprite({
      mode: {
        symbol: {
          sprite: '_sprite.svg',
          dest: '.'
        }
      }
    }))
    .pipe(gulp.dest(TEMPLATE_PATH + '/img/svg'));
}

module.exports = createSvgSprite;
