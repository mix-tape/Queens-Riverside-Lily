# Sandpit
> Wordpress Theme Development Kit

A framework for rapid Wordpress development using ACF, Compass, Gulp and Bower

## Breakdown

By default, on install this theme will -

- set a few friendly defaults
- remove a whole lot of default cruft
- change the default behaviour of several Wordpress features
- prompt for the installation of ACF and its plugins

The framework is fairly opinionated, while it won't force you to do anything directly, it will often have an example of how best to approach a problem.

The SASS stack includes

- Compass (SASS Configuration and Mixin Library)
- Bourbon (Mixin Library)
- Bourbon Neat (Grid System)
- Media Query Combiner (Consolidation of nested media queries)

## Dependencies

- Nodejs/npm (`brew install node`)
- Gulp + Bower (`npm install gulp bower -g`)
- Ruby/gem + SASS + Compass (`brew install ruby && gem install sass compass`)

## Getting Started

Make sure you have all your dependencies installed

Clone or checkout this repo into your themes directory and run `bundle install && npm install && bower install` to install all the dependencies

## Build Process

You can run the default (`watch` based) task with `gulp`. This task will add debug information to SASS for testing + leave all coded expanded.

For production use `gulp production` which will minify, strip comments and uglify all code to decrease server requests.
