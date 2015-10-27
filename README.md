# Repressed

A Wordpress plugin that lists recent posts from related blogs.

## WARNING

This is a personal project. It is completely unsupported and supplied as-is with no warranty of any nature, implicit or explicit. Use it at your peril.

## Installation

In your Wordpress plugins directory create a directory called `repressed`.

In the `repressed` directory place `repressed.php`.

Also in the `repressed` directory install SimplePie. Make sure this is in a directory called `simplepie`. Repressed has only been tested with SimplePie version 1.3.1.

On running, repressed will write to directory named `cache` to store SimplePie's cache files. Make sure it has write permission to the `repressed` directory in order to do this.

Your directory structure should look something like this:

```bash
.
├── cache
│   ├── http-site-cache-files-here.spc
├── repressed.php
└── simplepie
    ├── ...simplepie files here...
```

