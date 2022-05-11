<?php

/*
 * --------------------------------------------------------------------
 * Docs module routes definitions
 * --------------------------------------------------------------------
 */
$routes->group('{locale}/docs', ['namespace' => 'Docs\Controllers'], function ($routes) {
	$routes->add('/', 'Docs::index');	
	$routes->add('list', 'Docs::list');
	$routes->add('list/(:num)', 'Docs::listDocument/$1');
	$routes->post('rename', 'Docs::renameDocument');
	$routes->post('delete', 'Docs::deleteDocument');
});