/* jshint node:true */
/* global module */
module.exports = function (grunt) {
	var sass       = require( 'node-sass' ),
		SOURCE_DIR = './',
		BUILD_DIR  = 'extra-product-options-for-woocommerce/',

		WA_CSS = [
			'**/*.css',
		],

		WA_SCSS = [
			'**/*.scss',
		],

		// CSS exclusions, for excluding files from certain tasks, e.g. rtlcss
		WA_EXCLUDED_CSS = [
			'!**/*-rtl.css',
			'!**/*.min.css',
			'!**/vendor/**/*.css',
			'!**/lib/**/*.css',
			'!**/node_modules/**/*.css',
			'!**/freemius/**/*.css',
			'!**/assets/css/jquery-ui-timepicker.css',
			'!**/assets/css/cm.css',
		],

		// CSS exclusions, for excluding files from certain tasks, e.g. rtlcss
		WA_EXCLUDED_MIN_CSS = [
			'!**/*.min.css',
			'!**/vendor/**/*.css',
			'!**/lib/**/*.css',
			'!**/node_modules/**/*.css',
			'!**/freemius/**/*.css',
			'!**/assets/css/jquery-ui-timepicker.css',
		],

		// SCSS exclusions, for excluding files from certain tasks,
		WA_EXCLUDED_SCSS = [
			'!**/vendor/**/*.scss',
			'!**/lib/**/*.scss',
			'!**/node_modules/**/*.scss',
			'!**/freemius/**/*.scss',
			'!**/assets/css/jquery-ui-timepicker.css',
		],

		WA_JS = [
			'**/*.js',
		],

		WA_EXCLUDED_JS = [
			'!**/vendor/**/*.js',
			'!**/lib/**/*.js',
			'!**/*.min.js',
			'!**/node_modules/**/*.js',
			'!**/freemius/**/*.js',
			'!**/assets/js/jquery-ui-timepicker.js',
			'!**/assets/js/cm.js',
			'!**/assets/js/cm_css.js',
			'!**/assets/js/jquery-maskedinput.min.js',
		],

		WA_EXCLUDED_MISC = [
			'!**/node_modules/**',
			'!**/freemius/**',
		];

	require( 'matchdep' ).filterDev( ['grunt-*', '!grunt-legacy-util'] ).forEach( grunt.loadNpmTasks );
	grunt.util = require( 'grunt-legacy-util' );

	grunt.initConfig(
		{
			pkg: grunt.file.readJSON( 'package.json' ),
			checkDependencies: {
				options: {
					packageManager: 'npm'
				},
				src: {}
			},
			jshint: {
				options: grunt.file.readJSON( '.jshintrc' ),
				grunt: {
					src: ['Gruntfile.js']
				},
				core: {
					expand: true,
					cwd: SOURCE_DIR,
					src: WA_JS.concat( WA_EXCLUDED_JS ),

					/**
					 * Limit JSHint's run to a single specified file:
					 *
					 * grunt jshint:core --file=filename.js
					 *
					 * Optionally, include the file path:
					 *
					 * grunt jshint:core --file=path/to/filename.js
					 *
					 * @param {String} filepath
					 * @returns {Bool}
					 */
					filter: function (filepath) {
						var index, file = grunt.option( 'file' );

						// Don't filter when no target file is specified
						if ( ! file) {
							return true;
						}

						// Normalise filepath for Windows
						filepath = filepath.replace( /\\/g, '/' );
						index    = filepath.lastIndexOf( '/' + file );

						// Match only the filename passed from cli
						if (filepath === file || (-1 !== index && index === filepath.length - (file.length + 1))) {
							return true;
						}

						return false;
					}
				}
			},
			sass: {
				options: {
					outputStyle: 'expanded',
					implementation: sass,
					indentType: 'tab',
					indentWidth: '1'
				},
				dist: {
					files: [
					{
						expand: true,
						extDot: 'last',
						flatten: true,
						cwd: 'assets/css/scss',
						src: ['*.scss'],
						dest: 'assets/css',
						ext: '.css'
					},
					],
				}
			},
			rtlcss: {
				options: {
					opts: {
						processUrls: false,
						autoRename: false,
						clean: true
					},
					saveUnmodified: false
				},
				core: {
					expand: true,
					cwd: SOURCE_DIR,
					dest: SOURCE_DIR,
					extDot: 'last',
					ext: '-rtl.css',
					src: WA_CSS.concat( WA_EXCLUDED_CSS )
				}
			},
			checktextdomain: {
				options: {
					correct_domain: false,
					text_domain: ['extra-product-options-for-woocommerce'],
					keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'_n:1,2,4d',
					'_ex:1,2c,3d',
					'_nx:1,2,4c,5d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
					]
				},
				files: {
					cwd: SOURCE_DIR,
					src: ['**/*.php', '**/*.js'].concat( WA_EXCLUDED_JS, WA_EXCLUDED_MISC ),
					expand: true
				}
			},
			makepot: {
				src: {
					options: {
						cwd: SOURCE_DIR,
						domainPath: '/languages',
						exclude: ['node_modules/*'], // List of files or directories to ignore.
						mainFile: 'extra-product-options-for-woocommerce.php',
						potFilename: 'extra-product-options-for-woocommerce.pot',
						potHeaders: { // Headers to add to the generated POT file.
							poedit: true, // Includes common Poedit headers.
							'Last-Translator': 'wpactpro <wpactpro@gmail.com>',
							'Language-Team': 'wpactpro <wpactpro@gmail.com>',
							'report-msgid-bugs-to': 'https://www.wpactpro.com/contact/',
							'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
						},
						type: 'wp-plugin',
						updateTimestamp: true, // Whether the POT-Creation-Date should be updated without other changes.
						updatePoFiles: false // Whether to update PO files in the same directory as the POT file.
					}
				}
			},
			clean: {
				all: [BUILD_DIR]
			},
			copy: {
				files: {
					files: [
					{
						cwd: '.',
						dest: 'extra-product-options-for-woocommerce/',
						dot: true,
						expand: true,
						src: ['**', '!**/.{svn,git,github,jshintignore,jshintrc,stylelintrc,sass-cache}/**','!**/node_modules/**','!**/assets/css/scss/**', '!package.json', '!package-lock.json', '!extra-product-options-for-woocommerce-plugin.zip', '!extra-product-options-for-woocommerce.zip', '!Gruntfile.js','!contrib/**','!vendor/**'],
					}
					]
				}
			},
			uglify: {
				core: {
					cwd: SOURCE_DIR,
					dest: SOURCE_DIR,
					extDot: 'last',
					expand: true,
					ext: '.min.js',
					src: WA_JS.concat( WA_EXCLUDED_JS, '!Gruntfile.js' )
				}
			},
			stylelint: {
				scss: {
					options: {
						configFile: '.stylelintrc',
						format: 'scss'
					},
					expand: true,
					cwd: SOURCE_DIR,
					src: WA_SCSS.concat( WA_EXCLUDED_SCSS )
				},
			},
			cssmin: {
				minify: {
					cwd: SOURCE_DIR,
					dest: SOURCE_DIR,
					extDot: 'last',
					expand: true,
					ext: '.min.css',
					src: WA_CSS.concat( WA_EXCLUDED_MIN_CSS )
				}
			},
			exec: {
				cli: {
					command: 'git add .; git commit -am "grunt release build";',
					cwd: '.',
					stdout: false
				}
			},
			jsvalidate: {
				options: {
					globals: {},
					esprimaOptions: {},
					verbose: false
				},
				src: {
					files: {
						src: [
						'**/*.js',
						].concat( WA_EXCLUDED_JS )
					}
				}
			},
			compress: {
				main: {
					options: {
						archive: 'extra-product-options-for-woocommerce.zip'
					},
					files: [{
						src: BUILD_DIR + '**',
						dest: '.'
					}]
				}
			},
			'string-replace': {
				dist: {
					files: [{
						src: '**/*.php',
						expand: true,
					}],
					options: {
						replacements: [{
							pattern: /\[EPOFWVERSION]/g,
							replacement: '<%= pkg.EPOFWVersion %>'
						}]
					}
				}
			}
		}
	);

	/**
	 * Register tasks.
	 */
	//grunt.registerTask( 'pre-commit', ['checkDependencies', 'jsvalidate', 'jshint', 'stylelint', 'checktextdomain'] );
	grunt.registerTask( 'src', ['checkDependencies', 'jsvalidate', 'jshint', 'stylelint', 'sass', 'rtlcss', 'checktextdomain', 'uglify', 'cssmin', 'makepot:src'] );
	// grunt.registerTask( 'src', ['checkDependencies', 'stylelint', 'sass', 'rtlcss', 'checktextdomain', 'uglify', 'cssmin', 'makepot:src'] );
	
	grunt.registerTask( 'build', ['string-replace', 'clean:all', 'copy:files', 'compress', 'clean:all'] ); //'exec:cli',
	grunt.registerTask( 'release', ['src', 'build'] );

	grunt.registerTask( 'jstest', 'Runs all JavaScript tasks.', ['jsvalidate', 'jshint'] );

	// Travis CI Tasks.
	grunt.registerTask( 'travis:grunt', 'Runs Grunt build task.', ['src'] );

	// Default task.
	grunt.registerTask( 'default', ['src'] );
};
