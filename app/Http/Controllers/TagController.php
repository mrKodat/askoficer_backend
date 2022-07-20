<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TagController extends Controller
{
    public function index(Tag $tags)
    {
        return view('tags.tags-index', ['tags' => $tags->get()]);
    }

    public function tagedit(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        return view('tags.tag-edit')->with('tag', $tag);
    }

    public function tagupdate(Request $request, $id)
    {
        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->status = $request->status;
        $tag->save();
        return redirect('/tags')->with('status', 'Tag updated successfully');
    }

    public function tagdelete($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect('/tags')->with('status', 'Tag deleted successfully');
    }

    public function tagadd(Request $request)
    {
        $tag = new Tag;
        $tag->name = $request->name;
        $tag->status = $request->status;
        $tag->save();
        return redirect('/tags')->with('status', 'Tag added successfully');
    }
}
