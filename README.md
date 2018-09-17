# Slugger for Craft CMS 3.x

Slugger is a Craft plugin that hashes the Id of an entry when it is saved and replaces the slug with the hash.

This plugin uses the [Hashids](http://hashids.org/php/) library to generate the slugs.

This plugin copies heavily from Alec Ritson's [Slugged](https://github.com/alecritson) plugin for Craft 2. Thanks, Alec. (The section override works in this version. :smiley:)

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

Visit the Plugin Store in your Craft 3 control panel. It costs nothing.

## Slugger Overview

-Insert text here-

## Configuration 
All configuration is done in the plugin settings page in the admin area. 

### Plugin settings 

***Salt***  
Set the salt to use when hashing

Default: `Change me to something else`

***Default length***   
The length of the hash, this will be overwritten with any length defined for a section 

Default: `8`

***Alphabet***  
The characters to use when generating the slug. 

Default: `abcdefghijklmnopqrstuvwxyz123456789`

***Sections***  
The only sections that will be listed are editable sections (no singles obvs). If you add a length to a section this will override the default set above. A section must be enabled for the hashing to happen, regardless of whether you add a length override or not.

## Using Slugger
Enable your section in the settings. Make a new entry. Save it. Voila... hashed slug.

You can decode the hash using the `decode` template variable.

```
  {# get the hash value from the url #}
  {% set hash = craft.request.segment(2) %}
    
  {# use slugger’s decode method to get the ID #}
  {% set entryId = craft.slugger.decode(hash) %}
```

## Support, issues, feedback

If you experience any problems please create a new issue here on the Repo.

Brought to you by [Madhouse](madmadmad.com)
