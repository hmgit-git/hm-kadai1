<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required|numeric', 
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:1,2,3',
            'email' => 'required|email',
            'tel1' => 'required|digits_between:2,4',
            'tel2' => 'required|digits_between:2,4',
            'tel3' => 'required|digits_between:2,4',
            'address' => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        $tel = $request->tel1 . '-' . $request->tel2 . '-' . $request->tel3;

        //dd('保存直前！'); // ← ここで一旦確認！

        $contact = new Contact();
        $contact->category_id = $request->category_id;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->gender = $request->gender;
        $contact->email = $request->email;
        $contact->tel = $tel;
        $contact->address = $request->address;
        $contact->building = $request->building;
        $contact->detail = $request->detail;
        $contact->save();

        // dd('保存完了');
        return redirect()->route('contacts.thanks');
    }
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|numeric',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:1,2,3',
            'email' => 'required|email',
            'tel1' => 'required|digits_between:2,4',
            'tel2' => 'required|digits_between:2,4',
            'tel3' => 'required|digits_between:2,4',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'detail' => 'required|string',
        ]);

        return view('confirm', ['input' => $validated]);
    }

    public function thanks()
    {
        return view('thanks');
    }
}
