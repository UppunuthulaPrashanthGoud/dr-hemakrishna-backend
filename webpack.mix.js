const mix = require('laravel-mix');
require('laravel-mix-purgecss');

// Combine CSS files into all.css
mix.styles([
    'public/plugins/bootstrap/dist/css/bootstrap.min.css',
    'public/plugins/perfect-scrollbar/css/perfect-scrollbar.css',
    'public/plugins/select2/dist/css/select2.min.css',
    'public/plugins/image-uploader/image-uploader.min.css',
    'public/plugins/summernote/dist/summernote-bs4.css',
    'public/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css',
    'public/plugins/mohithg-switchery/dist/switchery.min.css',
    'public/plugins/DataTables/datatables.min.css',
    'public/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css'
], 'public/css/all.css') // Save the combined file in 'public/css/all.css'
    .postCss('public/css/all.css', 'public/css') // Process the combined CSS file
    .purgeCss({
        content: [
            'resources/views/**/*.blade.php',
            'resources/js/**/*.vue',
            'public/**/*.html',
            'public/**/*.js'
        ],
        defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
    });

// Combine JavaScript files into all.js
mix.scripts([
    'public/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js',
    'public/plugins/screenfull/dist/screenfull.js',
    'public/plugins/select2/dist/js/select2.min.js',
    'public/plugins/image-uploader/image-uploader.min.js',
    'public/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
    'public/plugins/mohithg-switchery/dist/switchery.min.js',
    'public/plugins/summernote/dist/summernote-bs4.min.js',
    'public/plugins/jquery.repeater/jquery.repeater.min.js',
    'public/plugins/DataTables/datatables.min.js',
    'public/plugins/moment/moment.js',
    'public/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js',
    'public/plugins/datedropper/datedropper.min.js'
], 'public/js/all.js');
