<?php

namespace Controllers;

class Movie
{
	protected $model;

	public function __construct() {
		$this->model = new \Models\Movie();
	}

	public function index() {
		$movies = $this->model->getAllMovies();

		require 'views/index.php';
	}

	public function store() {
		if(isset($_POST['name']) && isset($_POST['year']) && isset($_POST['format']) && isset($_POST['list_of_actors'])) {
			if(! empty($_POST['name']) && ! empty($_POST['year']) && 
				! empty ($_POST['format']) && ! empty ($_POST['list_of_actors'])) {
				if(is_numeric($_POST['year'])) {
					$this->model->saveMovie($_POST['name'], $_POST['year'], $_POST['format'], $_POST['list_of_actors']);
				}
			}
		}

		return $this->index();
		
	}

	public function upload() {
		if(! empty($_FILES['file']['name'])) {
			$this->model->uploadFile();
		}		

		return $this->index();
	}

	public function delete() {
		$this->model->deleteMovie($_GET['movie_id']);

		return $this->index();
	}
}