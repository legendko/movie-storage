<?php

namespace Models;

class Movie  
{
	public function getAllMovies() {

		$pdo = \Database::connect();

		$statement = $pdo->prepare('select * from movies');

		$statement->execute();

		$movies = $statement->fetchAll(\PDO::FETCH_OBJ);

		return $movies;
	}

	public function saveMovie($name, $year, $format, $list_of_actors) {

		$pdo = \Database::connect();

		$statement = $pdo->prepare("INSERT INTO movies (name, year, format, list_of_actors)
		    VALUES(:name, :year, :format, :list_of_actors)");

		$statement->execute(array(
		    "name" => $name,
		    "year" => $year,
		    "format" => $format,
		    "list_of_actors" => $list_of_actors
		));
	}	

	public function uploadFile() {

		$pdo = \Database::connect();

		$path = "./".basename($_FILES['file']['name']); 

		move_uploaded_file($_FILES['file']['tmp_name'], $path);

		$text = file_get_contents($path);	

		$text = explode("\n",$text);

		$titles = [];
		$years = [];
		$formats = [];
		$stars = [];

		foreach($text as $line) {			

			if(! $line) {
				continue;
			}

			$title = explode('Title: ',$line);
			if($title[1]) {
				$titles[] = $title[1];
			}

			$year = explode('Release Year: ',$line);
			if($year[1]) {
				$years[] = $year[1];
			}

			$format = explode('Format: ',$line);
			if($format[1]) {
				$formats[] = $format[1];
			}

			$star = explode('Stars: ',$line);
			if($star[1]) {
				$stars[] = $star[1];
			}
			
		}

		$count = count($years);

		for($i = 0; $i < $count; $i++) {
			$statement = $pdo->prepare("INSERT INTO movies (name, year, format, list_of_actors) 
				VALUES(:name, :year, :format, :list_of_actors)");

			$statement->execute(array(
			    "name" => $titles[$i],
			    "year" => $years[$i],
			    "format" => $formats[$i],
			    "list_of_actors" => $stars[$i]
			));
		}
	}

	public function deleteMovie($id) {

		$pdo = \Database::connect();

		$statement = $pdo->prepare("DELETE FROM movies WHERE id = :movie_id");

		$statement->execute(array(
			"movie_id" => $id
		));
	}
}