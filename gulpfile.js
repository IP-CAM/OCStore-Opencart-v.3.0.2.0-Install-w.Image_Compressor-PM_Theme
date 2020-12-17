const TEMPLATE_PATH = 'public_html/catalog/view/theme/pm';

const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const del = require('del');
const makeCSS = require('./gulp_tasks/make-css').bind(null, browserSync, TEMPLATE_PATH);
const createSvgSprite = require('./gulp_tasks/create-svg-sprite').bind(null, TEMPLATE_PATH);
const makeSvg = require('./gulp_tasks/make-svg').bind(null, TEMPLATE_PATH);
const makeJs = require('./gulp_tasks/make-js').bind(null, TEMPLATE_PATH);


function clean() {
  return del([
    TEMPLATE_PATH + '/css',
    TEMPLATE_PATH + '/js',
    TEMPLATE_PATH + '/fonts',
    TEMPLATE_PATH + '/img'
  ]);
}


function copyFonts() {
  return gulp.src('source_frontend/fonts/*.{woff,woff2}')
    .pipe(gulp.dest(TEMPLATE_PATH + '/fonts'));
}


function copyFavicon() {
  return gulp.src('source_frontend/img/favicon/**')
    .pipe(gulp.dest(TEMPLATE_PATH + '/img/favicon'));
}



const build = gulp.parallel(
  copyFonts,
  copyFavicon,
  makeCSS,
  createSvgSprite,
  makeSvg,
  makeJs
);


function reload(done) {
  browserSync.reload();
  done();
}



function server() {
  browserSync.init({
    proxy: 'pm',
    notify: false,
    cors: true,
    ui: false
  });

  gulp.watch('source_frontend/sass/**/*.scss', makeCSS);
  gulp.watch('source_frontend/img/svg/sprited/**/*.svg', createSvgSprite);
  gulp.watch('source_frontend/img/svg/others/**/*.svg', makeSvg);
  gulp.watch('source_frontend/fonts/**', copyFonts);
  gulp.watch('source_frontend/img/favicon/**', copyFavicon);
  gulp.watch(TEMPLATE_PATH + '/template/**/*.twig', reload);
  gulp.watch('source_frontend/**/*.js', gulp.series(makeJs, reload));
}



module.exports.server = server;
module.exports.default = server;
module.exports.build = gulp.series(clean, build);
module.exports.start = gulp.series(clean, build, server);
module.exports.js = makeJs;
module.exports.css = makeCSS;


// module.exports.deploy = deploy;
