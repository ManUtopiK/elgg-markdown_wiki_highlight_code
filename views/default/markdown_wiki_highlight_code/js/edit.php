
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki_highlight_code
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki_highlight_code
 *
 *	Elgg-markdown_wiki_highlight_code edit javascript file
 **/

/**
 * Elgg-markdown_wiki_highlight_code edit initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki_highlight_code.edit');

elgg.markdown_wiki_highlight_code.edit.init = function() {
	$(document).ready(function() {
		var $textarea = $('textarea.elgg-input-markdown'),
			$preview = $('#previewPane');
		
		// Continue only if the `textarea` is found
		if ($textarea) {
			var converter = new Showdown.converter().makeHtml;
			$textarea.keyup(function() {
				$preview.html(converter(convertCodeBlocks(normalizeLineBreaks($textarea.val()))));
				$textarea.innerHeight($preview.innerHeight() + 10 + 2); // padding (cannot set to textarea) + border
			}).trigger('keyup');
		}
		
		function normalizeLineBreaks(str, lineEnd) {
			var lineEnd = lineEnd || '\n';
			return str
				.replace(/\r\n/g, lineEnd) // DOS
				.replace(/\r/g, lineEnd) // Mac
				.replace(/\n/g, lineEnd); // Unix
		}
		
		function wrapCode(match, lang, code) {
			var hl;
			if (lang) {
				try {
					hl = hljs.highlight(lang, code).value;
				} catch(err) {}
			}
			hl = hl || hljs.highlightAuto(code).value;
			return '<pre><code class="' + lang + '">' + $.trim(hl) + '</code></pre>';
		}
		
		function convertCodeBlocks(mdown){
			var re = /^```\s*(\w+)\s*$([\s\S]*?)^```$/gm;
			return mdown.replace(re, wrapCode);
		}
	});
	return { trigger:true };
}
elgg.register_hook_handler('init', 'markdown_wiki.edit.init', elgg.markdown_wiki_highlight_code.edit.init);

// End of edit js for elgg-markdown_wiki_highlight_code plugin

