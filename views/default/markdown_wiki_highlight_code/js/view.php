
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki_highlight_code
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki_highlight_code
 *
 *	Elgg-markdown_wiki_highlight_code view javascript file
 **/

/**
 * Elgg-markdown_wiki_highlight_code view initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki_highlight_code.view');

elgg.markdown_wiki_highlight_code.view.init = function() {
	$(document).ready(function() {
		hljs.initHighlightingOnLoad();
	});
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki_highlight_code.view.init);

// End of js view for elgg-markdown_wiki_highlight_code plugin

