<?php

class Database
{
	public static function connect() {
		try {
			return new PDO('mysql:host='.DB_CON.';dbname='.DB_NAME, DB_USERNAME, DB_PASS, DB_OPTIONS);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}