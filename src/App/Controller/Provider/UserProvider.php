<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.10.17
 * Time: 16:07
 */

namespace App\Controller\Provider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class UserProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $users = $app["controllers_factory"];

        $users->get("/", "App\\Controller\\UserController::index");

        $users->post("/", "App\\Controller\\UserController::store");

        $users->get("/{id}", "App\\Controller\\UserController::show")
            ->assert('id', '\d+');

        $users->get("/edit/{id}", "App\\Controller\\UserController::edit")
            ->assert('id', '\d+');

        $users->put("/{id}", "App\\Controller\\UserController::update")
            ->assert('id', '\d+');

        $users->delete("/{id}", "App\\Controller\\UserController::destroy")
            ->assert('id', '\d+');

        return $users;
    }
}
