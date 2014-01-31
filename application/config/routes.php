<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = 'sitio/index';
$route['404_override'] = '';

/* Sitio publico */
$route['quienes-somos'] = 'sitio/quienes_somos/esp';
$route['mision-y-vision'] = 'sitio/mision_y_vision/esp';
$route['politica-ambiental'] = 'sitio/politica_ambiental/esp';
$route['politica-calidad'] = 'sitio/politica_calidad/esp';
$route['politica-seguridad'] = 'sitio/politica_seguridad/esp';
$route['planta-industrial'] = 'sitio/planta_industrial/esp';
$route['contacto'] = 'sitio/contacto/esp';

$route['who-we-are'] = 'sitio/quienes_somos/eng';
$route['mision-and-vision'] = 'sitio/mision_y_vision/eng';
$route['environmental-policy'] = 'sitio/politica_ambiental/eng';
$route['quality-policy'] = 'sitio/politica_calidad/eng';
$route['security-policy'] = 'sitio/politica_seguridad/eng';
$route['industrial-facilities'] = 'sitio/planta_industrial/eng';
$route['contact'] = 'sitio/contacto/eng';

$route['productos/preview/(:any)'] = 'productos/preview/$1';
$route['productos/imagen/(:any)'] = 'productos/imagen/$1';
$route['productos/imagengaleria/(:any)'] = 'productos/imagenGaleria/$1';

/*admin*/
$route['admin'] = 'user/index';
//$route['admin/signup'] = 'user/signup';
//$route['admin/create_member'] = 'user/create_member';
$route['admin/login'] = 'user/index';
$route['admin/logout'] = 'user/logout';
$route['admin/login/validate_credentials'] = 'user/validate_credentials';

$route['admin/novedades'] = 'admin_novedades/index';
$route['admin/novedades/add'] = 'admin_novedades/add';
$route['admin/novedades/update'] = 'admin_novedades/update';
$route['admin/novedades/update/(:any)'] = 'admin_novedades/update/$1';
$route['admin/novedades/delete/(:any)'] = 'admin_novedades/delete/$1';
$route['admin/novedades/ordenar'] = 'admin_novedades/ordenar';
$route['admin/novedades/(:any)'] = 'admin_novedades/index/$1'; //$1 = page number

$route['admin/categorias_productos'] = 'admin_categorias_productos/index';
$route['admin/categorias_productos/add'] = 'admin_categorias_productos/add';
$route['admin/categorias_productos/update'] = 'admin_categorias_productos/update';
$route['admin/categorias_productos/update/(:any)'] = 'admin_categorias_productos/update/$1';
$route['admin/categorias_productos/delete/(:any)'] = 'admin_categorias_productos/delete/$1';
$route['admin/categorias_productos/pornombre'] = 'admin_categorias_productos/pornombre';
$route['admin/categorias_productos/pornombre/(:any)'] = 'admin_categorias_productos/pornombre/$1';
$route['admin/categorias_productos/(:any)'] = 'admin_categorias_productos/index/$1'; //$1 = page number

$route['admin/productos'] = 'admin_productos/index';
$route['admin/productos/add'] = 'admin_productos/add';
$route['admin/productos/update'] = 'admin_productos/update';
$route['admin/productos/update/(:any)'] = 'admin_productos/update/$1';
$route['admin/productos/delete/(:any)'] = 'admin_productos/delete/$1';
$route['admin/productos/destacadas'] = 'admin_productos/destacadas';
$route['admin/productos/thumbnail'] = 'admin_productos/thumbnail';
$route['admin/productos/thumbnail/(:any)'] = 'admin_productos/thumbnail/$1';
$route['admin/productos/preview'] = 'admin_productos/preview';
$route['admin/productos/preview/(:any)'] = 'admin_productos/preview/$1';
$route['admin/productos/(:any)'] = 'admin_productos/index/$1'; //$1 = page number

$route['admin/mensajes'] = 'admin_mensajes/index';
$route['admin/mensajes/delete/(:any)'] = 'admin_mensajes/delete/$1';
$route['admin/mensajes/view/(:any)'] = 'admin_mensajes/view/$1';
$route['admin/mensajes/(:any)'] = 'admin_mensajes/index/$1'; //$1 = page number

$route['admin/servicios'] = 'admin_servicios/index';
$route['admin/servicios/add'] = 'admin_servicios/add';
$route['admin/servicios/update'] = 'admin_servicios/update';
$route['admin/servicios/update/(:any)'] = 'admin_servicios/update/$1';
$route['admin/servicios/delete/(:any)'] = 'admin_servicios/delete/$1';
$route['admin/servicios/(:any)'] = 'admin_servicios/index/$1'; //$1 = page number

/* End of file routes.php */
/* Location: ./application/config/routes.php */