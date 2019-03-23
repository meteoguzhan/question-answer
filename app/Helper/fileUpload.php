<?php

namespace App\Helper;

use File;
use Image;

class fileUpload
{
    static function folderFounder($filename)
    {
        $explode = explode('/', $filename);
        unset($explode[3]);
        return implode('/', $explode);
    }

    static function newUpload($name, $directory, $file, $type = 0)
    {
        $dir = 'images/' . $directory . '/' . $name;
        if (!empty($file)) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }
        $filename = rand(1, 90000) . '.' . $file->getClientOriginalExtension();
        if ($type == 0) {
            $path = public_path($dir . '/' . $filename);
            Image::make($file->getRealPath())->save($path);
        } else {
            $path = public_path($dir . '/');
            $file->move($path, $filename);
        }
        return $dir . "/" . $filename;
    }

    static function changeUpload($name, $directory, $file, $type = 0, $data, $field)
    {
        if (!empty($file)) {
            $dir = 'images/' . $directory . '/' . $name;
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = rand(1, 90000) . '.' . $file->getClientOriginalExtension();
            if ($type == 0) {
                $path = public_path($dir . "/" . $filename);
                Image::make($file->getRealPath())->save($path);
            } else {
                $path = public_path($dir . "/");
                $file->move($path, $filename);
            }
            if (self::folderFounder($data[0][$field]) != "") {
                File::deleteDirectory(public_path(self::folderFounder($data[0][$field])));
            }
            return $dir . "/" . $filename;
        } else {
            return $data[0][$field];
        }

    }

    static function directoryDelete($filePath)
    {
        if (self::folderFounder($filePath) != "") {
            File::deleteDirectory(public_path(self::folderFounder($filePath)));
        }
    }


    static function imageUpload($name = "grown", $directory = "urun", $file)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        $dirLarge = $dir . '/large';
        if (!empty($file)) {
            if (!File::exists($dirLarge)) {
                File::makeDirectory($dirLarge, 0755, true);
            }
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = rand(1, 90000) . '.' . $file->getClientOriginalExtension();
            $path = public_path($dir . '/' . $filename);
            $path2 = public_path($dirLarge . '/' . $filename);
            Image::make($file->getRealPath())->save($path2);
            Image::make($file->getRealPath())->resize(200, 200)->save($path);
            return $dir . "/" . $filename;
        } else {
            return "";
        }
    }


    static function multipleFileUpload($name, $directory, $files)
    {
        $rand = $name;
        $returnArray = [];
        $dir = 'files/' . $directory . '/' . $rand;
        if (!empty($files)) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            foreach ($files as $file) {
                if (!empty($file)) {
                    $filename = $file->getClientOriginalName();
                    $path = public_path($dir . '/');
                    $file->move($path, $filename);
                    $returnArray[] = $dir . "/" . $filename;
                }
            }
            if (count($returnArray) != 0) {
                return implode(',', $returnArray);
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    static function multipleUpload($name, $directory, $file)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        $dirLarge = $dir . '/large';
        if (!File::exists($dirLarge)) {
            File::makeDirectory($dirLarge, 0755, true);
        }
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        foreach ($file as $image) {
            if (!empty($image)) {
                $filename = rand(1, 90000) . '.' . $image->getClientOriginalExtension();
                $path = public_path($dir . '/' . $filename);
                $path2 = public_path($dirLarge . '/' . $filename);

                Image::make($image->getRealPath())->save($path2);
                Image::make($image->getRealPath())->resize(200, 200)->save($path);

                $imageArray[] = $filename;
            }
        }
        if (count($imageArray) != 0) {
            return implode(',', $imageArray);
        } else {
            return "";
        }
    }


    static function singleUpload($name, $directory, $file)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        $dirLarge = $dir . '/large';
        if (!empty($file)) {
            if (!File::exists($dirLarge)) {
                File::makeDirectory($dirLarge, 0755, true);
            }
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = rand(1, 90000) . '.' . $file->getClientOriginalExtension();
            $path = public_path($dir . '/' . $filename);
            $path2 = public_path($dirLarge . '/' . $filename);

            Image::make($file->getRealPath())->save($path2);
            Image::make($file->getRealPath())->resize(200, 200)->save($path);
            return $dir . "/" . $filename;
        } else {
            return "";
        }
    }


    static function videoUpload($name, $directory, $file)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        if (!empty($file)) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = $file->getClientOriginalName();
            $path = public_path($dir . '/');
            $file->move($path, $filename);
            return $dir . "/" . $filename;
        } else {
            return "";
        }
    }

    static function videoUploadUpdate($name, $directory, $file, $data, $field)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        if (!empty($file)) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            File::delete('public/' . $data[0][$field]);
            $filename = $file->getClientOriginalName();
            $path = public_path($dir . '/');
            $file->move($path, $filename);
            return $dir . "/" . $filename;
        } else {
            return $data[0][$field];
        }
    }

    static function pdfUpload($name, $directory, $file)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        if (!empty($file)) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = $file->getClientOriginalName();
            $path = public_path($dir . '/');
            $file->move($path, $filename);
            return $dir . "/" . $filename;
        } else {
            return "";
        }
    }


    static function singleUploadUpdate($name, $directory, $file, $data, $field)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        $dirLarge = $dir . '/large';
        if (!empty($file)) {
            if (!File::exists($dirLarge)) {
                File::makeDirectory($dirLarge, 0755, true);
            }
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            File::delete('public/' . $data[0][$field]);
            $filename = rand(1, 90000) . '.' . $file->getClientOriginalExtension();
            $path = public_path($dir . '/' . $filename);
            $path2 = public_path($dirLarge . '/' . $filename);
            Image::make($file->getRealPath())->save($path2);
            Image::make($file->getRealPath())->resize(200, 200)->save($path);
            return $dir . "/" . $filename;
        } else {
            return $data[0][$field];
        }
    }

    static function pdfUploadUpdate($name, $directory, $file, $data, $field)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        if (!empty($file)) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            File::delete('public/' . $data[0][$field]);
            $filename = $file->getClientOriginalName();
            $path = public_path($dir . '/');
            $file->move($path, $filename);
            return $dir . "/" . $filename;
        } else {
            return $data[0][$field];
        }
    }


    static function fileUpload($name, $directory, $file)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        $dirLarge = $dir . '/large';
        if (!empty($file)) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            if (!File::exists($dirLarge)) {
                File::makeDirectory($dirLarge, 0755, true);
            }
            $filename = $file->getClientOriginalName();
            $path = public_path($dir . '/');
            $path2 = public_path($dir . '/large/');
            //$file->move($path, $filename);
            $file->move($path2, $filename);
            return $dir . "/" . $filename;
        } else {
            return "";
        }
    }

    static function fileUploadUpdate($name, $directory, $file, $data, $field)
    {
        $rand = $name;
        $dir = 'images/' . $directory . '/' . $rand;
        $dirLarge = $dir . '/large';
        if (!empty($file)) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            if (!File::exists($dirLarge)) {
                File::makeDirectory($dirLarge, 0755, true);
            }
            File::delete('public/' . $data[0][$field]);
            File::delete('public/' . $data[0][$field]);
            $filename = $file->getClientOriginalName();
            $path = public_path($dir . '/');
            $path2 = public_path($dirLarge . '/');
            $file->move($path, $filename);
            $file->move($path2, $filename);
            return $dir . "/" . $filename;
        } else {
            return $data[0][$field];
        }
    }
}