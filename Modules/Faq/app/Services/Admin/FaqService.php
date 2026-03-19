<?php

namespace Modules\Faq\Services\Admin;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

class FaqService
{
    public function getAll(): Collection
    {
        return Faq::ordered()->get();
    }

    public function create(array $data): Faq
    {
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return Faq::create($data);
    }

    public function update(Faq $faq, array $data): Faq
    {
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $faq->update($data);

        return $faq;
    }

    public function delete(Faq $faq): void
    {
        $faq->delete();
    }
}
