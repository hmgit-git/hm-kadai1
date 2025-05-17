<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        if ($request->isMethod('post')) {
            return redirect()->route('contacts.index')->withInput();
        }

        return view('contacts.index', compact('categories'));
    }


    public function store(Request $request)
    {
        Contact::create([
            'category_id' => $request->category_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'tel' => $request->tel1 . '-' . $request->tel2 . '-' . $request->tel3,
            'address' => $request->address,
            'building' => $request->building,
            'detail' => $request->detail,
        ]);

        return redirect()->route('contacts.thanks');
    }


    public function confirm(ContactRequest $request)
    {
        $inputs = $request->all();

        return view('contacts.confirm', ['input' => $inputs]);
    }


    public function thanks()
    {
        return view('contacts.thanks');
    }
}
