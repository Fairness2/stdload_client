/**
 * Gulp plugin
 */
var gulp         = require("gulp"),
    iconfont = require('gulp-iconfont'),
    iconfontCss = require('gulp-iconfont-css'),
    clean = require('gulp-clean');

/**
 * Config path
 */
var path = {

    build: {
        font: {
            action: './src/assets/icons/build/action',
            categories: './src/assets/icons/build/categories',
        }
    },

    src: {
        svg: {
            action: './src/assets/icons/original/action/*.svg',
            categories: './src/assets/icons/original/categories/*.svg',
        }
    }
};

/**
 * Config version font
 */
var version = Date.now();


/**
 * Config icons generation
 */
function configIcon(type) {
    return {
        fontName: type,
        formats: ['ttf', 'eot', 'woff', 'woff2', 'svg'],
        prependUnicode: true,
        normalize: true,
        fontHeight: 1001,
        timestamp: Math.round(Date.now()/1000)
    };
}


/**
 * Removes files in folders
 */
function removesOldFont(type) {
    gulp.src(type,
        {read: false})
        .pipe(clean());
}

/**
 * Generation icons categories
 */
gulp.task('iconCat', function(){

    removesOldFont(path.build.font.categories);

    gulp.src([path.src.svg.categories])
        .pipe(iconfontCss({
            fontName: 'categories_'+version+'',
            cssClass: 'icon-categories',
            targetPath: '../../../sass/base/icons-categories.scss',
            fontPath: '../../icons/build/categories/'
        }))
        .pipe(iconfont(configIcon('categories_'+version+'')))
        .pipe(gulp.dest(path.build.font.categories))
        .on('end', function() {
            gulp.src(path.build.font.categories+'/*');
        });
});


/**
 * Generation icons action
 */
gulp.task('iconAction', function(){

    removesOldFont(path.build.font.action);

    gulp.src([path.src.svg.action])
        .pipe(iconfontCss({
            fontName: 'action_'+version+'',
            cssClass: 'icon-action',
            targetPath: '../../../sass/base/icons-action.scss',
            fontPath: '../../icons/build/action/'
        }))
        .pipe(iconfont(configIcon('action_'+version+'')))
        .pipe(gulp.dest(path.build.font.action))
        .on('end', function() {
            gulp.src(path.build.font.action+'/*');
        });
});