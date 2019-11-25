<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @param string $slug
     * @return Response
     * @Route("/show/{slug}", requirements={"slug"="[a-z0-9-]+"}, name="wild_show")
     */
    public function show(string $slug): Response
    {
        $slug = ucwords(strtolower($slug));

        foreach (array('-', '\'') as $delimiter) {
            if (strpos($slug, $delimiter) !== false) {
                $slug = implode($delimiter, array_map('ucfirst', explode($delimiter, $slug)));
            }

            return $this->render('wild-series/show.html.twig',
                [
                    'slug' => $slug
                ]);

        }

    }
}
