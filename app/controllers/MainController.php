<?php
namespace controllers;
 use services\ui\UIGroups;
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
    public function initialize() {
        $this->ui=new UIGroups($this);
        parent::initialize();
    }

    #[Get('new/user', name: 'new.user')]
    public function newUser(){
        $this->ui->newUser('frm-user');
        $this->jquery->renderView('main/vForm.html',['formName'=>'frm-user']);
    }

    #[Post('new/user', name: 'new.userPost')]
    public function newUserPost(){
        $idOrga=USession::get('idOrga');
        $orga=DAO::getById(Organization::class,$idOrga,false);
        $user=new User();
        URequest::setValuesToObject($user);
        $user->setEmail(\strtolower($user->getFirstname().'.'.$user->getLastname().'@'.$orga->getDomain()));
        $user->setOrganization($orga);
        if(DAO::insert($user)){
            $count=DAO::count(User::class,'idOrganization= ?',[$idOrga]);
            $this->jquery->execAtLast('$("#users-count").html("'.$count.'")');
            $this->showMessage("Ajout d'utilisateur","L'utilisateur $user a été ajouté à l'organisation.",'success','check square outline');
        }else{
            $this->showMessage("Ajout d'utilisateur","Aucun utilisateur n'a été ajouté",'error','warning circle');
        }
    }
}
