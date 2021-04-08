<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/list", name="list_project")
     */
    public function list(ProjectRepository $projectRepository):Response

    {
        $projects = $projectRepository->findAll();
        return $this->render('project/list.html.twig', [
            'project' => $projects,
        ]);
    }

    /**
     * @Route("/add_project", name="project-add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project->setStartedAt(new \DateTime());
            $project->setStatut("Nouveau");
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('list_project');
        }

        return $this->render('project/add.html.twig', [
            'projectForm' => $form->createView()
        ]);
    }


     /**
     * @Route("/add_task", name="add_task")
     * @param Request $request
     */
    public function addTask(Request $request, EntityManagerInterface $entityManager,TaskRepository $taskRepository)
    {
        if ($request->getMethod() == 'POST') {
            $projectId = 1; 
            $task = $taskRepository->findBy(['id' => $projectId]);;
            $title = $request->request->get('title');
            $description = $request->request->get('description');

            $task = new Task();
            $task->setTitle($title);
            $task->setDescription($description);
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('list_project');
        }
        return $this->render('task/add.html.twig');
    }


     /**
     * @Route("/gerer/{id}", name="gerer_project")
     */
    public function gerer($id, ProjectRepository $projectRepository):Response

    {
        $projects = $projectRepository->find($id);
        return $this->render('project/gerer.html.twig', [
            'project' => $projects,
        ]);
    }
}
