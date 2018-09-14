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
            action: './src/assets/icons/build/icon-action',
            categories: './src/assets/icons/build/icon-categories',
        }
    },

    src: {
        svg: {
            action: './src/assets/icons/original/icon-action/*.svg',
            categories: './src/assets/icons/original/icon-categories/*.svg',
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
            fontName: 'icon-categories_'+version+'',
            cssClass: 'icon-categories',
            targetPath: '../../../sass/base/icon-categories.scss',
            fontPath: '../../icons/build/icon-categories/'
        }))
        .pipe(iconfont(configIcon('icon-categories_'+version+'')))
        .pipe(gulp.dest(path.build.font.categories))
        .on('end', function() {
            gulp.src(path.build.font.categories + '/*');
        });
});

gulp.task('iconAction', function(){

    removesOldFont(path.build.font.action);

    gulp.src([path.src.svg.action])
        .pipe(iconfontCss({
            fontName: 'icon-action_'+version+'',
            cssClass: 'icon-action',
            targetPath: '../../../sass/base/icon-action.scss',
            fontPath: '../../icons/build/icon-action/'
        }))
        .pipe(iconfont(configIcon('icon-action_'+version+'')))
        .pipe(gulp.dest(path.build.font.action))
        .on('end', function() {
            gulp.src(path.build.font.action + '/*');
        });
});





