<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    public function generateSlug($string)
    {

        /**
         * Generate a unique slug
         *
         * @param string $string
         * @return string
         */
        $slug = Str::slug($string ?? '', '-');
        $count = 1;

        while ($this->slugExists($slug)) {
            $slug = Str::slug($string. '-' . $count ?? '', '-');
            $count++;
        }

        return $slug;
    }

    protected function slugExists($slug)
    {
        return static::where('slug', $slug)->exists();
    }
}
