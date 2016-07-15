<?php
namespace App\Http\Controllers\Backend;

use App\Models\Tag;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    const TRIM_WIDTH  = 40;
    const TRIM_MARKER = "...";

    /**
     * @var PostRepositoryInterface
     */
    protected $post;
    protected $tag;

    public function __construct(PostRepositoryInterface $post, TagRepositoryInterface $tag)
    {
        $this->post = $post;
        $this->tag  = $tag;
    }

    /**
     * Display a listing of the posts
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = $this->post->fetchAll();
        foreach ($data as $post) {
            $post->subtitle = mb_strimwidth($post->subtitle, 0, self::TRIM_WIDTH, self::TRIM_MARKER);
        }

        return view('backend.post.index', compact('data'));
    }

    /**
     * Show the new post form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tags = $this->tag->fetchAll()->pluck('tag')->toArray();
        return view('backend.post.create', compact('tags'));
    }

    /**
     * Store a newly created Post
     *
     * @param PostCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        $this->post->store($request->postFillData())->syncTags($request->get('tags', []));

        Session::set('_new-post', trans('messages.create_success', ['entity' => 'post']));
        return redirect()->route('admin.post.index');
    }

    /**
     * Show the post edit form
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $post       = $this->post->retrieved($id);
        $post->tags = $post->tags()->lists('tag')->all();
        return view('backend.post.edit', $post);
    }

    /**
     * Update the Post
     *
     * @param PostUpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $this->post->updateByPk($id, $request->postFillData())->syncTags($request->get('tags', []));

        Session::set('_update-post', trans('messages.update_success', ['entity' => 'Post']));
        return redirect("/admin/post/$id/edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = $this->post->retrieved($id);
        $post->tags()->detach();
        $this->post->destroy($id);

        Session::set('_delete-post', trans('messages.delete_success', ['entity' => 'Post']));
        return redirect()->route('admin.post.index');
    }
}
