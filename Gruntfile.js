module.exports = function(grunt) {
  grunt.initConfig({
    compress: {
        com_clonard: {
            options: {
                archive: 'com_clonard.zip'
            },
            
            files: [
                {cwd: 'com_clonard/', src: ['**/*'], expand: true, dest: ''}, // includes files in path and its subdirs
            ]
        }
    },
    
    exec: {
        clean: {
            cmd: 'find . -type f -name "*~" -exec rm -f {} ;'
        },
        
        
        test: {
            cmd: "find com_clonard -type f -name '*.php' -exec php -l {} ;",

            
            onOutData: function (data) {
                if (data.match(/Errors parsing|PHP Parse error/g)) {
                    grunt.log.error(data);
                    process.exit(1);
                }
                else {
                    grunt.log.write(data);
                }
            },
        
            onErrData: function (data) {
                if (data.match(/Errors parsing|PHP Parse error/g)) {
                    grunt.log.error(data);
                    process.exit(1);
                }
                else {
                    grunt.log.write(data);
                }
            }
        }
    }
  });
  
  grunt.loadNpmTasks('grunt-contrib-compress');
  grunt.loadNpmTasks('grunt-exec');
  
  grunt.registerTask('default', ['exec:clean', 'exec:test', 'compress']);
};

