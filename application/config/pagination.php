<?php

$config['num_links']			= 3;
$config['use_page_numbers']		= TRUE;
$config['page_query_string']	= TRUE;
$config['uri_segment']			= 4;
$config['query_string_segment'] = "page";

$config['full_tag_open']	= '<div style="width:100%;text-align:right;"><ul class="pagination pagination-sm">';
$config['full_tag_close']	= '</ul></div>';

$config['first_link']		= '<span class=" icon-step-backward"></span>';
$config['first_tag_open']	= '<li>';
$config['first_tag_close']	= '</li>';

$config['last_link']		= '<span class="icon-step-forward"></span>';
$config['last_tag_open']	= '<li>';
$config['last_tag_close']	= '</li>';

//$config['next_link']		= '&gt;';
$config['next_link']		= false;
$config['next_tag_open']	= '<li>';
$config['next_tag_close']	= '</li>';

//$config['prev_link']		= '&lt;';
$config['prev_link']		= false;
$config['prev_tag_open']	= '<li>';
$config['prev_tag_close']	= '</li>';

$config['cur_tag_open']		= '<li class="active"><a href="#">';
$config['cur_tag_close']	= '</a></li>';

$config['num_tag_open']		= '<li>';
$config['num_tag_close']	= '</li>';

$config['display_pages']	= TRUE;