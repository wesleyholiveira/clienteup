'use strict';

const gulp = require('gulp');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const cleanCSS = require('gulp-clean-css');
const htmlMin = require('gulp-htmlmin');
const imageMin = require('gulp-image-optimization');
const inline = require('gulp-minify-inline');
const browserSync = require('browser-sync').create();
const reload = browserSync.reload;

gulp.task('browserSync', () => {
	browserSync.init({
		server: {
			baseDir: '../../../'
		}
	});
});

gulp.task('minJS', () => {
	console.log('Minificando JS');
	return	gulp.src(['js/app/**/*.js', 'js/vendor/bootstrap/collapse.js'])
			.pipe(plumber())
			.pipe(concat('main.min.js'))
			.pipe(uglify())
			.pipe(gulp.dest('js/dist'))
			.pipe(browserSync.reload({stream: true}));

});

gulp.task('devJS', () => {
	return	gulp.src(['js/app/**/*.js', 'js/vendor/bootstrap/collapse.js'])
			.pipe(plumber())
			.pipe(concat('main.js'))
			.pipe(gulp.dest('js'));

});

gulp.task('minCSS', () => {
	console.log('Minificando CSS');
	return	gulp.src('sass/**/**/*.scss')
			.pipe(sass().on('error', (err) => console.log(err.formatted)))
			.pipe(concat('main.min.css'))
			.pipe(cleanCSS())
			.pipe(gulp.dest('css/dist'))
			.pipe(browserSync.reload({stream: true}));
});

gulp.task('devCSS', () => {
	return	gulp.src('sass/**/**/*.scss')
			.pipe(sass().on('error', (err) => console.log(err.formatted)))
			.pipe(concat('main.css'))
			.pipe(gulp.dest('css'));
});

gulp.task('minHTML', () => {
	console.log('Minificando HTML');
	return	gulp.src('../../index-dev.html')
			.pipe(htmlMin({collapseWhitespace: true}).on('error', (err) => console.log(err)))
			.pipe(inline())
			.pipe(concat('index2.html'))
			.pipe(gulp.dest('../../../'))
			.pipe(browserSync.reload({stream: true}));
});

gulp.task('minImg', () => {
	console.log('Minificando Imagens');
	return	gulp.src('img/*')
			.pipe(imageMin({
				optimizationLevel: 5,
		        progressive: true,
		        interlaced: true
			}).on('error', (err) => console.log(err)))
			.pipe(gulp.dest('img/dist'));

});

gulp.task('watch', ['browserSync'], () => {
	gulp.watch('../../../View/app/js/app/**/*.js', ['minJS', 'devJS']);
	gulp.watch('../../../View/app/sass/**/**/*.scss', ['minCSS', 'devCSS']);
	gulp.watch('../../../index-dev.html', ['minHTML'])
});
