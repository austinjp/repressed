# Repressed

A Wordpress plugin that lists recent posts from related blogs.

Inserts the following HTML at a place of your chosing:

```HTML
<div class="repressed_block">
  <h3>From other osteopaths</h3>
  <ul class="repressed_list">
    <li class="repressed_title">
      <a class="repressed_link" rel="nofollow" href="http://example.com/link-1">Post title 1 from external source.</a>
      <ul class="repressed_snippet_list">
        <li class="repressed_snippet_item">Post 1 snippet text...</li>
      </ul>
    </li>
    <li class="repressed_title">
      <a class="repressed_link" rel="nofollow" href="http://example.com/link-1">Post title 2 from external source.</a>
      <ul class="repressed_snippet_list">
        <li class="repressed_snippet_item">Post 2 snippet text...</li>
      </ul>
    </li>
  </ul>
</div>
```

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

