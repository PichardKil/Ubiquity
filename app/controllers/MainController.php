<?php
namespace controllers;
use models\Basket;
use models\BasketSession;
use models\Product;
use models\Section;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;

/**
  * Controller MainController
  */
class MainController extends ControllerBase{
use WithAuthTrait;


    #[Route('_default',name:'home')]
	public function index(){
        $promos=DAO::getAll(Product::class,'promotion<?', false, [0]);
        $this->loadView("MainController/index.html", ["promos"=>$promos,"paniers"=>USession::get("paniers")]);
	}

    public function initialize() {
        parent::initialize();
        $this->jquery->getHref('a[data-target]','',['ListenerOn'=>'body']);
    }
    protected function getAuthController(): AuthController {
        return new MyAuth($this);
    }
    #[Route('store',name:'store')]
    public function store($content=""){
        $sections=DAO::getAll(Section::class,'', ['products']);
        $product=DAO::getAll(Product::class,'promotion<?', false, [0]);
        //$promoEnCours=$this->loadView('MainController/sectionStore',['product'=>$product], true);
        $this->jquery->renderView('MainController/store.html',['sections'=>$sections,'content'=>$content]);
    }
    #[Route('section/{id}', name:'section')]
    public function sectionStore($id){
        $section=DAO::getById(Section::class,$id,['products']);
        if(!URequest::isAjax()){
            $this->store($this->loadView('MainController/sectionStore.html',['section'=>$section],true));
            return;
        }
        $this->loadView('MainController/sectionStore.html', ['section'=>$section]);
    }

    #[Route('product/{idS}/{idP}',name: 'product')]
    public function product($idS, $idP){
        $section=DAO::getById(Section::class, $idS, false);
        $product=DAO::getById(Product::class, $idP, false);
        if(!URequest::isAjax()){
            $this->store($this->loadView('MainController/product.html',['section'=>$section,'product'=>$product],true));
            return;
        }
        $this->loadView('MainController/product.html',['section'=>$section,'produit'=>$product]);
    }

    #[Route(path: "basket/add/{idProduct}",name: "addArticleToDefaultBasket")]
    public function addArticleToDefaultBasket($idProduct){
        if(USession::get("paniers")){
            $Basketdetails = USession::get("paniers");
        }else{
            $Basketdetails = new BasketSession();
        }
        $Basketdetails->setIdProduct($idProduct);
        $Basketdetails->setQuantity(1);
        USession::set("paniers", $Basketdetails);
        UResponse::header('location', '/');
    }
}
