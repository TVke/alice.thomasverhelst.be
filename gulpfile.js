const gulp = require("gulp");
const tailwindcss = require('tailwindcss');
const postcss = require('gulp-postcss');
const purgecss = require('gulp-purgecss');
const babel = require("gulp-babel");
const uglify = require("gulp-uglify");
const imagemin = require('gulp-imagemin');

gulp.task('default', ['css', 'js']);
gulp.task('watch', ['css:watch','js:watch','tailwind:watch']);
gulp.task('update', ['css','js','image','favicon','font']);
gulp.task('prod', ['css','js','image','favicon','font','purge']);



/* css: postCSS + tailwindCSS + CSSnext + CSSnano */
gulp.task('css',function(){
    return gulp.src('resources/assets/css/**/*.css')
        .pipe(postcss([
            require("postcss-import")(),
            tailwindcss('./tailwind.js'),
            require("postcss-cssnext")(),
            require("postcss-for")(),
            require("cssnano")({ autoprefixer: false }),
        ]))
        .pipe(gulp.dest('public/css'));
});
gulp.task('css:watch', function () {
    gulp.watch('resources/assets/css/**/*.css', ['css']);
});
gulp.task('tailwind:watch', function () {
    gulp.watch('tailwind.js', ['css']);
});



/* JS: babel + uglify */
gulp.task("js", function () {
    return gulp.src("resources/assets/js/**/*.js")
        .pipe(babel())
        .pipe(uglify())
        .pipe(gulp.dest("public/js"));
});
gulp.task('js:watch', function () {
    gulp.watch('resources/assets/js/**/*.js', ['js']);
});



/* IMG: imagemin */
gulp.task('image', function () {
    return gulp.src('resources/assets/img/**/*')
        .pipe(imagemin({progressive: true}))
        .pipe(gulp.dest('public/img'));
});



/* FIVICON: imagemin */
gulp.task('favicon', function () {
    return gulp.src('resources/assets/favicon/*')
        .pipe(imagemin({progressive: true}))
        .pipe(gulp.dest('public'));
});



/* FONT: imagemin */
gulp.task('font', function () {
    return gulp.src('resources/assets/font/*')
        .pipe(gulp.dest('public/font'));
});



/* PURGE: purgeCSS */
gulp.task('purge', () => {
    return gulp
        .src('public/css/app.css')
        .pipe(purgecss({
            content: ['storage/framework/views/*.php']
        }))
        .pipe(gulp.dest('public/css'));
});