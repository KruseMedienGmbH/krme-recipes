<?php

declare(strict_types=1);


namespace Deployer;

require_once 'vendor/krme/shopware-platform-tools/recipe/shopware.php';

// Hosts
host('Integration')
    ->set('labels', [
        'stage' => 'integ',
        'env' => 'prod',
    ])
    ->set('hostname', '')
    ->set('domain', '')
    ->set('remote_user', '')
    ->set('http_user', '')
    ->set('http_group', '')
    ->set('deploy_path', '');

host('Production')
    ->set('labels', [
        'stage' => 'prod',
        'env' => 'prod',
    ])
    ->set('hostname', '')
    ->set('domain', '')
    ->set('remote_user', '')
    ->set('http_user', '')
    ->set('http_group', '')
    ->set('deploy_path', '');
