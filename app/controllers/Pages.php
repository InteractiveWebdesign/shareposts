<?php
class Pages extends Controller {
    public function __construct(){
    }

    public function index() {
        if(isLoggedIn()){
            redirect('posts');
        }

        $data = [
        'title' => 'SharePosts',
        'description' => 'Simple social network built on the OOP MVC PHP Framework'
      ];

      $this->view('pages/index', $data);
    }

    public function about() {
        $data = [
            'title' => 'About',
            'description' => 'App to share posts on a simple social network built on the OOP MVC PHP Framework'
          ];

        $this->view('pages/about', $data);
    }
}