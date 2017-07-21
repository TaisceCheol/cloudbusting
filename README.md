# cloudbusting plugin for Craft CMS

Purge cloudflare cache for Craft CMS entries on save

## Installation

To install cloudbusting, follow these steps:

1. Download & unzip the file and place the `cloudbusting` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/TaisceCheol/cloudbusting.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3.  -OR- install with Composer via `composer require TaisceCheol/cloudbusting`
4. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `cloudbusting` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

cloudbusting works on Craft 2.4.x and Craft 2.5.x.

## cloudbusting Overview

cloudbusting makes life easier when using a [Craft CMS](https://craftcms.com/) site behind [Cloudflare](https://www.cloudflare.com/). Whenever you save an entry cloudbusting will purge the Cloudflare cache for that entry's url. That's it.

## Using cloudbusting

All you need to do to start using cloudbusting is provide your credentials on the settings page.

Largely based on the brilliant work of [Craft-Shopify](https://github.com/davist11/craft-shopify)

Brought to you by [the Irish Traditional Music Archive](https://www.itma.ie)
