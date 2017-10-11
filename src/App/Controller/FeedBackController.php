<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.10.17
 * Time: 15:56
 */

namespace App\Controller;

use App\Form\FeedBackType;
use App\Repository\FeedBackRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;

class FeedBackController
{
    protected $repo;
    protected $template;
    protected $formFactory;
    protected $urlGenerator;

    public function __construct(FeedBackRepository $repo, \Twig_Environment $template, FormFactory $formFactory, UrlGenerator $urlGenerator)
    {
        $this->repo = $repo;
        $this->template = $template;
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
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
        $form = $this->formFactory->createBuilder(FeedBackType::class, $feedback)->getForm();
        $success = false;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->set($form->getData());
            $success = true;
        }


        return $this->template->render('feedback/edit.html.twig', array(
            'form' => $form->createView(),
            'success' => $success
        ));
    }

    public function show($id)
    {
        $feedback = $this->repo->find($id);
        return $this->template->render('feedback/show.html.twig', array(
            'feedback' => $feedback,
        ));
    }

    public function store(Request $request)
    {
        $form = $this->formFactory->createBuilder(FeedBackType::class)->getForm();
        $success = false;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->set($form->getData());
            $success = true;
        }

        return $this->template->render('feedback/edit.html.twig', array(
            'form' => $form->createView(),
            'success' => $success
        ));
    }

    public function update($id)
    {
        // update the user #id, using PUT method
    }

    public function destroy($id)
    {

        // delete the user #id, using DELETE method
        $this->repo->del($id);
        return new RedirectResponse($this->urlGenerator->generate("list_feedback"));
    }
}
