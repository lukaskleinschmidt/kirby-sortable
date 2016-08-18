var gulp    = require('gulp');
var webpack = require('gulp-webpack');
var uglify  = require('gulp-uglify');
var cssmin  = require('gulp-cssmin');
var sass    = require('gulp-sass');

gulp.task('scripts', function() {
  return gulp.src('assets/js/src/modules.js')
    .pipe(webpack({
      output: {
        filename: 'modules.js'
      },
      module: {
        loaders: [
          {
            test: /\.jsx?$/,
            loader: 'babel',
            exclude: /node_modules/,
            query: {
              presets: ['es2015']
            }
          }
        ]
      }
    }))
    // .pipe(uglify())
    .pipe(gulp.dest('assets/js/dist'));
});

gulp.task('styles', function() {
  return gulp.src('assets/scss/modules.scss')
    .pipe(sass().on('error', sass.logError)) 
    .pipe(cssmin())
    .pipe(gulp.dest('assets/css'));
});

gulp.task('form-css', function() {
  return gulp.src('app/fields/*/assets/css/*.css')
    .pipe(concat('form.css'))
    .pipe(gulp.dest('assets/css'))
    .pipe(rename('form.min.css'))
    .pipe(cssmin())
    .pipe(gulp.dest('assets/css'));
});

gulp.task('watch', function() {
  gulp.watch('assets/scss/**/*.scss', ['styles']);
  gulp.watch('assets/js/src/**/*.js', ['scripts']);
});

gulp.task('default', [
  'scripts',
  'styles'
]);