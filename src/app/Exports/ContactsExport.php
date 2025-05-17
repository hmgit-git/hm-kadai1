<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Contact::select('id', 'last_name', 'first_name', 'email', 'gender', 'category_id', 'detail', 'created_at');

        if (!empty($this->filters['keyword'])) {
            $keyword = $this->filters['keyword'];
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }

        if (!empty($this->filters['category_id'])) {
            $query->where('category_id', $this->filters['category_id']);
        }

        if (!empty($this->filters['contact_date'])) {
            $query->whereDate('created_at', $this->filters['contact_date']);
        }

        return $query->orderBy('created_at', 'desc')->get();
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
