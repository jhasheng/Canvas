<?php
namespace App\Http\Controllers\Backend;

use App\Repositories\MySQL\TagRepository;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Requests\TagCreateRequest;

class TagController extends Controller
{
    const TRIM_WIDTH = 40;
    const TRIM_MARKER = "...";

    protected $fields = [
        'tag' => '',
        'title' => '',
        'subtitle' => '',
        'meta_description' => '',
        'layout' => 'frontend.blog.index',
        'reverse_direction' => 0,
        'created_at' => '',
        'updated_at' => '',
    ];

    protected $tag;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = $this->tag->fetchAll();
        foreach ($data as $tag) {
            $tag->subtitle = mb_strimwidth($tag->subtitle, 0, self::TRIM_WIDTH, self::TRIM_MARKER);
        }

        return view('backend.tag.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [];

        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('backend.tag.create', compact('data'));
    }

    /**
     * Store the newly created tag in the database
     *
     * @param TagCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagCreateRequest $request)
    {
        $this->tag->store($request->toArray());

        Session::set('_new-tag', trans('messages.create_success', ['entity' => 'tag']));
        return redirect('/admin/tag');
    }

    /**
     * Show the form for editing a tag
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tag = $this->tag->retrieved($id);
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $tag->$field);
        }

        return view('backend.tag.edit', compact('data'));
    }

    /**
     * Update the tag in storage
     *
     * @param TagUpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagUpdateRequest $request, $id)
    {

        $this->tag->update($id, $request->toArray());

        Session::set('_update-tag', trans('messages.update_success', ['entity' => 'Tag']));
        return redirect("/admin/tag/$id/edit");
    }

    /**
     * Delete the tag
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->tag->destroy($id);

        Session::set('_delete-tag', trans('messages.delete_success', ['entity' => 'Tag']));
        return redirect('/admin/tag');
    }
}
