<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Mainpage');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Mainpage::index');
$routes->get('bulmatest', 'Mainpage::debugView');
$routes->post('login', 'Accounts::login');
$routes->get('login', 'Mainpage::redirectHome');
$routes->match(['get', 'post'], 'logoff', 'Accounts::logoff');
$routes->match(['get', 'post'], 'login/(:any)', 'Mainpage::redirectHome');
$routes->match(['get', 'post'], 'painel', 'Accounts::userPainel');
$routes->match(['get', 'post'], 'search', 'MainSearch::findAll');
$routes->match(['get', 'post'], 'search/showalbum/(:num)', 'MainSearch::showAlbum/$1');
$routes->match(['get', 'post'], 'search/showalbum/(:any)', 'Mainpage::redirectHome');
$routes->match(['get', 'post'], 'search/showalbum', 'Mainpage::redirectHome');
$routes->match(['get', 'post'], 'search/(:any)', 'Mainpage::redirectHome');
$routes->match(['get', 'post'], 'collection/(:num)', 'MainSearch::showCollection/$1');
$routes->match(['get', 'post'], 'collection/(:any)', 'Mainpage::redirectHome');
$routes->match(['get', 'post'], 'collection', 'Mainpage::redirectHome');
$routes->post('updaterating', 'DataManipulation::updateRanking');
$routes->get('updaterating', 'Mainpage::redirectHome');
$routes->post('updatereview', 'DataManipulation::updateReview');
$routes->get('updatereview', 'Mainpage::redirectHome');
$routes->post('updatecollection', 'DataManipulation::updateCollection');
$routes->get('updatecollection', 'Mainpage::redirectHome');
$routes->post('insertcollection', 'DataManipulation::createCollection');
$routes->get('insertcollection', 'Mainpage::redirectHome');
$routes->post('togglecollectionvisibility', 'DataManipulation::toggleCollectionVisibility');
$routes->get('togglecollectionvisibility', 'Mainpage::redirectHome');
$routes->post('deletecollection', 'DataManipulation::deleteCollection');
$routes->get('deletecollection', 'Mainpage::redirectHome');
$routes->get('(:any)', 'Mainpage::view/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
