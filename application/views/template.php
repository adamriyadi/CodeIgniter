<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<?$CI = get_instance();?>
    <title><?=$CI->config->item("site_title");?></title>

	<!--[if lt IE 9]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">var IE7_PNG_SUFFIX = ".png";</script>
	<![endif]-->

	<?php echo $_styles ?>
</head>

<body>
	<?php if(isset($header)) echo $header ;?>
	<?php if(isset($content)) echo $content ;?>
	<?php if(isset($footer)) echo $footer ;?>
	<?php echo $_scripts ?>
</body>
</html>
