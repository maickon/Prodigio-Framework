<?php

use core\Router;

// Ajax

Router::addRoute('/send-message', function() {
	Router::controller('MailController@sendMail');
});

/* USER VALIDATE */
Router::addRoute('/login/user', function() {
	Router::controller('LoginController@login');
});

Router::addRoute('/validator/user', function() {
	Router::controller('ValidatorController@user');
});

Router::addRoute('/validator/user/account', function() {
	Router::controller('ValidatorController@userAccount');
});

Router::addRoute('/validator/user/edit', function() {
	Router::controller('ValidatorController@userEdit');
});

Router::addRoute('/validator/user/password', function() {
	Router::controller('ValidatorController@userPassword');
});

/* ITEMS VALIDATE */
Router::addRoute('/validator/item', function() {
	Router::controller('ValidatorController@items');
});

Router::addRoute('/validator/edit-item', function() {
	Router::controller('ValidatorController@editItems');
});


/* WINNERS VALIDATE */
Router::addRoute('/validator/winner', function() {
	Router::controller('ValidatorController@winners');
});

Router::addRoute('/validator/edit-winner', function() {
	Router::controller('ValidatorController@editWinners');
});

/* SORTITIONS VALIDATE */
Router::addRoute('/validator/sortition', function() {
	Router::controller('ValidatorController@sortition');
});

Router::addRoute('/validator/edit-sortition', function() {
	Router::controller('ValidatorController@editSortition');
});

Router::addRoute('/validator/generate-sortition', function() {
	Router::controller('ValidatorController@generate');
});

/* EVENTS VALIDATE */
Router::addRoute('/validator/event', function() {
	Router::controller('ValidatorController@events');
});


/* DEPOIMENTS VALIDATE */
Router::addRoute('/validator/depoiment', function() {
	Router::controller('ValidatorController@depoiments');
});