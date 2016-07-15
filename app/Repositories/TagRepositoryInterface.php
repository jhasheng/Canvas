<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/7/15
 * Time: 16:27
 * Email: jhasheng@hotmail.com
 */

namespace App\Repositories;


interface TagRepositoryInterface
{
    public function batchCreate($data);
    
    public function store($data);
    
    public function destroy($id);

    public function retrieved($id);

    public function update($id, $data);

    public function fetchAll();
}