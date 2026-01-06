/*
*
* @package MoT phpBB Diagnosis v0.1.0
* @copyright (c) 2025 - 2026 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) {  // Avoid conflicts with other libraries

'use strict';

/*
* Submit the form if another entry was selected from the log type dropdown select
*/
$("#mot_diagnosis_attachment_select").on('change', function() {
	this.form.submit();
});

})(jQuery); // Avoid conflicts with other libraries
