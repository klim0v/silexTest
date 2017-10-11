<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.10.17
 * Time: 15:56
 */

namespace App\Controller;

use App\Form\FeedBackDeleteType;
use App\Form\FeedBackType;
use App\Repository\FeedBackRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGenerator;

class FeedBackController
{
    protected $repo;
    protected $template;
    protected $formFactory;
    protected $urlGenerator;
    protected $flashBag;

    public function __construct(FeedBackRepository $repo, \Twig_Environment $template, FormFactory $formFactory, UrlGenerator $urlGenerator, FlashBag $flashBag)
    {
        $this->repo = $repo;
        $this->template = $template;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->flashBag = $flashBag;
    }
    public function index()
    {
        $data = $this->repo->findAll();
        return $this->template->render('feedback/strips.html.twig', array(
            'data' => $data,
        ));
    }

    public function edit(Request $request, $id)
    {
        $feedback = $this->repo->find($id);
        if (empty($feedback)) {
            throw new NotFoundHttpException(sprintf('Unable to find feedback by ID "%s".', $id));
        }
        $form = $this->formFactory->createBuilder(FeedBackType::class, $feedback)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->set($form->getData());
            $this->flashBag->add('success', 'Success edited!');
            return new RedirectResponse($this->urlGenerator->generate("show_feedback", ['id' => $id]));
        }


        return $this->template->render('feedback/edit.html.twig', array(
            'feedback_form' => $form->createView()
        ));
    }

    public function show($id)
    {
        $feedback = $this->repo->find($id);
        if (empty($feedback)) {
            throw new NotFoundHttpException(sprintf('Unable to find feedback by ID "%s".', $id));
        }
        $form = $this->formFactory->createBuilder(FeedBackDeleteType::class, ['id' => $id], [
            'action' => $this->urlGenerator->generate("delete_feedback", [
                'id'    => $id,
            ]),
            'method' => 'post'
        ])->getForm();
        return $this->template->render('feedback/show.html.twig', array(
            'feedback' => $feedback,
            'delete_form' => $form->createView()
        ));
    }

    public function store(Request $request)
    {
        $form = $this->formFactory->createBuilder(FeedBackType::class)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->set($form->getData());
            $this->flashBag->add('success', 'Success created!');
            return new RedirectResponse($this->urlGenerator->generate("list_feedback"));
        }

        return $this->template->render('feedback/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function update($id)
    {
        // update the user #id, using PUT method
    }

    public function destroy(Request $request, $id)
    {
        $feedback = $this->repo->find($id);
        if (empty($feedback)) {
            throw new NotFoundHttpException(sprintf('Unable to find feedback by ID "%s".', $id));
        }
        $form = $this->formFactory->createBuilder(FeedBackDeleteType::class, ['id' => $id])->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->repo->del($id);
            $this->flashBag->add('success', 'Success deleted!!');
            return new RedirectResponse($this->urlGenerator->generate("list_feedback"));
        }
        $this->flashBag->add('error', 'Error created!');
        return new RedirectResponse($this->urlGenerator->generate("show_feedback", ['id' => $id]));
    }
}
