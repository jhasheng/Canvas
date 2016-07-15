<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/7/15
 * Time: 16:30
 * Email: jhasheng@hotmail.com
 */

namespace App\Repositories\MySQL;


use App\Models\Tag;
use App\Repositories\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function batchCreate($tags)
    {
        $found = $this->tag->whereIn('tag', $tags)->lists('tag')->all();
        $data = [];
        foreach (array_diff($tags, $found) as $tag) {
            array_push($data, [
                'tag' => $tag,
                'title' => $tag,
                'subtitle' => 'Subtitle for ' . $tag,
                'meta_description' => '',
                'reverse_direction' => false,
            ]);
        }
        return $this->tag->insert($data);
    }

    public function store($data)
    {
        return $this->tag->create($data);
    }

    public function destroy($id)
    {
        return $this->tag->destroy($id);
    }

    public function retrieved($id)
    {
        return $this->tag->find($id);
    }

    public function update($id, $data)
    {
        $tag = $this->retrieved($id);
        $tag->fill($data);
        return $tag->save();
    }

    public function fetchAll()
    {
        return $this->tag->all();
    }
    
    public function findByTag($tag)
    {
        $this->tag->where('tag', $tag)->firstOrFail();
    }
    
}