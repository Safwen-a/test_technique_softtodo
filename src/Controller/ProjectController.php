<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
            'Search' => null,
        ]);
    }
    #[Route('/', name: 'app_project_filter', methods: ['POST'])]
    public function index_filtred(ProjectRepository $projectRepository): Response
    {
        $allproject = $projectRepository->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => array_filter($allproject, function ($x) {
                if (strpos($x->getTitle(), $_POST["search"]) !== false || strpos($x->getFilename(), $_POST["search"]) !== false || strpos($x->getStatus(), $_POST["search"]) !== false)
                    return $x;
            }),
            'Search' => $_POST["search"],
        ]);
    }

    #[Route('/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new (Request $request, ProjectRepository $projectRepository): Response
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $project = new Project();
            $form = $this->createForm(ProjectType::class, $project);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $project->setLastUpdatedDay(date('y-m-d'));
                $projectRepository->save($project, true);

                return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('project/new.html.twig', [
                'project' => $project,
                'form' => $form,
            ]);
        } else
            return $this->redirectToRoute('app_project_index');
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, ProjectRepository $projectRepository): Response
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $form = $this->createForm(ProjectType::class, $project);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $project->setLastUpdated(date('y-m-d'));
                $projectRepository->save($project, true);

                return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('project/edit.html.twig', [
                'project' => $project,
                'form' => $form,
            ]);
        } else
            return $this->redirectToRoute('app_project_index');

    }

    #[Route('/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, ProjectRepository $projectRepository): Response
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
                $projectRepository->remove($project, true);
            }

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        } else
            return $this->redirectToRoute('app_project_index');
    }
}