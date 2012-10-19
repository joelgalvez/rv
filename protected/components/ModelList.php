<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelList extends CWidget {
    public $model;
    public $formModel;
    
    public $idField = 'id';
    public $nameField = 'name';

    public $condition;
    public $criteria;

    public $id;

    public $initialData = array();

    public $view = 'dropdown'; //TODO: treeview and list

    public $defaultSelected = '';

    public $options = array();

    public function run()
    {
        if(isset($this->id))
        {
            $list = $this->initialData;
            
            if(!isset($this->criteria))
            {
                $this->criteria = new CDbCriteria;
                $this->criteria->select= $this->idField.','.$this->nameField;

                if(isset($this->condition))
                    $this->criteria->condition= $this->condition;
            }

            $_list= $this->model->findAll($this->criteria);

            foreach ($_list as $k=>$v) {
                $list[$v[$this->idField]] = $v[$this->nameField];
            }

            $this->render('modelList',array(
                    'list'=>$list,
                    'id'=>$this->id,
                    'model'=> isset($this->formModel)? $this->formModel : $this->model,
                    'view'=>$this->view,
                    'defaultSelected' =>$this->defaultSelected,
                    'options' => $this->options,
                    't'=>$this->initialData,
                    )
            );

        }else
        {
            //TODO: Throw error
        }
    }
}
?>
