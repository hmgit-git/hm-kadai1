<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category') // categoryリレーション取得
            ->orderBy('created_at', 'desc')
            ->paginate(10); // ページネーション

        $categories = Category::all();
        return view('admin.index', compact('contacts', 'categories'));
    }
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin')->with('message', '削除しました');
    }
}
