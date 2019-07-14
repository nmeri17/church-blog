<?php
class Templating_Engine {
	/**
	* @Description: Accepts an array and template file and produces a view file parsed against the given array.
	* @Param; $variables_arr: An array of key value pairs where keys match placeholders in the view while * * * values match desired markup.
	* @Param; $template_file: Holds the view/template file.
	*/
	public $template_file;
	public $final_page;
	protected $variables_arr;

	public function __construct (array $variables_arr, $template_file) {
		$this->template_file = file_get_contents($template_file);
		$this->variables_arr = $variables_arr;

		// Assign the fully parsed page to final_page property
		$this->final_page = preg_replace_callback("/(\{\{([a-z_]+)\}\})/i", "Templating_Engine::recursive_replace", $this->template_file);

	}

		/** @Description: Attempts to swap out placeholders in the view with their corresponding markup values * in the $variables_arr.
		* @Param: Not user supplied. An array that holds each captured group (patterns in parenthesis) and * * * indexed by the number of groups matched.
		* @Return: NULL. Exits when all strings supplied in the "Subject" have been exhausted (replaced or * * * returned as the case may be).
		*/
	private function recursive_replace ($match_arr) {

		if (array_key_exists("$match_arr[2]", $this->variables_arr)) {
			return preg_replace_callback('/(\{\{([a-z_]+)\}\})/i', "Templating_Engine::recursive_replace", $this->variables_arr["$match_arr[2]"]);
		}

		/** If the placeholder does not exist in the supplied array, discard the placeholder
		* Intended to weed out alternate syntax.
		*/
		else return '';
	}
}
/** How the recursion works in essence is:
* If a match is found, it is supplied as an argument to the callback.
* So for instance, we have a variables array key like so:
* =====================================================
* $variables_arr['admin_menu'] = "<ul>

			<li> <a href='../a/comments?u={{username}}><i class='fa fa-comments'></i> view my comments </a></li>

			<li> <a href='../a/mentions?u={{username}}> <span style='font-weight: bold;'>@ </span>my mentions </a> </li>

			<li> <a href='../preferences/'><i class='fa fa-cog'></i> account settings </a> </li>

			<li> <a href='javascript:mA();'> <i class='fa fa-music' aria-hidden='true'></i> mute score </a> </li>

			</ul>
* ====================================================
* When the array is supplied, it matches key 'admin_menu' and REPLACES THAT KEY WITH THE VALUE CORRESPONDING * * TO IT IN THE VARIABLES ARRAY.
* It further throws that value to the function as a "subject" (This magic happens on the 3rd parameter, the * * "subject"). We run the same pattern against it and it hits another match, REPLACES THAT MATCH WITH ITS * * * * CORESSPONDING VALUE IN THE VARIABLES ARRAY. And so on and so forth--till a string is supplied but there are * no matches (i.e. against the pattern), then the string is returned as is (no replacement is done).
*
* The important thing to note is that the preg_replace_callback returns a string as is, if no matches are * * * found in it so by recursing a given string, it always returns the 'subject' string unchanged if no matches * * are found or returns the same function if it is found--with itself as the new "subject"--until there are no * more matches.
**/
?>