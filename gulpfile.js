const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass')); // Use the 'sass' compiler
const purgecss = require('gulp-purgecss');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

// Path configuration
const paths = {
  scss: 'Src/public/sass/**/*.scss', // Adjust path to match your source SCSS files
  cssDest: 'Src/public/assets/css',  // Path where compiled CSS will go
  html: 'Src/App/Views/**/*.php',    // Path to PHP files where CSS will be purged
};

// Compile SCSS to CSS
gulp.task('sass', () => {
  return gulp.src(paths.scss)
    .pipe(sass().on('error', sass.logError)) // Compile SCSS files
    .pipe(gulp.dest(paths.cssDest));        // Save compiled CSS to the destination
});

// Minify CSS and purge unused styles
gulp.task('purgecss', () => {
  return gulp.src(`${paths.cssDest}/**/*.css`)   // Read all compiled CSS files
    .pipe(purgecss({
      content: [paths.html],                    // Purge CSS based on PHP files
    }))
    .pipe(cleanCSS())                           // Minify CSS
    .pipe(rename({ suffix: '.min' }))           // Rename the file to `.min.css`
    .pipe(gulp.dest(paths.cssDest));            // Save the minified file
});

// Watch for changes in SCSS files
gulp.task('watch', () => {
  gulp.watch(paths.scss, gulp.series('sass', 'purgecss')); // Watch SCSS and run tasks
});

// Default task
gulp.task('default', gulp.series('sass', 'purgecss', 'watch'));
