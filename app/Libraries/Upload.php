<?php
namespace App\Libraries;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;

class Upload
{
    const STORAGE_PUBLIC = 'public';
    const STORAGE_S3 = 's3';

    const STORAGE_DEFAULT = self::STORAGE_S3;
    const DEFAULT_IMAGE = 'images/no-image.jpg';

        /**
     * Join paths
     *
     * @return string
     */
    public static function joinPaths(): string
    {
        $paths = array();

        foreach (func_get_args() as $arg) {
            if ($arg !== '') {
                $paths[] = $arg;
            }
        }

        return preg_replace('#/+#', '/', join('/', $paths));
    }

    /**
     * Get URL for the image
     *
     * @param $fileName
     * @param string $path
     * @param string $disk
     * @param string|null $defaultImage
     * @return string
     */
    public static function getUrlImage(
        $fileName,
        string $path = '',
        string $defaultImage = self::DEFAULT_IMAGE,
        string $disk = self::STORAGE_DEFAULT
    ): ?string {
        $filePath = self::joinPaths($path, $fileName);

        if (empty($fileName)) {
            return asset($defaultImage);
        }

        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->url($filePath);
        }

        return asset($defaultImage);
    }
    /**
     * Get URL for the file
     *
     * @param $fileName
     * @param string $path
     * @param string $disk
     * @return string
     */
    public static function getUrlFile($fileName, string $path = '', string $disk = self::STORAGE_DEFAULT): ?string
    {
        $filePath = self::joinPaths($path, $fileName);
        if (empty($fileName)) {
            return null;
        }

        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->url($filePath);
        }

        return null;
    }

    /**
     * Store a file
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string $disk
     * @return string
     */
    public static function storeFile(UploadedFile $file, string $path = '', string $disk = self::STORAGE_DEFAULT)
    {
        self::convertImage($file);
        $originalName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = $file->extension();
        $filename = date('YmdHis') . '-' . uniqid() . '-' . $originalName . '.' . $extension;

        $upload = null;
        if ($disk == self::STORAGE_S3) {
            $upload = File::streamUpload($path, $filename, $file, true);
        }

        if ($disk == self::STORAGE_PUBLIC) {
            $filePath = self::joinPaths($path, $filename);
            $upload = Storage::disk($disk)->put($filePath, $file->getContent());
        }

        if ($upload) {
            return self::joinPaths($path, $filename);
        }

        return null;
    }

        /**
     * Multiple store files
     *
     * @param $files
     * @param string $path
     * @param string $disk
     * @return array
     */
    public static function storeMultiFiles($files, string $path = '', string $disk = self::STORAGE_DEFAULT): array
    {
        $listNameFiles = [];
        foreach ($files as $file) {
            $listNameFiles[] = self::storeFile($file, $path, $disk);
        }

        return $listNameFiles;
    }

    /**
     * Delete a image
     *
     * @param $fileName
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public static function deleteFile($fileName, string $path = '', string $disk = self::STORAGE_DEFAULT): bool
    {
        $filePath = self::joinPaths($path, $fileName);
        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }

        return false;
    }

    /**
     * Convert image HEIC
     *
     * @param UploadedFile $file
     * @return string
     * @throws \ImagickException
     */
    public static function convertImage(UploadedFile $file): string
    {
        if (strtolower($file->extension()) == 'heic' || strtolower($file->extension()) == 'heif') {
            $image = new Imagick($file->getRealPath());
            $image->setImageFormat("jpg");
            $image->setImageCompressionQuality(100);
            File::put($file->getRealPath(), $image->getImageBlob());

            return true;
        }

        return false;
    }
}