<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

/** @var \Silex\Application $app */

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage');

$app['feedback.repository'] = function () use ($app) {
    return new \App\Repository\FeedBackRepository($app);
};

$app['feedback.controller'] = function () use ($app) {
    return new \App\Controller\FeedBackController($app['feedback.repository'], $app['twig'], $app['form.factory'], $app['url_generator']);
};

$app->mount("/users", new \App\Controller\Provider\UserProvider());

$app->mount("/feedback", new \App\Controller\Provider\FeedBackProvider());

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
