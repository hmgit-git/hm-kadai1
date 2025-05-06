<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with('category'); // category リレーション付きで検索開始

        // キーワード検索（名前・メールアドレス）
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別フィルタ
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // カテゴリフィルタ
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // お問い合わせ日フィルタ（created_at）
        if ($request->filled('contact_date')) {
            $query->whereDate('created_at', $request->input('contact_date'));
        }

        // 検索結果付きでページネーション
        $contacts = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->all()); // 検索条件を保持

        // カテゴリ一覧も渡す
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }



    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin')->with('message', '削除しました');
    }

    public function export()
    {
        $contacts = Contact::all();

        $csv = '';
        $csv .= "ID,名前,メールアドレス,内容\n";

        foreach ($contacts as $contact) {
            $csv .= "{$contact->id},{$contact->last_name} {$contact->first_name},{$contact->email},{$contact->detail}\n";
        }

        $filename = 'contacts_export.csv';

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
}
