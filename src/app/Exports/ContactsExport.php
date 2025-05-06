<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Contact::select('id', 'last_name', 'first_name', 'email', 'gender', 'category_id', 'detail', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            '姓',
            '名',
            'メールアドレス',
            '性別',
            'お問い合わせ種別',
            'お問い合わせ内容',
            '日付',
        ];
    }
}
