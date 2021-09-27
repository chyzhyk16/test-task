<?php

namespace App\Controllers;

interface ApiControllerInterface
{
    public function index();

    public function create();

    public function read();

    public function update();

    public function delete();

}