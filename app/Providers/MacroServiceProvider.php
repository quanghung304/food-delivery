<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Aws\S3\S3Client;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        File::macro('streamUpload', function ($path, $fileName, $file, $overWrite = true) {
            // Set up S3 connection.
            $resource = fopen($file->getRealPath(), 'r+');
            $config = Config::get('filesystems.disks.s3');
            $BUCKET = $config['bucket'];
            $client = new S3Client([
                'credentials' => [
                    'key' => $config['key'],
                    'secret' => $config['secret'],
                ],
                'region' => $config['region'],
                'version' => 'latest',
            ]);

            $adapter = new AwsS3Adapter($client, $BUCKET, $path);
            $filesystem = new Filesystem($adapter);

            return $overWrite
                ? $filesystem->putStream($fileName, $resource, ['ACL' => 'public-read'])
                : $filesystem->writeStream($fileName, $resource, ['ACL' => 'public-read']);
        });
    }
}
