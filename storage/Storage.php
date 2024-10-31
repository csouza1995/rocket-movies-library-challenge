<?php

class Storage
{
    public static string $root = 'storage/';

    public static function store($file, string $dir = ''): string
    {
        // set real directory
        $dir = ROOT . "/" . self::$root . $dir;

        // create directory if not exists
        self::makeDir($dir);

        // get file name, extension and path
        $imageName = $file['name'];
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $path = $dir . md5(rand()) . '.' . $imageExtension;

        // move file to directory
        move_uploaded_file($file['tmp_name'], $path);

        return $path;
    }

    public static function delete($path): bool
    {
        try {
            if (file_exists($path)) {
                unlink($path);
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public static function update($file, $oldPath, $dir): string
    {
        if (self::delete($oldPath)) {
            return self::store($file, $dir);
        }

        return $oldPath;
    }

    public static function exists(string $filename, string $dir = ''): bool
    {
        return file_exists($dir . $filename);
    }

    public static function makeDir(string $dir): void
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    public static function base64(string $path): ?string
    {
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);

            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        return null;
    }
}
