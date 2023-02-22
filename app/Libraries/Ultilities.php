<?php
    namespace App\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
    class Ultilities
    {

        // Clear XSS
        public static function clearXSS($string)
        {
            $string = nl2br($string);
            $string = trim(strip_tags($string));
            $string = self::removeScripts($string);

            return $string;
        }

        public static function removeScripts($str)
        {
            $regex =
                '/(<link[^>]+rel="[^"]*stylesheet"[^>]*>)|'.
                '<script[^>]*>.*?<\/script>|'.
                '<style[^>]*>.*?<\/style>|'.
                '<!--.*?-->/is';

            return preg_replace($regex, '', $str);
        }

        public static function clearXssInput($input)
        {
            $data = array_map(function ($value) {
                return self::clearXSS($value);
            }, $input);

            return $data;
        }

        // Move a file
        public static function uploadFile($file, $savedFolder)
        {
            $folder = 'public/' . $savedFolder;
            $name = uniqid() . $file->getClientOriginalName();
            $nameFormat = preg_replace('/\s+/', '', $name);
            $file->storeAs($folder, $nameFormat);
            return '/storage/' . $savedFolder . "/" . $nameFormat;
        }
        public static function removeFileInStorage($urlFile)
        {
            $formatUrl = str_replace("/storage", "public", $urlFile);
            if(Storage::exists($formatUrl)) {
                Storage::delete($formatUrl);
            }
        }
        public static function removeFileInStorageV2($urlFile)
        {
            if(File::exists(public_path($urlFile))) {
                File::delete(public_path($urlFile));
            }
        }
        public static function getPath($path)
        {
            return env('URL_PATH', 'https://ghostpost-api.adamo.tech') . $path;
        }
        public static function createFileData($file, $savedFolder)
        {

                $name = uniqid() . $file->getClientOriginalName();
                $nameFormat = preg_replace('/\s+/', '', pathinfo($name, PATHINFO_FILENAME));
                $nameFormat = $nameFormat . '.' . pathinfo($name, PATHINFO_EXTENSION);
                $extension = $file->getClientOriginalExtension();
                $path = 'public/' . $savedFolder;
                $fileStoragePath = '/storage/' . $savedFolder;
                $dirPath         = public_path() . $fileStoragePath;
                if (!File::exists($dirPath)) {
                    File::makeDirectory($dirPath, 0777, true);
                }
                $uploadedPath = $file->storeAs($path, $nameFormat);

                $filePath =  $fileStoragePath . '/' . $nameFormat;
                if (strtolower($extension) == 'heic' || strtolower($extension) == 'heif') {
                    $imagick = new \Imagick($dirPath . '/' . $nameFormat);
                    unlink($dirPath . '/' . $nameFormat);
                    $imagick->setImageFormat("jpg");
                    $imagick->setImageCompressionQuality(100);
                    $nameFormat = str_replace('.' . $extension, '.jpg', $nameFormat);
                    $filePath =  $fileStoragePath . '/' . $nameFormat;
                    $imagick->writeImage($dirPath . '/' . $nameFormat); 
                }
            return '/storage/' . $savedFolder . "/" . $nameFormat;   
        }

    }
