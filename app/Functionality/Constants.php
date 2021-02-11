<?php


namespace App\Functionality;


class Constants
{

    const priorities = [
        1 => 'Высокий',
        2 => 'Нормальный',
        3 => 'Низкий'
    ];

    const excludedRoutes = [
        'ignition.healthCheck',
        'ignition.executeSolution',
        'ignition.shareReport',
        'ignition.scripts',
        'ignition.styles',
        'login',
        'logout',
        'change_password',
        'home'
    ];
}
