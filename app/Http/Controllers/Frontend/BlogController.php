<?php
namespace App\Http\Controllers\Frontend;

use App\Models\Tag;
use App\Models\User;
use App\Models\Post;
use App\Http\Requests;
use App\Jobs\BlogIndexData;
use App\Repositories\MySQL\TagRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TagRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    protected $post;
    protected $tag;

    public function __construct(PostRepositoryInterface $post, TagRepositoryInterface $tag)
    {
        $this->post = $post;
        $this->tag  = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user   = User::findOrFail(1);
        $tag    = $request->get('tag');
        $data   = $this->dispatch(new BlogIndexData($tag));
        $layout = $tag ? Tag::layout($tag)->first() : 'frontend.blog.index';

        return view($layout, $data)->with(compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPost($slug, Request $request)
    {
        $user = User::findOrFail(1);

        $post = $this->post->findBySlug($slug);
        $tag   = $request->get('tag');
        $title = $post->title;
        if ($tag) {
            $tag = $this->tag->findByTag($tag);
        }

        return view($post->layout, compact('post', 'tag', 'slug', 'title', 'user'));
    }
}
