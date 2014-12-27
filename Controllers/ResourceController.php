<?php

namespace Tee\Admin\Controllers;

use Tee\Admin\Controllers\AdminBaseController;

use View, Redirect, Validator, URL, Input;

use Tee\System\Breadcrumbs;

class ResourceController extends AdminBaseController {

    public $resourceTitle; // ex: Página
    public $resourceName; // ex: 'page';
    public $modelClass; // ex: 'Page';
    
    public $moduleName; // ex: 'page'; auto indentified
    public $controllerName; // auto identified
    public $controllerNamespace = array();
    public $columns = array();

    public function __construct() {
        parent::__construct();
        foreach(['resourceTitle', 'resourceName', 'modelClass', 'moduleName'] as $required) {
            if(empty($this->$required)) {
                throw new Exception("'$required' is an required attribute of resource controller");
            }
        }

        $class = get_class($this);
        $auxClass = explode('\\', $class);
        if(!$this->moduleName)
            $this->moduleName = strtolower($auxClass[1]);
        if(!$this->controllerName) {
            $this->controllerName = strtolower($auxClass[count($auxClass)-1]);
            $this->controllerName = str_replace('controller', '', $this->controllerName);

            for($i = count($auxClass) - 2; $i > 1; $i--) {
                $v = $auxClass[$i];
                if(stristr($v, 'controller'))
                    break;
                $this->controllerNamespace[] = strtolower($v);
            }
        }

        View::share('pageTitle', $this->resourceTitle);
        View::share('resourceTitle', $this->resourceTitle);
        View::share('resourceName', $this->resourceName);
        View::share('moduleName', $this->moduleName);
        View::share('controllerName', $this->controllerName);
        View::share('tableColumns', $this->columns);

        Breadcrumbs::addCrumb(
            str_plural($this->resourceTitle),
            URL::route("admin.{$this->resourceName}.index")
        );
    }

    public function beforeList($queryBuilder) {
        return $queryBuilder;
    }

    public function beforeSave($model) { }
    
    /**
     * Display a listing of pages
     *
     * @return Response
     */
    public function index()
    {
        $modelClass = $this->modelClass;
        $models = $this->beforeList($modelClass::query())->get();

        return View::make(
            $this->getViewName('index'),
            compact('models') + array(
                'modelClass' => $this->modelClass
            )
        );
    }

    /**
     * Show the form for creating a new page
     *
     * @return Response
     */
    public function create()
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass;
        $model->fill(Input::all());
        return View::make(
            $this->getViewName('create'),
            compact('model') + array(
                'pageTitle' => 'Cadastrar '.$this->resourceTitle,
                'formView' => $this->getViewName('_form'),
            )
        );
    }

    /**
     * Store a newly created page in storage.
     *
     * @return Response
     */
    public function store()
    {
        $modelClass = $this->modelClass;

        $model= new $modelClass;
        $model->fill(Input::all());

        $validator = $this->getValidator($model, 'create');

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $this->beforeSave($model);
        $model->save();

        return Redirect::route("admin.{$this->resourceName}.index");
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::find($id);

        return View::make(
            $this->getViewName('edit'),
            compact('model')  + array(
                'pageTitle' => 'Editar '.$this->resourceTitle,
                'formView' => $this->getViewName('_form'),
            )
        );
    }

    /**
     * Update the specified page in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::findOrFail($id);

        $model= $modelClass::find($id);
        $model->fill(Input::all());

        $validator = $this->getValidator($model, 'update');

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $this->beforeSave($model);
        $model->save();

        return Redirect::route("admin.{$this->resourceName}.index");
    }

    public function getValidator($model, $scope) {
        $modelClass = $this->modelClass;
        //$validator = Validator::make($data = Input::all(), $modelClass::$rules);
        $validator = $model->getValidator(Input::all(), $scope);
        $validator->setAttributeNames($modelClass::getAttributeNames());
        return $validator;
    }

    /**
     * Remove the specified page from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $modelClass = $this->modelClass;
        $modelClass::destroy($id);

        return Redirect::route("admin.{$this->resourceName}.index");
    }

    public function getViewName($name) {
        $targetName = "{$this->moduleName}::";
        $aux = $this->controllerNamespace;
        $aux[] = $this->controllerName;
        $targetName .= implode('.', $aux);
        $targetName .= ".$name";
        if(View::exists($targetName))
            return $targetName;
        return "admin::resource.$name";
    }

}
