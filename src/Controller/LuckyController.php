<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController
{
     /**
     * @Route("/homepage/{name}")
     */
     public function homepage($name): Response
     {
         return new Response(
             '<html><body>This is the homepage, Welcome '.$name.'! </body></html>'
         );
     }
 
     /**
     * @Route("/usersView/{age}/{name}")
     */
    public function usersView(int $age, string $name): Response
    {
        return $this->render('usersView/usersView.html.twig',
            [
                'age' => $age,
                'name' => $name
        ]);
    }
}
?>