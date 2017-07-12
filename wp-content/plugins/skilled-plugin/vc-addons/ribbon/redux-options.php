<?php
$textdomain = SCP_TEXT_DOMAIN;

$sections[] = array(
        'title' => __('Calendar Widget', $textdomain),
        'subsection' => true,
        'fields' => array(

        	array(
			    'id'          => 'dntp-calendar-widget-title-typography',
			    'type'        => 'typography', 
			    'title'       => __('Title Typography', $textdomain),
			    'google'      => true, 
			    'font-backup' => true,
			    'output'      => array('.dntp-calendar-widget .title'),
			    'units'       =>'px',
			    'default'     => array(
			        'color'       => '#333', 
			        'font-style'  => '700', 
			        'font-family' => 'Abel', 
			        'google'      => true,
			        'font-size'   => '33px', 
			        'line-height' => '40px'
			    ),
			),
		

    	)
    );
