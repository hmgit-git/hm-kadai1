<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

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
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required|in:1,2,3',
            'email' => 'required|email',
            'tel1' => 'required|digits_between:1,5|numeric',
            'tel2' => 'required|digits_between:1,5|numeric',
            'tel3' => 'required|digits_between:1,5|numeric',
            'address' => 'required',
            'category_id' => 'required|exists:categories,id',
            'detail' => 'required|string|max:120',
        ], [
            'last_name.required' => '姓を入力してください',
            'first_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'gender.in' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel1.required' => '電話番号一つ目の枠に電話番号を入力してください',
            'tel1.digits_between' => '電話番号一つ目の枠に電話番号は5桁までの数字で入力してください',
            'tel1.numeric' => '電話番号一つ目の枠に電話番号は5桁までの数字で入力してください',
            'tel2.required' => '電話番号二つ目の枠に電話番号を入力してください',
            'tel2.digits_between' => '電話番号二つ目の枠に電話番号は5桁までの数字で入力してください',
            'tel2.numeric' => '電話番号二つ目の枠に電話番号は5桁までの数字で入力してください',
            'tel3.required' => '電話番号三つ目の枠に電話番号を入力してください',
            'tel3.digits_between' => '電話番号三つ目の枠に電話番号は5桁までの数字で入力してください',
            'tel3.numeric' => '電話番号三つ目の枠に電話番号は5桁までの数字で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'category_id.exists' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問合せ内容は120文字以内で入力してください',
        ]);

        // 問い合わせ確認画面へ
        return view('contacts.confirm', ['input' => $request->all()]);
    }

    public function thanks()
    {
        return view('contacts.thanks');
    }
}
