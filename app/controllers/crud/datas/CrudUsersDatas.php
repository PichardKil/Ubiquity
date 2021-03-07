<?php
namespace controllers\crud\datas;

use Ubiquity\controllers\crud\CRUDDatas;
 /**
  * Class CrudUsersDatas
  */
class CrudUsersDatas extends CRUDDatas{
    public function getFieldNames($model){
        return ['Firstname','Lastname','Email','Suspended','Groups'];
    }

    public function getFormFieldNames($model, $instance){
        return ['Prénom','Nom','Email','Suspendu?','Groupes'];
    }

    public function _getInstancesFilter($model){
        return parent::_getInstancesFilter($model);//todo
    }

    public function getManyToManyDatas($fkClass, $instance, $member){
        return parent::getManyToManyDatas($fkClass, $instance, $member);//todo
    }



}
