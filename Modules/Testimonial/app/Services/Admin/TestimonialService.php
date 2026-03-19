<?php

namespace Modules\Testimonial\Services\Admin;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class TestimonialService
{
    public function getAll(): Collection
    {
        return Testimonial::orderBy('sort_order')->orderBy('id')->get();
    }

    public function create(array $data): Testimonial
    {
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $data['photo'] = upload_image($data['photo'], 'testimonials');
        } else {
            $data['photo'] = null;
        }

        return Testimonial::create($data);
    }

    public function update(Testimonial $testimonial, array $data): Testimonial
    {
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            delete_image($testimonial->photo);
            $data['photo'] = upload_image($data['photo'], 'testimonials');
        } else {
            unset($data['photo']);
        }

        $testimonial->update($data);

        return $testimonial;
    }

    public function delete(Testimonial $testimonial): void
    {
        delete_image($testimonial->photo);
        $testimonial->delete();
    }
}
