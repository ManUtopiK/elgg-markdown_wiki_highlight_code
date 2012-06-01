<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki_highlight_code
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki_highlight_code
 *
 *	Elgg-markdown_wiki_highlight_code start file
 **/

elgg_register_event_handler('init', 'system', 'markdown_wiki_highlight_code_init');

/**
 * Initialize elgg-markdown_wiki_highlight_code plugin.
 */
function markdown_wiki_highlight_code_init() {

	// register js and css
	elgg_register_js('highlight', "/mod/elgg-markdown_wiki_highlight_code/vendors/highlight/highlight.pack.js", 'head', 100);
	elgg_register_css('highlight', "/mod/elgg-markdown_wiki_highlight_code/vendors/highlight/styles/default.css");

	// Extend js
	elgg_extend_view('js/markdown_wiki/view', 'markdown_wiki_highlight_code/js/view');
	elgg_extend_view('js/markdown_wiki/edit', 'markdown_wiki_highlight_code/js/edit');

	// Parse markdown to search code
	elgg_register_plugin_hook_handler('format', 'markdown:before', 'markdown_wiki_highlight_code_parse');
	
	// Hook for load js
	elgg_register_plugin_hook_handler('view', 'object/markdown_wiki', 'markdown_wiki_highlight_code_hook');
	elgg_register_plugin_hook_handler('view', 'forms/markdown_wiki/edit', 'markdown_wiki_highlight_code_hook');
}

/**
 * Plugin hook handler that parse text to find code block like :
 * ```php
 * echo 'hello !';
 * ```
 * @return string
 */
function markdown_wiki_highlight_code_parse($hook, $entity_type, $returnvalue, $params) {

	function _doFencedCodeBlocks_callback($matches) {
		$langblock = $matches[1];
		$langblock = htmlspecialchars(trim($matches[1]), ENT_NOQUOTES);
		$codeblock = htmlspecialchars($matches[2]);
		$cb = empty($matches[1]) ? "<pre><code>" : "<pre class=\"$langblock\"><code>";
		$cb .= "$codeblock</code></pre>";
		return $cb;
	}

	$text = preg_replace_callback('#(?:~{3,}|`{3,})(.*)\n(.*)(?:~{3,}|`{3,})#sU', '_doFencedCodeBlocks_callback', $params['text']);
	return $text;

}

/**
 * Plugin hook handler called when object markdown_wiki is displayed
 */
function markdown_wiki_highlight_code_hook($hook, $entity_type, $returnvalue, $params) {
	elgg_load_js('highlight');
	elgg_load_css('highlight');
}