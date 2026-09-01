<?php

get_header(); ?>

<div class="p-t-150">
	<h1>Event Registration</h1>
	dsfasdfs
</div><?php


if(!isset($_COOKIE['woocommerce_cart_hash'])) {
  echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
  echo "Cookie '" . $cookie_name . "' is set!<br>";
  echo "Value is: " . $_COOKIE['woocommerce_cart_hash'];
}

get_footer(); ?>