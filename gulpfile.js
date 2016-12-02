var gulp         = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var webpack      = require('gulp-webpack');
var uglify       = require('gulp-uglify');
var cssmin       = require('gulp-cssmin');
var sass         = require('gulp-sass');

gulp.task('scripts', function() {
  return gulp.src('fields/modules/resources/scripts/modules.js')
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
    .pipe(uglify())
    .pipe(gulp.dest('fields/modules/assets/js'));
});

gulp.task('styles', function() {
  return gulp.src('fields/modules/resources/styles/modules.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer(['last 4 versions']))
    .pipe(cssmin())
    .pipe(gulp.dest('fields/modules/assets/css'));
});

gulp.task('watch', function() {
  gulp.watch('fields/modules/resources/styles/**/*.scss', ['styles']);
  gulp.watch('fields/modules/resources/scripts/**/*.js', ['scripts']);
});

gulp.task('default', [
  'scripts',
  'styles'
]);
