<?php

class HomeController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new Articles();
    }

    public function index()
    {
        $this->data['category'] = $this->model->getCategory();
        $this->data['articles'] = $this->model->getListNews($this->data['category']);
        $this->data['carousel'] = $this->model->getListNewsCarousel();
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $alias = strtolower($params[0]);
            $this->data['art'] = $this->model->getByTitle($alias);
        }
    }
}