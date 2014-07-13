# Require any additional compass plugins here.

require 'compass/import-once/activate'
require 'sass-media_query_combiner'
require 'bourbon-compass'
require 'neat-compass'


# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "."
sass_dir = "scss"
images_dir = "images"
javascripts_dir = "scripts"
fonts_dir = "fonts"

output_style = :nested

disable_warnings = true

sass_options = { :r => 'sass-media_query_combiner' }

# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false
color_output = false

Sass::Script::Number.precision = 1

# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass scss scss && rm -rf sass && mv scss sass
