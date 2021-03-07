<?php
namespace controllers;
 use Ubiquity\attributes\items\router\Route;

 /**
  * Controller MainController
  */
class MainController extends ControllerBase{

    #[Route('_default',name:'home')]
    public function index(){
        $this->jquery->renderView("MainController/index.html");
    }

    #[Autowired]
    private OrgaRepository $repo;

    public function setRepo(OrgaRepository $repo): void {
        $this->repo = $repo;
    }
}
