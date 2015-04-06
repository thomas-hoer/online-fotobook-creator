<html>
<head>
<title></title>
<script type="text/javascript" src="js/jquery-2.1.3.js"> </script>
<script type="text/javascript" src="js/jquery-ui.js"> </script>
<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="js/jquery-rotate.js"> </script>
<script type="text/javascript" src="js/pictures.php?bid=<?php echo intval($_REQUEST['id']); ?>"> </script>
<script type="text/javascript" src="js/photobook.js"> </script>
<script type="text/javascript" src="js/upload.js"> </script>
<script type="text/javascript" src="js/resize.js"> </script>
<link rel="stylesheet" type="text/css" href="css/photobook.css"/>
</head>
<body>
<div class="pictures">
<div>Drop down your Pictures here</div>
</div>
<div class="menu">
<img src="gfx/icon_arrow.png" title="Select" class="menu_button button_arrow selected" />
<img src="gfx/icon_text.png" title="Text" class="menu_button button_text" />
<img src="gfx/menu_separator.png"/>
<img src="gfx/icon_layer_bottom.png" title="Move to bottom" class="menu_button button_layer_bottom" />
<img src="gfx/icon_layer_down.png" title="Move one layer down" class="menu_button button_layer_down" />
<img src="gfx/icon_layer_up.png" title="Move one layer up" class="menu_button button_layer_up" />
<img src="gfx/icon_layer_top.png" title="Move to top" class="menu_button button_layer_top" />
<img src="gfx/icon_prev_page.png" title="Previous Page" class="menu_button button_prev_page" />
<img src="gfx/icon_next_page.png" title="Next Page" class="menu_button button_next_page" />
<img src="gfx/icon_zoom_in.png" title="Zoom In" class="menu_button button_zoom_in" />
<img src="gfx/icon_zoom_out.png" title="Zoom Out" class="menu_button button_zoom_out" />
<img src="gfx/menu_separator.png"/>

<select onchange="fontEditor(this[this.selectedIndex].value)">
    <option value="Arial">Arial</option>
    <option value="Calibri">Calibri</option>
    <option value="Comic Sans MS">Comic Sans MS</option>
</select>
<img src="gfx/icon_text_bold.png" title="Bold" class="menu_button button_text_bold" />
<img src="gfx/icon_text_italic.png" title="Italic" class="menu_button button_text_italic" />
<img src="gfx/icon_text_underline.png" title="Underlined" class="menu_button button_text_underline" />
<select class="fontsize" onchange="textSizeEditor(this[this.selectedIndex].value)">
    <option value="8">8</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="14">14</option>
    <option value="16">16</option>
    <option value="18">18</option>
    <option value="20">20</option>
    <option value="22">22</option>
    <option value="24">24</option>
    <option value="28">28</option>
    <option value="32">32</option>
    <option value="48">48</option>
    <option value="72">72</option>
    <option value="96">96</option>
</select>

<div class="pagetitle">Page 1</div>
<a class="logout" href="action?type=logout">Logout</a>
</div>
<div class="upload-status"></div>
<div class="content">
	<div class="book"></div>
	<div class="pageseparator"></div>
</div>
</body>
</html>