<?php
/**
 * Created by PhpStorm.
 * FeedBackProvider: sergey
 * Date: 10.10.17
 * Time: 15:53
 */

namespace App\Controller\Provider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class FeedBackProvider implements ControllerProviderInterface
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
        $feedback = $app["controllers_factory"];

        $feedback->get("/", "feedback.controller:index")
            ->bind('list_feedback');

        $feedback->post("/new", "feedback.controller:store");

        $feedback->get("/new", "feedback.controller:store")
            ->bind('new_feedback');

        $feedback->get("/{id}", "feedback.controller:show")
            ->assert('id', '\d+')
            ->bind('show_feedback');

        $feedback->get("/edit/{id}", "feedback.controller:edit")
            ->assert('id', '\d+')
            ->bind('edit_feedback');

        $feedback->post("/edit/{id}", "feedback.controller:edit")
            ->assert('id', '\d+');

        $feedback->put("/{id}", "feedback.controller:update")
            ->assert('id', '\d+');

        $feedback->post("/del/{id}", "feedback.controller:destroy")
            ->assert('id', '\d+')
            ->bind('delete_feedback');

        return $feedback;
    }
}
