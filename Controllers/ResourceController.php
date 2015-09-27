<?php

namespace Tee\Admin\Controllers;

use Tee\Admin\Controllers\AdminBaseController;

use View, Redirect, Validator, URL, Input, Route;

use Tee\System\Breadcrumbs;

/**
 * TODO: usar traits ao invés de herança
 */
class ResourceController extends AdminBaseController {

    public $resourceTitle; // ex: Página
    public $resourceName; // ex: 'page';
    public $parentResourceName; // ex: 'page_category'
    public $modelClass; // ex: 'Page';
    
    public $moduleName; // ex: 'page'; auto indentified
    public $controllerName; // auto identified
    public $controllerRealName; // auto identified
    public $controllerNamespace = array();
    public $orderable = false;
    public $routePrefix = '';

    public function getColumns() {
        return [];
    }

    /**
     * Return parameters to all routes
     * @return array
     */
    public function getDefaultRouteParameters() {
        $result = [];
        $currentRoute = Route::current();
        if($this->parentResourceName && $currentRoute->parameter($this->parentResourceName)) {
            $result[$this->parentResourceName] = $currentRoute->parameter($this->parentResourceName);
        }
        return $result;
    }

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
        if(!$this->controllerRealName) {
            $this->controllerRealName = $auxClass[count($auxClass)-1];
            $this->controllerRealName = str_replace('Controller', '', $this->controllerRealName);
            $this->controllerName = strtolower($this->controllerRealName);

            for($i = count($auxClass) - 2; $i > 1; $i--) {
                $v = $auxClass[$i];
                if(stristr($v, 'controller'))
                    break;
                $this->controllerNamespace[] = strtolower($v);
            }
        }

        if($this->parentResourceName)
            $this->routePrefix = "admin.{$this->parentResourceName}.{$this->resourceName}";
        else
            $this->routePrefix = "admin.{$this->resourceName}";


        View::share('pageTitle', str_plural($this->resourceTitle));
        View::share('resourceTitle', $this->resourceTitle);
        View::share('resourceName', $this->resourceName);
        View::share('routePrefix', $this->routePrefix);
        View::share('moduleName', $this->moduleName);
        View::share('controllerName', $this->controllerName);
        View::share('controllerRealName', $this->controllerRealName);
        View::share('tableColumns', $this->getColumns());
        View::share('orderable', $this->orderable);

        Breadcrumbs::addCrumb(
            str_plural($this->resourceTitle),
            URL::route($this->routePrefix . ".index", $this->getDefaultRouteParameters())
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

        $view = View::make(
            $this->getViewName('index'),
            compact('models') + array(
                'modelClass' => $this->modelClass
            )
        );
        return $this->beforeRender($view, 'index');
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
        $view = View::make(
            $this->getViewName('create'),
            compact('model') + array(
                'pageTitle' => 'Cadastrar '.$this->resourceTitle,
                'formView' => $this->getViewName('_form'),
                'formContentView' => $this->getViewName('_formContent'),
            )
        );
        $view = $this->beforeRender($view, 'create');
        return $this->beforeRenderForm($view, $model);

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

        return Redirect::route($this->routePrefix . ".index", $this->getDefaultRouteParameters());
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit()
    {
        $model = $this->getRequestedModel();

        $view = View::make(
            $this->getViewName('edit'),
            compact('model')  + array(
                'pageTitle' => 'Editar '.$this->resourceTitle,
                'formView' => $this->getViewName('_form'),
                'formContentView' => $this->getViewName('_formContent'),
            )
        );
        $view = $this->beforeRender($view, 'edit');
        return $this->beforeRenderForm($view, $model);
    }

    /**
     * Update the specified page in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $model = $this->getRequestedModel();

        $model->fill(Input::all());

        $validator = $this->getValidator($model, 'update');

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $this->beforeSave($model);
        $model->save();

        return Redirect::route($this->routePrefix . ".index", $this->getDefaultRouteParameters());
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
    public function destroy()
    {
        $model = $this->getRequestedModel();
        $model->delete();

        return Redirect::route($this->routePrefix . ".index", $this->getDefaultRouteParameters());
    }

    public function getViewName($name) {
        $targetName = "{$this->moduleName}::";
        $aux = $this->controllerNamespace;
        $aux[] = $this->controllerName;
        $targetName .= implode('.', $aux);
        $targetName .= ".$name";
        if(View::exists($targetName))
            return $targetName;

        $targetName = "{$this->moduleName}::";
        $aux = $this->controllerNamespace;
        $aux[] = snake_case($this->controllerRealName);
        $targetName .= implode('.', $aux);
        $targetName .= ".$name";
        if(View::exists($targetName))
            return $targetName;

        return "admin::resource.$name";
    }

    public function beforeRender($view, $actionName)
    {
        return $view;
    }

    public function beforeRenderForm($view, $model)
    {
        return $view;
    }

    /**
     * Get requested model
     * @return Model
     */
    public function getRequestedModel() {
        $id = Route::current()->parameter('id');
        if(!$id)
            $id = Route::current()->parameter($this->resourceName);

        $modelClass = $this->modelClass;
        $model = $modelClass::findOrFail($id);
        return $model;
    }

}
