<?php

use core\Router;

// API USERS

Router::addRoute('/v1/users', function() {
	Router::controller('ApiUserController@all');
});

Router::addRoute('/v1/users/delete/{id}', function() {
	Router::controller('ApiUserController@delete');
});

Router::addRoute('/v1/users/save', function() {
	Router::controller('ApiUserController@save');
});

Router::addRoute('/v1/users/register', function() {
	Router::controller('ApiUserController@register');
});

Router::addRoute('/v1/users/find/{id}', function() {
	Router::controller('ApiUserController@find');
});

Router::addRoute('/v1/users/findby/{name}/{value}', function() {
	Router::controller('ApiUserController@findBy');
});

Router::addRoute('/v1/users/update', function() {
	Router::controller('ApiUserController@edit');
});

Router::addRoute('/v1/users/update-password', function() {
	Router::controller('ApiUserController@editPassword');
});

Router::addRoute('/v1/users/recover-password', function() {
	Router::controller('ApiUserController@recoverPassword');
});


// API SORTITIONS
Router::addRoute('/v1/sortitions', function() {
	Router::controller('ApiSortitionController@all');
});

Router::addRoute('/v1/sortitions/delete/{id}', function() {
	Router::controller('ApiSortitionController@delete');
});

Router::addRoute('/v1/sortitions/save', function() {
	Router::controller('ApiSortitionController@save');
});

Router::addRoute('/v1/sortitions/find/{id}', function() {
	Router::controller('ApiSortitionController@find');
});

Router::addRoute('/v1/sortitions/findby/{name}/{value}', function() {
	Router::controller('ApiSortitionController@findBy');
});

Router::addRoute('/v1/sortitions/update', function() {
	Router::controller('ApiSortitionController@edit');
});

Router::addRoute('/v1/sortitions/generate/resolve-pix-payment', function() {
	Router::controller('ApiSortitionController@resolvePixPayment');
});

Router::addRoute('/v1/sortitions/generate/private-tickets', function() {
	Router::controller('ApiSortitionController@generatePrivateTickets');
});

Router::addRoute('/v1/sortitions/tickets/request', function() {
	Router::controller('ApiSortitionController@pixRequest');
});

Router::addRoute('/v1/sortitions/tickets/to-print', function() {
	Router::controller('ApiSortitionController@ticketsToPrint');
});

Router::addRoute('/v1/sortitions/see-tickets', function() {
	Router::controller('ApiSortitionController@seeTickets');
});

// API ITENS
Router::addRoute('/v1/itens', function() {
	Router::controller('ApiItemController@all');
});

Router::addRoute('/v1/itens/delete/{id}', function() {
	Router::controller('ApiItemController@delete');
});

Router::addRoute('/v1/itens/save', function() {
	Router::controller('ApiItemController@save');
});

Router::addRoute('/v1/itens/find/{id}', function() {
	Router::controller('ApiItemController@find');
});

Router::addRoute('/v1/itens/findby/{name}/{value}', function() {
	Router::controller('ApiItemController@findBy');
});

Router::addRoute('/v1/itens/update', function() {
	Router::controller('ApiItemController@edit');
});

// API EVENTS
Router::addRoute('/v1/events', function() {
	Router::controller('ApiEventController@all');
});

Router::addRoute('/v1/events/delete/{id}', function() {
	Router::controller('ApiEventController@delete');
});

Router::addRoute('/v1/events/save', function() {
	Router::controller('ApiEventController@save');
});

Router::addRoute('/v1/events/find/{id}', function() {
	Router::controller('ApiEventController@find');
});

Router::addRoute('/v1/events/findby/{name}/{value}', function() {
	Router::controller('ApiEventController@findBy');
});

Router::addRoute('/v1/events/update', function() {
	Router::controller('ApiEventController@edit');
});

Router::addRoute('/v1/events/update-status', function() {
	Router::controller('ApiEventController@updatePaymentStatus');
});

Router::addRoute('/v1/events/check-and-update-status', function() {
	Router::controller('ApiEventController@checkAndUpdatePaymentStatus');
});

Router::addRoute('/v1/events/users/check-and-update-status/{paymentId}', function() {
	Router::controller('ApiEventController@checkAndUpdatePaymentStatusById');
});

Router::addRoute('/v1/events/delete/tickets', function() {
	Router::controller('ApiEventController@deleteExpiredTicket');
});

Router::addRoute('/v1/events/tickets/webhook', function() {
	Router::controller('ApiEventController@updatePaymentByWebhook');
});

Router::addRoute('/v1/events/tickets/check-payment/{id}', function() {
	Router::controller('ApiEventController@checkPaymentMP');
});

Router::addRoute('/v1/events/tickets/api/check-payment/{id}', function() {
	Router::controller('ApiEventController@checkPaymentAPI');
});

Router::addRoute('/v1/events/aprove/tickets', function() {
	Router::controller('ApiEventController@aproveTicket');
});

// API DEPOIMENTS
Router::addRoute('/v1/depoiments', function() {
	Router::controller('ApiDepoimentController@all');
});

Router::addRoute('/v1/depoiments/delete/{id}', function() {
	Router::controller('ApiDepoimentController@delete');
});

Router::addRoute('/v1/depoiments/save', function() {
	Router::controller('ApiDepoimentController@save');
});

Router::addRoute('/v1/depoiments/find/{id}', function() {
	Router::controller('ApiDepoimentController@find');
});

Router::addRoute('/v1/depoiments/findby/{name}/{value}', function() {
	Router::controller('ApiDepoimentController@findBy');
});

Router::addRoute('/v1/depoiments/update', function() {
	Router::controller('ApiDepoimentController@edit');
});

// API WINNER
Router::addRoute('/v1/winners', function() {
	Router::controller('ApiWinnerController@all');
});

Router::addRoute('/v1/winners/delete/{id}', function() {
	Router::controller('ApiWinnerController@delete');
});

Router::addRoute('/v1/winners/save', function() {
	Router::controller('ApiWinnerController@save');
});

Router::addRoute('/v1/winners/update', function() {
	Router::controller('ApiWinnerController@edit');
});