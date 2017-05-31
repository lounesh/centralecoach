// wrapper function
module.exports = function(grunt){
	// load all our Grunt plugins
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        // task configuration goes here

        less: {
		  development: {
		    files: {
		      'css/custom.css': ['less/final.less']
		    }
		  }
		},

		watch: {
			style: {
				files : ['less/variables.less','less/mq-320.less', 'less/mq-xs.less', 'less/mq-sm.less', 'less/mq-md.less', 'less/mq-lg.less'],
				tasks : ['less:development'],
				options: {
			      spawn: false
			    }
			}
		}

    });

    // define the default task that executes when we run 'grunt' from inside the project
    grunt.registerTask('default', ['watch:style']);

};