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
            ->paginate(7)
            ->appends($request->all()); // 検索条件を保持

        // カテゴリ一覧も渡す
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }



    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin.index')->with('message', '削除しました');
    }

    public function export(Request $request)
    {
        $query = Contact::with('category');

        // 🔍 検索条件反映（index()と同じやつ）
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('contact_date')) {
            $query->whereDate('created_at', $request->input('contact_date'));
        }

        // 🔥 検索条件を反映したデータを取得！
        $contacts = $query->orderBy('created_at', 'desc')->get();

        // CSV生成
        $csv = "ID,名前,メールアドレス,内容\n";
        foreach ($contacts as $contact) {
            $csv .= "{$contact->id},";
            $csv .= "\"" . str_replace('"', '""', $contact->last_name . ' ' . $contact->first_name) . "\",";
            $csv .= "\"" . str_replace('"', '""', $contact->email) . "\",";
            $csv .= "\"" . str_replace(["\r", "\n"], '', str_replace('"', '""', $contact->detail)) . "\"\n";
        }

        $filename = 'contacts_export_filtered.csv';

        return Response::make(mb_convert_encoding($csv, 'SJIS-win', 'UTF-8'), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['keyword', 'gender', 'category_id', 'contact_date']);
        return Excel::download(new ContactsExport($filters), 'contacts_filtered.xlsx');
    }
}
