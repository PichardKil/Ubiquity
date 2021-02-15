<?php
namespace controllers;

use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\orm\DAO;
use models\Organization;
use Ubiquity\orm\repositories\ViewRepository;

/**
 * Controller OrgaController
 **/
class OrgaController extends ControllerBase{

  private ViewRepository $repo;

  public function initialize() {
    parent::initialize();
    $this->repo=new ViewRepository($this,Organization::class);
  }

  #[Route('orga')]
  public function index(){
    $orgas=DAO::getAll(Organization::class);
    $this->repo->all("",false);
    $this->loadView("OrgaController/index.html",['all'=>$orgas]);
  }

  #[Route(path: "orga/{idOrga}",name: "orga.getOne")]
  public function getOne($idOrga) {
    $this->repo->byId($idOrga,['users.groupes','groupes.users'],viewVar: 'orgaGetOne');
    $this->loadDefaultView();
  }

  #[Post(path: "orga/add",name: "orga.add")]
  public function add() {
    $orga=new Organization();
    URequest::setValuesToObject($orga);
    if(DAO::insert($orga)) {
      console.log("Insertion réussie");
    }
  }

  #[Post(path: "orga/update/{idOrga}",name: "orga.update")]
  public function update($idOrga) {
    $orga=DAO::getById(Organization::class,$idOrga);
    URequest::setValuesToObject($orga);
    if(DAO::update($orga)){
      console.log("Mise à jour réussie");
    }
  }

  #[Post(path: "orga/delete/{idOrga}",name: "orga.delete")]
  public function delete($idOrga) {
    $orga=DAO::getById(Organization::class,$idOrga);
    if(DAO::remove($orga)){
      console.log("Suppression réussie");
    }
  }
}
