var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')
    .createSharedEntry('app', ["./assets/scss/layout.scss","./assets/js/app.js"])
    .addEntry('home_js', ["./assets/js/slider/jssor_slider.min.js", "./assets/js/slider/slider.js", "./assets/js/home.js"])
    .addStyleEntry('home', "./assets/scss/home.scss")
    .enableSassLoader(function(sassOptions) {
        sassOptions.includePaths = ["assets/scss", "assets/css"];
    })
    .enableReactPreset()
    .cleanupOutputBeforeBuild()
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    })
    .autoProvidejQuery()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;
module.exports = Encore.getWebpackConfig();
