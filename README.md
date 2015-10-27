# Repressed

A Wordpress plugin that lists recent posts from related blogs. Content syndication.

## WARNING

This is a personal project. It is completely unsupported and supplied as-is with no warranty of any nature, implicit or explicit. Use it at your peril.


## Output

Repressed fetches items from RSS feeds and inserts them into your blog. This is useful for linking directly to posts from related blogs.

It produces the following HTML:

```HTML
<div class="repressed_block">
  <h3>From other bloggers</h3>
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

Which will produce something like the following rendered output, depending on your choice of CSS:

> ### From other bloggers
> * [Post title 1 from external source](http://example.com/link-1)
>   * Post 1 snippet text...
> * [Post title 2 from external source](http://example.com/link-2)
>   * Post 2 snippet text...


## Installation

In your Wordpress plugins directory create a directory called `repressed`.

In the `repressed` directory place `repressed.php`.

Also in the `repressed` directory install [SimplePie](http://simplepie.org/). Make sure this is in a directory called `simplepie`. Repressed has only been tested with SimplePie version 1.3.1.

On running, repressed will write to directory named `cache` to store SimplePie's cache files. Make sure it has write permission to the `repressed` and `cache` directories in order to do this.

Your directory structure should look something like this:

```bash
wordpress
  └── wp-content
      └── plugins
           └── repressed
                ├── cache
                │   └── http-site-cache-files-here.spc
                ├── repressed.php
                └── simplepie
                    └── ...simplepie files here...
```

## Configuration

In the Wordpress settings menu, select "Repressed". In the Repressed settings screen, enter the URLs of up to 5 RSS or Atom feeds. Most RSS or Atom formats should work, see [SimplePie](http://simplepie.org) for details. Absolutely NO ERROR CHECKING is done here, although failed feeds shouldn't generate errors (as far as I'm aware!).

Typically Wordpress and other blogging platforms expose RSS feeds at URLs similar to these:

```
http://example.com/?feed=rss2
http://example.com/?feed=atom
http://example.com/feed
http://example.com/blog/feed
```

If you need to alter the HTML output, the length of the post snippets, the number of items collected per source, you will have to edit `repressed.php`.
