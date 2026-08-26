<?php

namespace DRContacts\config;

class config
{
	public $database;
	public $username;
	public $password;
	public $host;

	public function __construct()
	{
		// .env dosyasından güvenli bir şekilde oku, yoksa varsayılanı kullan
		$this->host = $_ENV['DB_HOST'] ?? 'localhost';
		$this->database = $_ENV['DB_DATABASE'] ?? 'rehber';
		$this->username = $_ENV['DB_USERNAME'] ?? 'root';
		$this->password = $_ENV['DB_PASSWORD'] ?? '';
	}
}
