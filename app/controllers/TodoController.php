<?php
namespace controllers;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\controllers\Router;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;
/**
 * Controller TodoController
 * @property \Ajax\php\ubiquity\JsUtils $jquery
 */
class TodoController extends ControllerBase{

  const CACHE_KEY = 'datas/lists/';
  const EMPTY_LIST_ID='not saved';
  const LIST_SESSION_KEY='list';
  const ACTIVE_LIST_SESSION_KEY='active-list';

  public function initialize(){
    parent::initialize();
    $this->menu();
    //$this->displayList("a","b");
  }

  #[Route(path: "/_default/", name : "home")]
  public function index(){
    if(USession::exists(self::LIST_SESSION_KEY)){
      $list = USession::get(self::LIST_SESSION_KEY, []);
      return $this->displayList($list);
    }
    $this->showMessage('Bonjour', "Todolist permet de gerer des listes", 'info', 'info circle',
      [['url' =>Router::path('todo.new'),'caption'=>'Créer une nouvelle liste','style'=>'basic inverted']]);
  }

  #[Post(path: "todo/add", name: "todo.add")]
  public function addElement(){

    $list=USession::get(self::LIST_SESSION_KEY);
    if(URequest::filled('elements')){
      $elements = explode("\n", URequest::post('elements'));
      foreach ($elements as $elm){
        $list[] = $elm;
      }
    }else{
      $list[] = URequest::post('element');
    }
    $this->showMessage('Element ajouté', "Element correctement ajouté à la liste", 'info', 'check square');
    USession::set(self::LIST_SESSION_KEY, $list);
    $this->displayList($list);
  }


  #[Get(path: "todo/delete/{index}", name : "todo.delete")]
  public function deleteElement($index){

  }


  #[Post(path: "todo/edit/{index}",name: "todo.edit")]
  public function editElement($index){

  }


  #[Get(path: "todo/loadList/{uniqid}", name: "todo.loadList")]
  public function loadList($uniqid){

  }


  #[Post(path: "todo/loadList", name : "todo.loadListPost")]
  public function loadListFromForm(){

  }


  #[Get(path: "todo/new/{force}", name: "todo.new")]
  public function newlist($force = false){
    if($force != false | !USession::exists(self::LIST_SESSION_KEY)){
      USession::set(self::LIST_SESSION_KEY, []);
      $this->displayList(USession::get(self::LIST_SESSION_KEY));
    }else if(USession::exists(self::LIST_SESSION_KEY)) {
      $this->showMessage("Nouvelle Liste", "Une liste existe déjà. Voulez vous la vider ?", "", "",
        [['url' =>Router::path('todo.new/1'),'caption'=>'Créer une nouvelle liste','style'=>'basic inverted'],
          ['url' =>Router::path('todo.menu'),'caption'=>'Annuler','style'=>'basic inverted']]);
      $this->displayList(USession::get(self::LIST_SESSION_KEY));
    }
  }


  #[Get(path: "todo/saveList", name : "todo.save")]
  public function saveList(){

  }

  private function menu(){

    $this->loadView('TodoController/menu.html');

  }

  private function displayList($list){
    if(\count($list)>0){
      $this->jquery->show('._saveList','','',false);
    }
    $this->jquery->change('#multiple', '$("._form").toggle();');
    $this->jquery->click(".buttonEdit", '$(".item" + this.id).toggle();');
    $this->jquery->renderView('TodoController/display.html', ['list'=>$list]);
  }

  private function showMessage(string $header,string $message,string $type = 'info',string $icon = 'info',array $buttons = []){
    $this->loadView('TodoController/message.html',
      compact('header', 'message','type', 'icon', 'buttons'));
  }

}
