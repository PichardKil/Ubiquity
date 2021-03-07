<?php
namespace services\ui;

use Ajax\semantic\html\collections\form\HtmlForm;
use Ajax\semantic\widgets\dataform\DataForm;
use models\Group;
use models\User;
use Ubiquity\controllers\Controller;
use Ubiquity\controllers\Router;

/**
 * Class UIGroups
 */
class UIGroups extends \Ajax\php\ubiquity\UIService{
    public function __construct(Controller $controller){
        parent::__construct($controller);
        $this->jquery->getHref('a[data-target]',
            parameters: ['historize'=>false,'hasLoader'=>'internal','listenerOn'=>'body']);
    }
    private function addFormBehavior(string $formName,HtmlForm|DataForm $frm,string $responseElement,string $postUrlName){
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $this->jquery->click("#$formName-div ._validate",'$("#'.$formName.'").form("submit");');
        $this->jquery->click("#$formName-div ._cancel",'$("#'.$formName.'-div").hide();');
        $frm->setSubmitParams(Router::path($postUrlName),'#'.$responseElement,['hasLoader'=>'internal']);
    }

    public function newUser($formName){
        $frm=$this->semantic->dataForm($formName,new User());
        $frm->addClass('inline');
        $frm->setFields(['firstname','lastname']);
        $frm->setCaptions(['Prénom','Nom']);
        $frm->fieldAsLabeledInput('firstname',['rules'=>'empty']);
        $frm->fieldAsLabeledInput('lastname',['rules'=>'empty']);
        $this->addFormBehavior($formName,$frm,'#new-user','new.userPost');
    }
}