Midgard setup for some MeeGo community services
===============================================

This repository contains Midgard templates and configurations needed if the decision is to run some [meego.com][1] community 
services on the [Midgard][2] content management platform.

The reason for this is that we've recognized that several [maemo.org community tools][3] built in Midgard would be useful 
[assets for the MeeGo community][4].

## Basic assumptions

* Main MeeGo website will be powered by Drupal
* Different community services can be powered by other web tools (Mediawiki, Bugzilla, vBulletin, Midgard)
* All tools need to use centralized login and profile management (for now, Drupal authentication sessions)
* All tools need to use MeeGo visual templates

## Setup

* A Midgard 8.09 ([Ragnaroek LTS][5]) installation and Drupal 6 installation on same server
* Midgard runs as a subdirectory on the Drupal vhost
* Midgard uses Drupal's `session` and `user` tables for SSO via [net.nemein.drupalauth][6]
* Midgard has a copy of the MeeGo layout templates

[1]: http://meego.com
[2]: http://www.midgard-project.org/midgard/
[3]: http://bergie.iki.fi/blog/maemo-s_community_involvement_infrastructure_is_what_meego_needs
[4]: http://wiki.meego.com/Maemo_and_Moblin_community_assets
[5]: http://bergie.iki.fi/blog/long-term_support_for_midgard-ragnaroek_is_here/
[6]: http://trac.midgard-project.org/browser/branches/ragnaroek/midcom/net.nemein.drupalauth
