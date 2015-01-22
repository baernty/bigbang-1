# bigbang

Hi. I'm a starter theme called `bigbang` and I'm highly inspired by the great `_s` or `underscores` theme, if you like. I'm a theme meant for hacking so don't use me as a Parent Theme. Instead try turning me into the next, most awesome, WordPress theme out there. That's what I'm here for.

I come with the great streaming build system [Gulp](http://gulpjs.com) and the great package manager [bower](http://bower.io) which keeps your vendors up to date. Gulp helps with the common frontend stuff like processing [SASS](http://sass-lang.com) or concatinating and minifying of your JS files, live reloading your brower, etc.

My ultra-minimal (S)CSS might make me look like theme tartare but that means less stuff to get in your way when you're designing your awesome theme. For your convenience there is [Normalize.css](http://necolas.github.io/normalize.css/) and [Bourbon](http://bourbon.io) build in. Use it or throw it away. Here are some of the other more interesting things you'll find here:

* A just right amount of lean, well-commented, modern, HTML5 templates.
* A helpful 404 template.
* A sample custom header implementation in `inc/custom-header.php` that can be activated by uncommenting one line in `functions.php` and adding the code snippet found in the comments of `inc/custom-header.php` to your `header.php` template.
* Custom template tags in `inc/template-tags.php` that keep your templates clean and neat and prevent code duplication.
* Some small tweaks in `inc/extras.php` that can improve your theming experience.
* A script at `js/navigation.js` that makes your menu a toggled dropdown on small screens (like your phone), ready for CSS artistry. It's in the file list in `Gulpfile.js` on line `57`
* Smartly organized starter CSS in `style.scss` that will help you to quickly get your design off the ground.
* Licensed under GPLv2 or later. :) Use it to make something cool.

## Getting Started


Download `bigbang` from [GitHub](https://github.com/maxxscho/bigbang/archive/master.zip). The first thing you want to do is copy the `bigbang` directory and change the name to something else (like, say, `megatherium`), and then you'll need to do a five-step find and replace on the name in all the templates.

1. Search for `'bigbang'` (inside single quotations) to capture the text domain.
2. Search for `bb_` to capture all the function names.
3. Search for `Text Domain: bigbang` in style.css.
4. Search for <code>&nbsp;_s</code> (with a space before it) to capture DocBlocks.
5. Search for `bigbang-` to capture prefixed handles.

OR

* Search for: `'bigbang'` and replace with: `'megatherium'`
* Search for: `bb_` and replace with: `megatherium_`
* Search for: `Text Domain: bigbang` and replace with: `Text Domain: megatherium` in style.css.
* Search for: <code>&nbsp;_s</code> and replace with: <code>&nbsp;Megatherium</code>
* Search for: `bigbang-` and replace with: `megatherium-`

### Gulp and Bower

For Gulp and bower we need a few things set up. It's easy and should take only five minutes. If you don't know gulp and bower you should give them a try.

1. Install [Node.js](http://nodejs.org) like any other app
2. Install [Bower](http://bower.io) via your terminal `npm install -g bower`. See the [docs](http://bower.io/#install-bower) for more information.
3. Install [Gulp](http://gulpjs.com) via your terminal `npm install --global gulp`. See the [docs](https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md#getting-started)

Congratulations - you have everything to work with these great tools.

`bigbang` has a few vendors set up:
- [Modernizr](http://modernizr.com)
- [jQuery](http://jquery.com)
- [Bourbon](http://bourbon.io)
- [Bourbon Neat](http://neat.bourbon.io)
- [Normalize.css](http://necolas.github.io/normalize.css/)

To install these change to your theme directory in your terminal and enter `bower install`.

The last thing are the Gulp modules. In your theme directory enter `npm install` and all modules will be installed in the `node_modules` directory.

You're ready to go. Enter `gulp` and begin to work.

### Have fun

Now you're ready to go! The next step is easy to say, but harder to do: make an awesome WordPress theme. :)

Good luck!

(This readme is a first draft an will be updated and improved permanently. If you have questions, feel free to hit me a line.)
