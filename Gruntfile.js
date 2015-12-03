/*
 * grunt-contrib-less
 * http://gruntjs.com/
 *
 * Copyright (c) 2013 Tyler Kellen, contributors
 * Licensed under the MIT license.
 */

'use strict';

module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
	    sass: {
	        dist: {
		        options: {
		            compass: true
		        },
		        files: {
                    'oc-content/themes/pop/css/style.css': 'oc-content/themes/pop/sass/main.scss'
		        }
	        }
	    },
	    watch: {
	        css: {
	            files: 'oc-content/themes/pop/sass/**/*.scss',
	            tasks: ['sass']
	        }
	    }
    });


    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['watch']);

};