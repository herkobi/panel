<?php

namespace App\Services\Admin;

use App\Traits\HasDefaultPagination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService
{
    use HasDefaultPagination;

    protected $model;

    /**
     * Verileri hazırlamak için soyut metod.
     *
     * @param array $data
     * @param string $action
     * @return array
     */
    abstract protected function prepareData(array $data, string $action): array;

    /**
     * Tüm kayıtları getirir.
     *
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return $this->model::defaultPagination();
    }

    /**
     * Belirli bir ID'ye sahip kaydı getirir.
     *
     * @param int $id
     * @return Model
     */
    public function getById(int $id): Model
    {
        return $this->model::findOrFail($id);
    }

    /**
     * Yeni bir kayıt oluşturur.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $preparedData = $this->prepareData($data, 'create');
        return $this->model::create($preparedData);
    }

    /**
     * Belirli bir ID'ye sahip kaydı günceller.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $model = $this->getById($id);
        $preparedData = $this->prepareData($data, 'update');
        $model->update($preparedData);
        return $model;
    }

    /**
     * Belirli bir ID'ye sahip kaydı siler.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $model = $this->getById($id);
        $model->delete();
    }

    /**
     * Resim yükler ve yüklenen dosyanın yolunu döndürür.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string|null
     */
    public function uploadImage(UploadedFile $file, string $folder): ?string
    {
        if ($file->isValid()) {
            $path = $file->store($folder); // Dosyayı belirtilen klasöre kaydet
            return $path; // Dosya yolunu döndür
        }

        return null; // Dosya geçerli değilse null döndür
    }
}
