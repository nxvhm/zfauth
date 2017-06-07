<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */


use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;



return [
    # Session configuration.
    'session_config' => [
        # Session cookie expiration in 30 mins.
        'cookie_lifetime' => 60*30*1,     
        # Session data will be stored on server maximum for 20 days.
        'gc_maxlifetime'     => 60*60*24*20, 
    ],
    # Session manager configuration.
    'session_manager' => [
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    # Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],



];
