<?php

acf_register_block_type(array(
    'name' => 'Session RSVP Popup',
    'title' => 'Session RSVP Popup',
    'render_template' => 'elements-acf/session-rsvp-popup/session-rsvp-popup.php',
    'category' => 'custom blocks',
    'icon' => 'admin-appearance',
    'acf' => array(
        'mode' => 'preview',
        'renderTemplate' => 'session-rsvp-popup.php'
    ),
    'align' => 'full'
));

?>