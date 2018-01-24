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
					$result = $this->model->saveMovie($_POST['name'], $_POST['year'], $_POST['format'], $_POST['list_of_actors']);
				}
			}
		}

		if($result) {
			$_SESSION['success-message'] = 'New movie added.';	
		} else {
			$_SESSION['fail-message'] = 'Check your form and try again, please.';
		}

		return $this->index();
		
	}

	public function search() {
		if(isset($_POST['search']) && ! empty($_POST['search'])) {
			if(strlen($_POST['search']) >= 5) {
				if(empty($_POST['params']) OR count($_POST['params']) == '2') {
					$movies = $this->model->searchMovie($_POST['search']);
				} else {
					foreach($_POST['params'] as $param) {						
						if($param == 'title') {							
							$movies = $this->model->searchMovieByTitle($_POST['search']);
						} else {
							$movies = $this->model->searchMovieByStars($_POST['search']);
						}
					}
				}		

				if(empty($movies)) {
					$_SESSION['fail-message'] = 'Sorry, nothing found. Please, try again.';

					return $this->index();
				}		

				return require 'views/index.php';
			}			
		}	

		return $this->index();
	}

	public function upload() {
		if(! empty($_FILES['file']['name'])) {
			$result = $this->model->uploadFile();
		}		

		if($result) {
			$_SESSION['success-message'] = 'New movies added.';	
		} else {
			$_SESSION['fail-message'] = 'Something went wrong. Try again, please. Only .txt files with correct format allowed.';
		}
		return $this->index();
	}

	public function delete() {
		$this->model->deleteMovie($_GET['movie_id']);

		return $this->index();
	}
}