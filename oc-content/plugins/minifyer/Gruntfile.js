module.exports  = function(grunt){

    var plugin_name = 'minifyer',
        base_dir = '',
        build_dir = '../../../../../PACKAGES/PLUGINS/'+plugin_name+'/'+plugin_name,
        build_to_zip = '../../../../../PACKAGES/PLUGINS/'+plugin_name,
        build_zip_dir = '../../../../../PACKAGES/PLUGINS/ZIPS/'+plugin_name;

        // configure the tasks
        grunt.initConfig({
            clean: {
                src: {
                    options: {
                        force: true
                    },
                    src: [ build_to_zip ]
                }
            },
            copy: {
                src: {
                    cwd: '',
                    src: [ '**', '!node_modules' ],
                    dest: build_dir,
                    expand: true,
                    filter: function(src_path){
                        return ( src_path.indexOf('node_modules') < 0 );
                    },
                    options: {
                        processContentExclude: ['**/*.{png,gif,jpg,ico,eot,svg,ttf,woff,po,mo}']
                    }
                }
            },
            cssmin: {
                build: {
                    files: [{
                        cwd: build_dir+'/admin/assets/css',
                        src: ['**/*.css', '!*.min.css'],
                        dest: build_dir+'/admin/assets/css',
                        expand: true,
                        ext: '.min.css'
                    }]
                }
            },
            uglify: {
                build: {
                    options: {
                        mangle: false
                    },
                    files: [{
                            cwd: build_dir+'/admin/assets/js',
                            src: ['*.js', '!*.min.js'],
                            dest: build_dir+'/admin/assets/js',
                            expand: true,
                            ext: '.min.js'
                        }]
                }
            },
            compress: {
                build: {
                    options: {
                        archive: build_zip_dir+'/'+getName()
                    },
                    files: [
                        {
                            cwd: build_to_zip,
                            src: ['**/*'],
                            expand: true
                        }
                    ]
                }
            }
        });

    require('load-grunt-tasks')(grunt);

    grunt.registerTask(
        'build',
        'Compiles all of the assets and copies the files to the build directory.',
        [ 'clean:src', 'copy', 'cssmin', 'uglify', 'compress:build']
    );

    function getName(){
        var date = new Date();
        return plugin_name+'-'+date.getFullYear()+date.getMonth()+date.getDate()+date.getHours()+date.getMinutes()+'.zip';
    }
};
