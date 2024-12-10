<?php

interface UserRepositoryInterface {
	public function getById(string $id): UserDTO;
}