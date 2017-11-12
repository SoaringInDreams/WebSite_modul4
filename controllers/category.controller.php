<?php

class CategoryController extends Controller{


    public function __construct(array $data = array()){
        parent::__construct($data);
        $this->model = new Articles();
    }

    public function index(){
        $this->data['category'] = $this->model->getCategory();
        $this->data['articles'] = $this->model->getListNews($this->data['category']);

        $this->data['articles_list']  = [];

        foreach ($this->data['category'] as $item) {
                $this->data['articles_list'][$item['name_category']] = $this->model->getListNewsLimit($item['name_category']);
        }
    }

    public function view(){
        $params = App::getRouter()->getParams();

        if (isset($params[0])){
            $alias = strtolower($params[0]);
            $this->data['cat'] = $this->model->getCatById($alias);
            $this->data['new'] = $this->model->getList(ucfirst($alias));
        }
    }

    public function articles(){
        $params = App::getRouter()->getParams();

        if (isset($params[0])){
            $alias = strtolower($params[0]);
            $this->data['art'] = $this->model->getByTitle($alias);
        }
    }

    public function admin_index(){
        $this->data['category'] = $this->model->getCategory();
        $this->data['articles'] = $this->model->getListAdmin();
    }

    public function admin_add(){
        if ( $_POST ){
            $result = $this->model->save($_POST);
            if ( $result ){
                Session::setFlash('Page was saved.');
            } else {
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/category/');
        }
    }
    public function admin_add_category(){
        if ( $_POST ){
            $result = $this->model->save_cat($_POST);
            if ( $result ){
                Session::setFlash('Category was saved.');
            } else {
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/category/');
        }
    }

    public function admin_edit(){

        if ( $_POST ){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if ( $result ){
                Session::setFlash('Page was saved.');
            } else {
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/category/');
        }

        if ( isset($this->params[0]) ){
            $this->data['articles'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/category/');
        }

    }

    public function admin_delete(){
        if ( isset($this->params[0]) ){
            $result = $this->model->delete($this->params[0]);
            if ( $result ){
                Session::setFlash('Page was deleted.');
            } else {
                Session::setFlash('Error.');
            }
        }
        Router::redirect('/admin/category/');
    }
    public function admin_delete_category(){
        if ( isset($this->params[0]) ){
            $result = $this->model->delete_category($this->params[0]);
            if ( $result ){
                Session::setFlash('Category was deleted.');
            } else {
                Session::setFlash('Error.');
            }
        }
        Router::redirect('/admin/category/');
    }
}