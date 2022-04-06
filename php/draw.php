<?php
function tablecell($celldata) {
	return "<td>".$celldata."</td>";
}
function tablerow($celldata) {
	return "<tr>".$celldata."</tr>\n";
}
function tablehead($celldata) {
	return "<th>".$celldata."</th>\n";
}
function html_heading($celldata,$size) {
	return "<h" . $size . ">".$celldata."</h" . $size  . ">\n";
}
?>
