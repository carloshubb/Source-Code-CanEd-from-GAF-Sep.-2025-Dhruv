<?php

namespace App\Traits;

use App\Models\Media;
use App\Models\TemporaryMedia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

trait FileUploadTrait
{
    protected $uploadPath = 'media';
    public $folderName;
    public $rule = 'image|max:2000';

    private function createMediaFolder(): bool
    {
        if (!file_exists(config('filesystems.disks.public.root') . '/' . $this->uploadPath . '/' . $this->folderName)) {
            $attachmentPath = config('filesystems.disks.public.root') . '/' . $this->uploadPath . '/' . $this->folderName;
            mkdir($attachmentPath, 0777,true);

            // Storage::put('public/' . $this->uploadPath . '/' . $this->folderName . '/index.html', 'Silent Is Golden');

            return true;
        }

        return false;
    }

    /**
     * For handle validation file action
     *
     * @param $file
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFileAction($file)
    {

        $rules = array('fileupload' => $this->rule);
        $file  = array('fileupload' => $file);

        $fileValidator = Validator::make($file, $rules);

        if ($fileValidator->fails()) {

            $messages = $fileValidator->messages();

            return redirect()->back()->withInput(request()->all())
                ->withErrors($messages);
        }
    }

    /**
     * For Handle validation file
     *
     * @param $files
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFile($files)
    {

        if (is_array($files)) {
            foreach ($files as $file) {
                return $this->validateFileAction($file);
            }
        }

        return $this->validateFileAction($files);
    }

    /**
     * For Handle Put File
     *
     * @param $file
     * @return bool|string
     */
    private function putFile($file)
    {
        $fileName = preg_replace('/\s+/', '_', time() . ' ' . $file->getClientOriginalName());
        $path     = $this->uploadPath . '/' . $this->folderName . '/';

        if (Storage::putFileAs('public/' . $path, $file, $fileName)) {
            return $path . $fileName;
        }

        return false;
    }

    /**
     * For Handle Save File Process
     *
     * @param $files
     * @return array
     */
    public function saveFiles($files, $folderName)
    {
        $data = [];
        $this->folderName = $folderName;

        if ($files != null) {

            $this->validateFile($files);

            $this->createMediaFolder();

            if (is_array($files)) {

                foreach ($files as $file) {
                    $data[] = $this->putFile($file);
                }
            } else {

                $data[] = $this->putFile($files);
            }
        }

        return $data;
    }

    public function removeFile($files)
    {
        if (is_array($files)) {
            foreach ($files as $file) {
                if (file_exists(config('filesystems.disks.public.root') . '/' . $file)) {
                    $url = pathinfo($file, PATHINFO_DIRNAME);
                    $url_var = explode('/', $url);
                    $folderName = end($url_var);
                    unlink('storage/' . $file);
                    rmdir('storage/media/temp/' . $folderName);
                }
            }
            return 1;
        } else {
            $url = pathinfo($files, PATHINFO_DIRNAME);
            $url_var = explode('/', $url);
            $folderName = end($url_var);
            unlink('storage/' . $files);
            rmdir('storage/media/temp/' . $folderName);
            return 1;
        }
        return 0;
    }


    public function moveFile($tempFiles, $destinationFolder, $type)
    {
        $media = null;
        $this->createMediaFolder($destinationFolder);
        if (is_array($tempFiles)) {
            foreach ($tempFiles as $key => $tempFile) {
                // dd($tempFile);
                if (is_string($tempFile) &&  file_exists(config('filesystems.disks.public.root') . '/' . $tempFile)) {
                    $fileName = $destinationFolder . '/' . basename($tempFile);
                    $newFileName = public_path($fileName);
                    File::move(config('filesystems.disks.public.root') . '/' . $tempFile, $newFileName);
                    $media[] = Media::create([
                        'path' => $fileName,
                        'type' => $type,
                        'thumbnail_image' => $destinationFolder . '/' . 'thumbnail-' . basename($tempFile),
                        'medium_image' => $destinationFolder . '/' . 'medium-' . basename($tempFile),
                        'large_image' => $destinationFolder . '/' . 'large-' . basename($tempFile),
                        'extension' => pathinfo($tempFile, PATHINFO_EXTENSION),
                    ]);
                    TemporaryMedia::wherePath($tempFile)->delete();
                    $this->resizeFile($type, $fileName, $destinationFolder, $tempFile);
                }
            }
        } else {
            if (file_exists(config('filesystems.disks.public.root') . '/' . $tempFiles)) {
                File::move(config('filesystems.disks.public.root') . '/' . $tempFiles, $destinationFolder);
                $fileName = $destinationFolder . '/' . basename($tempFiles);
                $newFileName = public_path($fileName);
                $media[] = Media::create([
                    'path' => $fileName,
                    'type' => $type,
                    'thumbnail_image' => $destinationFolder . '/' . 'thumbnail-' . basename($tempFiles),
                    'medium_image' => $destinationFolder . '/' . 'medium-' . basename($tempFiles),
                    'large_image' => $destinationFolder . '/' . 'large-' . basename($tempFiles),
                    'extension' => pathinfo($tempFiles, PATHINFO_EXTENSION),
                ]);
                TemporaryMedia::wherePath($tempFiles)->delete();
                $this->resizeFile($type, $fileName, $destinationFolder, $tempFiles);
            }
        }
        return $media;
    }
    public function resizeFile($type, $fileName, $destinationFolder, $tempFile)
    {
        $general_setting = getSignleGeneralSettingByKey(['thumbnail_image_width', 'thumbnail_image_height']);

        if (isset($general_setting, $general_setting['thumbnail_image_width'], $general_setting['thumbnail_image_height'])) {
            $img = Image::make($fileName);
            $imgWidth = $img->width();
            $imgHeight = $img->height();

            if ($imgWidth >= $imgHeight) {
                if ($imgWidth > $general_setting['thumbnail_image_width']) {
                    $img->resize($general_setting['thumbnail_image_width'], $general_setting['thumbnail_image_height'], function ($const) {
                        $const->aspectRatio();
                    })->save(public_path($destinationFolder) . '/thumbnail-' . basename($tempFile));
                } else {
                    $img->save(public_path($destinationFolder) . '/thumbnail-' . basename($tempFile));
                }
            } else if ($imgHeight > $imgWidth) {
                if ($imgHeight > $general_setting['thumbnail_image_height']) {
                    $img->resize($general_setting['thumbnail_image_height'], $general_setting['thumbnail_image_width'], function ($const) {
                        $const->aspectRatio();
                    })->save(public_path($destinationFolder) . '/thumbnail-' . basename($tempFile));
                } else {
                    $img->save(public_path($destinationFolder) . '/thumbnail-' . basename($tempFile));
                }
            }
        }

        $general_setting = getSignleGeneralSettingByKey(['medium_image_width', 'medium_image_height']);
        if (isset($general_setting, $general_setting['medium_image_width'], $general_setting['medium_image_height'])) {
            $img = Image::make($fileName);
            $imgWidth = $img->width();
            $imgHeight = $img->height();

            if ($imgWidth >= $imgHeight) {
                if ($imgWidth > $general_setting['medium_image_width']) {
                    $img->resize($general_setting['medium_image_width'], $general_setting['medium_image_height'], function ($const) {
                        $const->aspectRatio();
                    })->save(public_path($destinationFolder) . '/medium-' . basename($tempFile));
                } else {
                    $img->save(public_path($destinationFolder) . '/medium-' . basename($tempFile));
                }
            } else if ($imgHeight > $imgWidth) {
                if ($imgHeight > $general_setting['medium_image_height']) {
                    $img->resize($general_setting['medium_image_height'], $general_setting['medium_image_width'], function ($const) {
                        $const->aspectRatio();
                    })->save(public_path($destinationFolder) . '/medium-' . basename($tempFile));
                } else {
                    $img->save(public_path($destinationFolder) . '/medium-' . basename($tempFile));
                }
            }
        }

        $general_setting = getSignleGeneralSettingByKey(['large_image_width', 'large_image_height']);
        if (isset($general_setting, $general_setting['large_image_width'], $general_setting['large_image_height'])) {
            $img = Image::make($fileName);
            $imgWidth = $img->width();
            $imgHeight = $img->height();

            if ($imgWidth >= $imgHeight) {
                if ($imgWidth > $general_setting['large_image_width']) {
                    $img->resize($general_setting['large_image_width'], $general_setting['large_image_height'], function ($const) {
                        $const->aspectRatio();
                    })->save(public_path($destinationFolder) . '/large-' . basename($tempFile));
                } else {
                    $img->save(public_path($destinationFolder) . '/large-' . basename($tempFile));
                }
            } else if ($imgHeight > $imgWidth) {
                if ($imgHeight > $general_setting['large_image_height']) {
                    $img->resize($general_setting['large_image_height'], $general_setting['large_image_width'], function ($const) {
                        $const->aspectRatio();
                    })->save(public_path($destinationFolder) . '/large-' . basename($tempFile));
                } else {
                    $img->save(public_path($destinationFolder) . '/large-' . basename($tempFile));
                }
            }
        }
    }
}
