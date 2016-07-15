<?php
namespace App\Repositories;

interface PostRepositoryInterface
{
    /**
     * Create new record
     * @param array $data
     * @return mixed
     */
    public function store(array $data);
    
    /**
     * Get all record
     * @return mixed
     */
    public function fetchAll();

    /**
     * Get on record
     * @param   integer $id Record key
     * @return mixed
     */
    public function retrieved($id);

    /**
     * Soft delete one record
     * @param   integer $id Record key
     * @return mixed
     */
    public function destroy($id);

    /**
     * Restore one record who has been soft deleted
     * @param   integer $id Record key
     * @return mixed
     */
    public function restore($id);

    /**
     * Update one record by primary key
     * @param   integer $id
     * @param   array   $data
     * @return mixed
     */
    public function updateByPk($id, $data);
}