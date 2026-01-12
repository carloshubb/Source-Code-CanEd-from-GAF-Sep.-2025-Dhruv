<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TemporaryMedia;
use App\Traits\FileUploadTrait;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class MediaController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    // original one
    public function process(Request $request)
    {

        // dd($request->all());
        // if ($request->hasFile('media')) {
        //     $file = $request->file('media');

        //     // Validate file: size less than 5MB, and type is image (jpg, jpeg, png)
        //     $validated = $request->validate([
        //         'media' => 'required|image|mimes:jpg,jpeg,png|max:5120', // max 5MB (5120 KB)
        //     ]);

        //     // Save file if validation passes
        //     if ($validated) {
        //         $media = $this->saveFiles($file, 'temp');
        //     }
        // }
        if ($request->hasFile('media')) {
            $media = $this->saveFiles($request->file('media'), 'temp');
        } elseif (preg_match('/^data:image\/(\w+);base64,/', $request->input('image'))) {
            $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $request->input('image'));
            $media = $this->saveBase64Image($base64Data, 'temp');
        } elseif (isset($request->image) && is_string($request->image)) {
            $media = json_decode($request->image, true);
            if ($media === null) {
                return response()->json(['error' => 'Invalid JSON provided for image data.'], 400);
            }
        } else {
            return response()->json(['error' => 'No valid media data received.'], 400);
        }

        foreach ($media as $file) {
            TemporaryMedia::create([
                'path' => $file,
                'type' => $request->type,
                'extension' => pathinfo($file, PATHINFO_EXTENSION),
            ]);
        }

        return response()->json(['media' => $media]);
    }
    
    // public function process(Request $request)
    // {
    //     // Validate file type and size
    //     $request->validate([
    //         'media' => 'nullable|file|mimes:jpg,jpeg,png|max:5120', // 5120 KB = 5MB
    //         'image' => 'nullable|string',
    //     ], [
    //         'media.mimes' => 'Only JPG, JPEG, and PNG files are allowed.',
    //         'media.max' => 'The file size must not exceed 5MB.',
    //     ]);

    //     if ($request->hasFile('media')) {
    //         // Validate file manually if needed
    //         $file = $request->file('media');

    //         if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
    //             return response()->json(['error' => 'Only JPG, JPEG, and PNG files are allowed.'], 400);
    //         }

    //         if ($file->getSize() > 5 * 1024 * 1024) { // 5MB
    //             return response()->json(['error' => 'The file size must not exceed 5MB.'], 400);
    //         }

    //         $media = $this->saveFiles($file, 'temp');
    //     } elseif (preg_match('/^data:image\/(\w+);base64,/', $request->input('image'), $matches)) {
    //         $allowedExtensions = ['jpg', 'jpeg', 'png'];
    //         $extension = strtolower($matches[1]);

    //         if (!in_array($extension, $allowedExtensions)) {
    //             return response()->json(['error' => 'Only JPG, JPEG, and PNG base64 images are allowed.'], 400);
    //         }

    //         $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $request->input('image'));
    //         $media = $this->saveBase64Image($base64Data, 'temp');
    //     } elseif (isset($request->image) && is_string($request->image)) {
    //         $media = json_decode($request->image, true);
    //         if ($media === null) {
    //             return response()->json(['error' => 'Invalid JSON provided for image data.'], 400);
    //         }
    //     } else {
    //         return response()->json(['error' => 'No valid media data received.'], 400);
    //     }

    //     foreach ($media as $file) {
    //         TemporaryMedia::create([
    //             'path' => $file,
    //             'type' => $request->type,
    //             'extension' => pathinfo($file, PATHINFO_EXTENSION),
    //         ]);
    //     }

    //     return response()->json(['media' => $media]);
    // }



    public function revert(Request $request)
    {
        $media = $request->media;
        $media = json_decode($media, 1);
        $result = $this->removeFile($media);
        if ($result) {
            foreach ($media as $file) {
                TemporaryMedia::wherePath($file)->delete();
            }
            return $result;
        }
        return false;
    }

    public function uploadImage(Request $request)
    {

    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required|image|mimes:jpg,png,jpeg|max:5120',
    //     ],
        
    // );

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'Error',
    //             'message' => $validator->errors()->first(),
    //         ], 422);
    //     }
    $validator = Validator::make($request->all(), [
        // 'file' => 'required|image|mimes:jpg,png,jpeg|max:5120',
        'file' => 'nullable',
    ],
    //  [
    //     'file.required' => 'Please select an image to upload',
    //     'file.image' => 'The file must be an image',
    //     'file.mimes' => 'Only JPG, PNG, and JPEG formats are allowed',
    //     'file.max' => 'The image size must not exceed 5MB',
    // ]
);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors() // Include full errors object
        ], 422);
    }


        $allowedEventImages = Setting::where('type', 'general')->where('key', 'event_multiple_images_allowed')->value('value');
        if (isset($request->total_files, $request->source) && $request->source == 'event' && $request->total_files > $allowedEventImages) {
            return $this->errorResponse('Please limit the number of photos to ' . $allowedEventImages);
        }
        $image = $request->file('file');
        $name = time() . '-' . rand(5, 1000) . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $this->resizeFile('abc', $destinationPath . '/' . $name, $destinationPath, $name);
        return '/images/' . $name;
    }

    public function uploadImages(Request $request)
    {
        $validator = $this->validate($request, [
            'files.*' => 'required|image|mimes:jpg,png,jpeg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $imageNames = [];

        foreach ($request->file('files') as $file) {
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('/images'), $name);
            $this->resizeFile('abc', public_path('/images/' . $name), public_path('/images'), $name);
            $imageNames[] = '/images/' . $name;
        }

        return $imageNames;
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
                    })->save($destinationFolder . '/thumbnail-' . basename($tempFile));
                } else {
                    $img->save($destinationFolder . '/thumbnail-' . basename($tempFile));
                }
            } else if ($imgHeight > $imgWidth) {
                if ($imgHeight > $general_setting['thumbnail_image_height']) {
                    $img->resize($general_setting['thumbnail_image_height'], $general_setting['thumbnail_image_width'], function ($const) {
                        $const->aspectRatio();
                    })->save($destinationFolder . '/thumbnail-' . basename($tempFile));
                } else {
                    $img->save($destinationFolder . '/thumbnail-' . basename($tempFile));
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
                    })->save($destinationFolder . '/medium-' . basename($tempFile));
                } else {
                    $img->save($destinationFolder . '/medium-' . basename($tempFile));
                }
            } else if ($imgHeight > $imgWidth) {
                if ($imgHeight > $general_setting['medium_image_height']) {
                    $img->resize($general_setting['medium_image_height'], $general_setting['medium_image_width'], function ($const) {
                        $const->aspectRatio();
                    })->save($destinationFolder . '/medium-' . basename($tempFile));
                } else {
                    $img->save($destinationFolder . '/medium-' . basename($tempFile));
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
                    })->save($destinationFolder . '/large-' . basename($tempFile));
                } else {
                    $img->save($destinationFolder . '/large-' . basename($tempFile));
                }
            } else if ($imgHeight > $imgWidth) {
                if ($imgHeight > $general_setting['large_image_height']) {
                    $img->resize($general_setting['large_image_height'], $general_setting['large_image_width'], function ($const) {
                        $const->aspectRatio();
                    })->save($destinationFolder . '/large-' . basename($tempFile));
                } else {
                    $img->save($destinationFolder . '/large-' . basename($tempFile));
                }
            }
        }
    }
}
