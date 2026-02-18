/*
*
* @package MoT phpBB Diagnosis v0.3.0
* @copyright (c) 2025 - 2026 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries
	'use strict';

	$('#loading_indicator').hide();

	/*
	* Submit the form if another entry was selected from the attachment type dropdown select
	*/
	$("#mot_diagnosis_attachment_select").on('change', function() {
		// Show the loading indicator to signal that something is happening
		$('#loading_indicator').show();
		// Submit the form
		this.form.submit();
	});

	$("#mot_diagnosis_item_sort_go, #mot_diagnosis_file_sort_go, #mot_diagnosis_attm_refresh").on('click', function() {
		$('#loading_indicator').show();
	});
})(jQuery);
