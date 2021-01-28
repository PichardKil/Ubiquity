<?php
namespace controllers;
use Ubiquity\attributes\items\router\Get;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Route;

 /**
 * Controller TodoController
 **/
class TodoController extends ControllerBase{
  #[Route(path: "_default",name: "home")]
  public function index(){}





	#[Post(path: "todo/loadList/",name: "todo.loadListPost")]
	public function loadListFromForm(){

	}

#[Get(path: "todo/loadList/{uniqid}",name: "todo.loadList")]
	public function loadList(int $uniqid){

}

  #[Get(path: "todo/saveList",name: "todo.save")]
  public function saveList(){

  }
	#[Post(path: "todo/new/{force}",name: "todo.new")]
	public function newlist(int $force){

	}


	#[Post(path: "todo/addElement",name: "todo.add")]
	public function addElement(){

	}


	#[Get(path: "todo/deleteElement/{index}",name: "todo.delete")]
	public function deleteElement($index){

	}


	#[Post(path: "todo/editElement/{index}",name: "todo.edit")]
	public function editElement($index){

	}

}
