'use strict'

const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const browserSync = require('browser-sync').create();
const postcss = require('gulp-postcss');
const touch = require('gulp-touch-fd');
const autoprefixer = require('autoprefixer');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const rollup = require('gulp-better-rollup');
const babel = require('rollup-plugin-babel');
const resolve = require('@rollup/plugin-node-resolve');
const commonjs = require('@rollup/plugin-commonjs');
const terser = require('gulp-terser-js');
const rename = require('gulp-rename');
const del = require('del');
const concat = require('gulp-concat');
const zip = require('gulp-zip');

var cfg = {
    "browserSyncOptions": {
        "proxy": "https://brimo.local",
        "notify": false
    },
    "browserSyncWatchFiles": [
        "./css/*.css",
        "./js/*.js",
        "./**/*.php"
    ],
    "paths": {
        "js": "./js",
        "css": "./",
        "fonts": "./fonts",
        "node": "./node_modules",
        "dev": "./src",
        "devscss": "./src/scss",
        "devjs": "./src/js",
        "devfonts": "./src/fonts",
        "dist": "./dist",
        "distcss": "./dist/",
        "distjs": "./dist/js"
    }
}

let paths = cfg.paths;

gulp.task('scripts', function () {
    return gulp
        .src(paths.devjs + '/scripts.js')
        .pipe(rollup({ plugins: [babel(), resolve(), commonjs()] }, 'umd'))
        .pipe(gulp.dest(paths.js))
        .pipe(touch())
        .pipe(browserSync.stream());
});

gulp.task('yall', function () {
    return gulp
        .src(paths.devjs + '/jquery.lazymap.js')
        .pipe(rollup({ plugins: [babel(), resolve(), commonjs()] }, 'umd'))
        .pipe(gulp.dest(paths.js))
});
    // compile scss into css

gulp.task('styles', function () {
    // plugins to run with gulp-postcss
    let plugins = [autoprefixer()]

    return gulp
        .src(paths.devscss + '/style.scss')
        .pipe(sass().on('error',sass.logError))
        .pipe(postcss(plugins))
        .pipe(gulp.dest(paths.css))
        .pipe(touch())
        .pipe(browserSync.stream());
});

gulp.task('woocommerce', function () {
    // plugins to run with gulp-postcss
    let plugins = [autoprefixer()]

    return gulp
        .src(paths.devscss + '/woocommerce.scss')
        .pipe(sass().on('error',sass.logError))
        .pipe(postcss(plugins))
        .pipe(gulp.dest(paths.css))
        .pipe(touch())
        .pipe(browserSync.stream());
});

gulp.task('fonts', function () {
    return gulp
        .src(paths.devfonts + '/**/*.{eot,svg,ttf,woff,woff2}')
        .pipe(gulp.dest(paths.fonts));
});

gulp.task('assets-js', function () {
    return gulp
        .src(paths.devjs + '/customizer.js')
        .pipe(gulp.dest(paths.distjs));
});

gulp.task('minify-css', function () {
    return gulp
        .src(paths.css + 'style.css')
        .pipe(sourcemaps.init ({ loadMaps: true }))
        .pipe(cleanCSS({compability: 'ie8', debug: true}))
        .pipe(concat('style.css'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(paths.css))
        .pipe(touch());
});

gulp.task('dist-css', function () {
    // plugins to run with gulp-postcss
    let plugins = [autoprefixer()]

    return gulp
        .src(paths.devscss + '/style.scss')
        .pipe(sass().on('error',sass.logError))
        .pipe(postcss(plugins))
        .pipe(cleanCSS({compability: 'ie8', debug: true}))
        .pipe(concat('style.css'))
        .pipe(gulp.dest(paths.distcss))
        .pipe(touch())
});

gulp.task('minify-woo', function () {
    return gulp
        .src(paths.css + 'woocommerce.css')
        .pipe(sourcemaps.init ({ loadMaps: true }))
        .pipe(cleanCSS({compability: 'ie8', debug: true}))
        .pipe(concat('woocommerce.css'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(paths.css))
        .pipe(touch());
});

gulp.task('dist-woo', function () {
    // plugins to run with gulp-postcss
    let plugins = [autoprefixer()]

    return gulp
        .src(paths.devscss + '/woocommerce.scss')
        .pipe(sass().on('error',sass.logError))
        .pipe(postcss(plugins))
        .pipe(cleanCSS({compability: 'ie8', debug: true}))
        .pipe(concat('woocommerce.css'))
        .pipe(gulp.dest(paths.distcss))
        .pipe(touch())
});

gulp.task('minify-js', function () {
    return gulp
        .src(paths.js + '/scripts.js')
        .pipe(sourcemaps.init())
        .pipe(terser({
            mangle: {
                toplevel: true
            }
        }))
        .on('error', function (error) {
            this.emit('end')
        })
        .pipe(rename('scripts.min.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(paths.js))
        .pipe(touch());
});

gulp.task('dist-js', function () {
    return gulp
        .src(paths.devjs + '/scripts.js')
        .pipe(rollup({ plugins: [babel(), resolve(), commonjs()] }, 'umd'))
        .pipe(terser({
            mangle: {
                toplevel: true
            }
        }))
        .on('error', function (error) {
            this.emit('end')
        })
        .pipe(rename('scripts.min.js'))
        .pipe(gulp.dest(paths.distjs))
        .pipe(touch());
});

gulp.task('serve', function (done) {
    browserSync.init(
        cfg.browserSyncWatchFiles,
        cfg.browserSyncOptions);
    done();
});

gulp.task('monitor', function () {
    gulp.watch([
        paths.devscss + '/**/*.scss',
        paths.devscss + '*.scss'],
        gulp.series('styles', 'woocommerce')
        //gulp.series('styles', 'minify-css')
    );
    gulp.watch([
        paths.devjs + '/*.js',
        paths.devjs + '/**/*.js'],
        gulp.series('scripts', 'minify-js')
    );

    gulp.series('reload');

});

gulp.task('reload', function (done) {
    browserSync.reload();
    done();
});

gulp.task('clean-dist', function () {
    return del([paths.dist + '/**']);
});

gulp.task('move-to-dist', function () {
    return gulp
        .src(['*','**/*'], { ignore: [
            `${paths.node}`,
            `${paths.node}/**`,
            `${paths.dev}`,
            `${paths.dev}/**`,
            `${paths.dist}`,
            `${paths.dist}/**`,
            `${paths.src}`,
            `${paths.src}/**`,
            'readme.txt',
            'readme.md',
            'phpcs.xml.dist',
            'package.json',
            'package-lock.json',
            'gulpfile.js',
            'style.css',
            '/js/scripts.min.js',
            'wp-brimo-theme.sublime*'
        ]})
        .pipe(gulp.dest(paths.dist))
});

gulp.task('pack', function () {
    return gulp.src([paths.dist + '/**'])
        .pipe(zip('wp-brimo-theme.zip'))
        .pipe(gulp.dest(paths.dist))
});

gulp.task('lint-css', function lintCssTask() {
  const gulpStylelint = require('gulp-stylelint');

  return gulp
    .src('src/scss/theme.*')
    .pipe(gulpStylelint({
      reporters: [
        {formatter: 'string', console: true}
      ]
    }));
});

gulp.task('dist', gulp.series('clean-dist', 'move-to-dist'));

gulp.task('watch', gulp.parallel('serve', 'monitor'));
gulp.task('build', gulp.series('styles', 'scripts', 'fonts'));
gulp.task('minify-dist', gulp.series('dist-css', 'dist-js', 'dist-woo','assets-js'));
gulp.task('minify', gulp.series('minify-css', 'minify-js', 'minify-woo'));
gulp.task('push', gulp.series('build', 'dist', 'minify-dist', 'pack'));

