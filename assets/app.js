/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

$( document ).ready(function() {
	highlightBestElement(".spm");
	highlightBestElement(".kdr");
	highlightBestElement(".kpm");
	highlightBestElement(".wlp");
	highlightBestElement(".acc");
	highlightBestElement(".lhs");
	highlightBestElement(".rank");
	highlightBestElement(".killstreak");
	highlightBestElement(".timeplayed");
	highlightBestElement(".topWepKills");

	function highlightBestElement(eleName) {
		var bestScore = 0;
		var secondBestScore = 0;
		var thirdBestScore = 0;
		var bestElement = undefined;
		var secondBestElement = undefined;
		var thirdBestElement = undefined;
		$(eleName).each(function() {
			var score = $(this).data("val");
			if (score > bestScore) {
				thirdBestScore = secondBestScore;
				thirdBestElement = secondBestElement;
				secondBestScore = bestScore;
				secondBestElement = bestElement;
				bestScore = score;
				bestElement = $(this);
			}
			else if (score > secondBestScore) {
				thirdBestScore = secondBestScore;
				thirdBestElement = secondBestElement;
				secondBestScore = score;
				secondBestElement = $(this);
			}
			else if (score > thirdBestScore) {
				thirdBestScore = score;
				thirdBestElement = $(this);
			}
		});
		if (bestElement != undefined) {
			bestElement.parent().css("background-color", "#2aa876");
			bestElement.parent().css("color", "white");
			bestElement.parent().css("font-weight", "bold");
		}
		if (secondBestElement != undefined) {
			secondBestElement.parent().css("background-color", "#0a7b83");
			secondBestElement.parent().css("color", "white");
			secondBestElement.parent().css("font-weight", "bold");
		}
		if (thirdBestElement != undefined) {
			thirdBestElement.parent().css("background-color", "#ffd265");
			thirdBestElement.parent().css("color", "black");
			thirdBestElement.parent().css("font-weight", "bold");
		}
	}
});
