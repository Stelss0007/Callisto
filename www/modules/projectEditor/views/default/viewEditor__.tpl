<!doctype html>
{literal}
<title>CodeMirror</title>
<meta charset="utf-8"/>

<link rel=stylesheet href="/modules/projectEditor/js/lib/codemirror.css">
<link rel=stylesheet href="/modules/projectEditor/js/doc/docs.css">
<script src="/modules/projectEditor/js/lib/codemirror.js"></script>
<script src="/modules/projectEditor/js/mode/xml/xml.js"></script>
<script src="/modules/projectEditor/js/mode/javascript/javascript.js"></script>
<script src="/modules/projectEditor/js/mode/css/css.js"></script>
<script src="/modules/projectEditor/js/mode/htmlmixed/htmlmixed.js"></script>
<script src="/modules/projectEditor/js/addon/edit/matchbrackets.js"></script>

<script src="/modules/projectEditor/js/doc/activebookmark.js"></script>

<style>
  .CodeMirror { height: auto; border: 1px solid #ddd; }
  .CodeMirror-scroll { max-height: 200px; }
  .CodeMirror pre { padding-left: 7px; line-height: 1.25; }
</style>

<div id=nav>
  <a href="http://codemirror.net"><img id=logo src="doc/logo.png"></a>

  <ul>
    <li><a class=active data-default="true" href="#description">Home</a>
    <li><a href="doc/manual.html">Manual</a>
    <li><a href="https://github.com/marijnh/codemirror">Code</a>
  </ul>
  <ul>
    <li><a href="#features">Features</a>
    <li><a href="#community">Community</a>
    <li><a href="#browsersupport">Browser support</a>
  </ul>
</div>

<article>

<section id=description class=first>
  <p><strong>CodeMirror</strong> is a versatile text editor
  implemented in JavaScript for the browser. It is specialized for
  editing code, and comes with a number of language modes and addons
  that implement more advanced editing functionality.</p>

  <p>A rich <a href="doc/manual.html#api">programming API</a> and a
  CSS <a href="doc/manual.html#styling">theming</a> system are
  available for customizing CodeMirror to fit your application, and
  extending it with new functionality.</p>
</section>

<section id=demo>
  <h2>This is CodeMirror</h2>
  <form style="position: relative; margin-top: .5em;"><textarea id=demotext>
<!-- Create a simple CodeMirror instance -->
<link rel="stylesheet" href="lib/codemirror.css">
<script src="lib/codemirror.js"></script>
<script>
  var editor = CodeMirror.fromTextArea(myTextarea, {
    mode: "text/html"
  });
</script></textarea>
  <select id="demolist" onchange="document.location = this.options[this.selectedIndex].value;">
    <option value="#">Other demos...</option>
    <option value="demo/complete.html">Autocompletion</option>
    <option value="demo/folding.html">Code folding</option>
    <option value="demo/theme.html">Themes</option>
    <option value="mode/htmlmixed/index.html">Mixed language modes</option>
    <option value="demo/bidi.html">Bi-directional text</option>
    <option value="demo/variableheight.html">Variable font sizes</option>
    <option value="demo/search.html">Search interface</option>
    <option value="demo/vim.html">Vim bindings</option>
    <option value="demo/emacs.html">Emacs bindings</option>
    <option value="demo/sublime.html">Sublime Text bindings</option>
    <option value="demo/tern.html">Tern integration</option>
    <option value="demo/merge.html">Merge/diff interface</option>
    <option value="demo/fullscreen.html">Full-screen editor</option>
  </select></form>
  <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("demotext"), {
      lineNumbers: true,
      mode: "text/html",
      matchBrackets: true
    });
  </script>
  <div style="position: relative; margin: 1em 0;">
    <a class="bigbutton left" href="http://codemirror.net/codemirror.zip">DOWNLOAD LATEST RELEASE</a>
    <div><strong>version 4.5</strong> (<a href="doc/releases.html">Release notes</a>)</div>
    <div>or use the <a href="doc/compress.html">minification helper</a></div>
    <div style="position: absolute; top: 0; right: 0; text-align: right">
      <span class="bigbutton right" onclick="document.getElementById('paypal').submit();">DONATE WITH PAYPAL</span>
      <div style="position: relative">
        or <span onclick="document.getElementById('bankinfo').style.display = 'block';" class=quasilink>Bank</span>,
        <span onclick="document.getElementById('bcinfo').style.display = 'block';" class=quasilink>Bitcoin</span>,
        <a href="https://www.gittip.com/marijnh">Gittip</a>,
        <a href="https://flattr.com/profile/marijnh">Flattr</a><br>
        <div id=bankinfo class=bankinfo>
          <span class=bankinfo_close onclick="document.getElementById('bankinfo').style.display = '';">×</span>
          Bank: <i>Rabobank</i><br/>
          Country: <i>Netherlands</i><br/>
          SWIFT: <i>RABONL2U</i><br/>
          Account: <i>147850770</i><br/>
          Name: <i>Marijn Haverbeke</i><br/>
          IBAN: <i>NL26 RABO 0147 8507 70</i>
        </div>
        <div id=bcinfo class=bankinfo>
          <span class=bankinfo_close onclick="document.getElementById('bcinfo').style.display = '';">×</span>
          Bitcoin address: 1HVnnU8E9yLPeFyNgNtUPB5deXBvUmZ6Nx
        </div>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal">
          <input type="hidden" name="cmd" value="_s-xclick"/>
          <input type="hidden" name="hosted_button_id" value="3FVHS5FGUY7CC"/>
        </form>
      </div>
      <div>
        Purchase <a href="http://codemirror.com">commercial support</a>
      </div>
    </div>
  </div>
</section>

<section id=features>
  <h2>Features</h2>
  <ul>
    <li>Support for <a href="mode/index.html">over 60 languages</a> out of the box
    <li>A powerful, <a href="mode/htmlmixed/index.html">composable</a> language mode <a href="doc/manual.html#modeapi">system</a>
    <li><a href="doc/manual.html#addon_show-hint">Autocompletion</a> (<a href="demo/xmlcomplete.html">XML</a>)
    <li><a href="doc/manual.html#addon_foldcode">Code folding</a>
    <li><a href="doc/manual.html#option_extraKeys">Configurable</a> keybindings
    <li><a href="demo/vim.html">Vim</a>, <a href="demo/emacs.html">Emacs</a>, and <a href="demo/sublime.html">Sublime Text</a> bindings
    <li><a href="doc/manual.html#addon_search">Search and replace</a> interface
    <li><a href="doc/manual.html#addon_matchbrackets">Bracket</a> and <a href="doc/manual.html#addon_matchtags">tag</a> matching
    <li>Support for <a href="demo/buffers.html">split views</a>
    <li><a href="doc/manual.html#addon_lint">Linter integration</a>
    <li><a href="demo/variableheight.html">Mixing font sizes and styles</a>
    <li><a href="demo/theme.html">Various themes</a>
    <li>Able to <a href="demo/resize.html">resize to fit content</a>
    <li><a href="doc/manual.html#mark_replacedWith">Inline</a> and <a href="doc/manual.html#addLineWidget">block</a> widgets
    <li>Programmable <a href="demo/marker.html">gutters</a>
    <li>Making ranges of text <a href="doc/manual.html#markText">styled, read-only, or atomic</a>
    <li><a href="demo/bidi.html">Bi-directional text</a> support
    <li>Many other <a href="doc/manual.html#api">methods</a> and <a href="doc/manual.html#addons">addons</a>...
  </ul>
</section>

<section id=community>
  <h2>Community</h2>

  <p>CodeMirror is an open-source project shared under
  an <a href="LICENSE">MIT license</a>. It is the editor used in the
  dev tools for
  both <a href="https://hacks.mozilla.org/2013/11/firefox-developer-tools-episode-27-edit-as-html-codemirror-more/">Firefox</a>
  and <a href="https://developers.google.com/chrome-developer-tools/">Chrome</a>, <a href="http://www.lighttable.com/">Light
  Table</a>, <a href="http://brackets.io/">Adobe
  Brackets</a>, <a href="http://blog.bitbucket.org/2013/05/14/edit-your-code-in-the-cloud-with-bitbucket/">Bitbucket</a>,
  and <a href="doc/realworld.html">many other projects</a>.</p>

  <p>Development and bug tracking happens
  on <a href="https://github.com/marijnh/CodeMirror/">github</a>
  (<a href="http://marijnhaverbeke.nl/git/codemirror">alternate git
  repository</a>).
  Please <a href="http://codemirror.net/doc/reporting.html">read these
  pointers</a> before submitting a bug. Use pull requests to submit
  patches. All contributions must be released under the same MIT
  license that CodeMirror uses.</p>

  <p>Discussion around the project is done on
  a <a href="http://groups.google.com/group/codemirror">mailing list</a>.
  There is also
  the <a href="http://groups.google.com/group/codemirror-announce">codemirror-announce</a>
  list, which is only used for major announcements (such as new
  versions). If needed, you can
  contact <a href="mailto:marijnh@gmail.com">the maintainer</a>
  directly.</p>

  <p>A list of CodeMirror-related software that is not part of the
  main distribution is maintained
  on <a href="https://github.com/marijnh/CodeMirror/wiki/CodeMirror-addons">our
  wiki</a>. Feel free to add your project.</p>
</section>

<section id=browsersupport>
  <h2>Browser support</h2>
  <p>The <em>desktop</em> versions of the following browsers,
  in <em>standards mode</em> (HTML5 <code>&lt;!doctype html></code>
  recommended) are supported:</p>
  <table style="margin-bottom: 1em">
    <tr><th>Firefox</th><td>version 4 and up</td></tr>
    <tr><th>Chrome</th><td>any version</td></tr>
    <tr><th>Safari</th><td>version 5.2 and up</td></tr>
    <tr><th style="padding-right: 1em;">Internet Explorer</th><td>version 8 and up</td></tr>
    <tr><th>Opera</th><td>version 9 and up</td></tr>
  </table>
  <p>Modern mobile browsers tend to partly work. Bug reports and
  patches for mobile support are welcome, but the maintainer does not
  have the time or budget to actually work on it himself.</p>
</section>

</article>
{/literal}