<?php

class HomeController extends Controller {
    public function index() {
        $articleModel = $this->model('Article');
        $articles = $articleModel->getAll();
        $this->view('home', ['articles' => $articles]);
    }
}
