<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateSlug($string)
    {
        $slug = Str::slug($string ?? '', '-');
        $count = 1;

        while ($this->slugExists($slug)) {
            $slug = Str::slug($string. '-' . $count ?? '', '-');
            $count++;
        }

        return $slug;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected function slugExists($slug)
    {
        return static::where('slug', $slug)->exists();
    }
}
