<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/7/14
 * Time: 18:21
 * Email: jhasheng@hotmail.com
 */

namespace App\Repositories\MySQL;


use App\Models\Post;
use App\Repositories\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @var Post
     */
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Create new record
     * @param array $data
     * @return mixed|static
     */
    public function store(array $data)
    {
        return $this->post->create($data);
    }

    /**
     * Get all record
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->post->all();
    }

    /**
     * Get on record
     * @param   integer $id Record key
     * @return mixed
     */
    public function retrieved($id)
    {
        return $this->post->find($id);
    }

    /**
     * Soft delete one record
     * @param   integer $id Record key
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->post->destroy($id);
    }

    /**
     * Restore one record who has been soft deleted
     * @param   integer $id Record key
     * @return mixed
     */
    public function restore($id)
    {
        return $this->post->restore($id);
    }

    /**
     * Update one record by primary key
     * @param   integer $id
     * @param   array   $data
     * @return mixed
     */
    public function updateByPk($id, $data)
    {
        $post = $this->retrieved($id);
        $post->fill($data);
        $post->save();
        return $post;
    }

    public function findBySlug($slug)
    {
        return $this->post->where('slug', $slug)->firstOrFail();
    }
}