module.exports = function(grunt) {

// Project configuration.
grunt.initConfig({
  uglify: {
    my_target: {
      files: {
        'public/js/output.min.js': ['./public/js/*.js']
      }
    }
  }

  cssmin: {
    combine: {
      files: {
        'public/css/output.min.css': ['public/css/*.css']
      }
    }
  }
});

// Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');

  // Default task(s).
  grunt.registerTask('default', ['uglify', 'cssmin']);

}