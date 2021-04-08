<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{

    /**
     * @Route("/api/projects", name="api_projects_list")
     */
    public function listProjects(Request $request, ProjectRepository $projectRepository)
    {
        $projectsJson = $serializer->serialize($projects, 'json'); 
        return new JsonResponse($projectsJson, 200, [], true);
    }
}