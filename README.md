puppet-highlight
================

This repo provides a basic configuration to get syntax highlighting in PHPStorm (_4.*_) for puppet files.

Installation
===============

Run `php parser.php` and put the output file (_Puppet files.xml_) into this folder:

Windows:
<pre>
USER\\.WebIde40\\config\\filetypes
</pre>
OS X:
<pre>
~/Library/Preferences/WebIde40/filetypes
</pre>
Linux:
<pre>
~/.WebIde40/config/filetypes
</pre>

If the syntax highlighting doesn't seem to work, check if you don't have _*.pp_ files already defined as plain text files.

Contributing
===============

Feel free to fork, participate and create issues ;)
This is only a fast hack, but maybe you can help to improve it.
