<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

class WildController extends AbstractController
{

    /**
     * Show all rows from Program’s entity
     * @Route("/wild", name="lesSeries")
     * @return Response A response instance
     */

    public function index(): Response
    {

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No problem found in program\'s table.'
            );
        }
        return $this->render('wild/index.html.twig', ['programs' => $programs]);
    }

    /**
     * @param string $slug The slugger
     * @return Response
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,
        ]);
    }

    /**
     * @Route("/category/{categoryName}", name="show_category")
     * @return Response
     */

    public function showByCategory(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category ' => $category->getId()], ['id' => 'DESC'], 3);

        return $this->render('wild/category.html.twig',
            ['category' => $categoryName,
                'programs' => $program,
            ]);
    }
    /**
     * @Route("/program/{programName<^[a-z0-9-]+$>}", defaults={"programName" = null}, name="show_program")
     * @param string $programName
     * @return Response
     */
    public function showByProgram(?string $programName): Response
    {
        if (!$programName) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $programName = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($programName)), "-")
        );
        $repositoryProgram = $this->getDoctrine()->getRepository(Program::class);
        $program = $repositoryProgram->findOneBy(
            ['title' => mb_strtolower($programName)
            ]);
        $seasonProgram = $program->getSeasons();
        return $this->render('wild/program.html.twig', [
            'program' => $program,
            'seasons' => $seasonProgram
        ]);
    }
    /**
     * @Route("/season/{id}", name="show_season")
     * @param int $id
     * @return Response
     */
    public function showBySeason(int $id): Response
    {
        $repositorySeason = $this->getDoctrine()->getRepository(Season::class);
        $season = $repositorySeason->find($id);
        $program = $season->getProgram();
        $episode = $season->getEpisodes();
        return $this->render('wild/season.html.twig', [
            'program' => $program,
            'episode' => $episode,
            'season' => $season,
        ]);
    }
    /**
     * @Route("/episode/{id}", name="show_episode")
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(Episode $episode): Response
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();
        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
        ]);
    }
}