<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route = array(
    'default_controller'   	=> 'welcome',
    'actived=(:any)'		=> 'auth/access/actived/$1',
    'action/deactivelogin/(:any)' => 'action/deactivelogin/$1',
    'action/activelogin/(:any)' => 'action/activelogin/$1',
    'action/activegateway/(:any)' => 'action/activegateway/$1',
    'action/deactivegateway/(:any)' => 'action/deactivegateway/$1',
    'action/resetpassword/(:any)' => 'action/resetpassword/$1',
    'action/UserDeleted/(:any)' => 'action/UserDeleted/$1',
    'qrscan/enginestarted/(:any)' => 'qrscan/enginestarted/$1',
    'users/makeclient/(:any)' => 'users/makeclient/$1',
    'users/makereseller/(:any)' => 'users/makereseller/$1',
    'users/enablemulti/(:any)' => 'users/enablemulti/$1',
    'users/disablemulti/(:any)' => 'users/disablemulti/$1',
    'api/send' => 'send',
    'api/devices' => 'devicestatus',
    'api/makeurl' => 'makeurl',
    '404_override'         	=> '',
    'translate_uri_dashes' 	=> FALSE
);
