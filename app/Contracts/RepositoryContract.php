<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 7/11/2016
 * Time: 10:40
 */

namespace App\Contracts;


interface RepositoryContract
{
    public function create($object);

    public function delete($id);

    public function update($object,$id);

    public function getById($id);

    public function getAll();
}