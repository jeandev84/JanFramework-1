<?php


use Jan\Component\Http\UploadedFile;

function upload(array $file)
{
    $uploadedFiles = [];
    $i = 0;

    /*
    [
        new UploadedFile(),
        new UploadedFile(),
        new UploadedFile()
    ]
    */

    $typeKeys = ['name', 'type', 'tmp_name', 'error', 'size'];
    foreach ($typeKeys as $index)
    {
        if(isset($file[$index]))
        {
            dump($file[$index]);
            $uploadedFile = new UploadedFile();

            /*
            foreach ((array)$file[$index][$i] as $value)
            {
                dump((array) $file[$index][$i]);
                switch ($index)
                {
                    case 'name':
                        $uploadedFile->setFilename($value);
                        break;
                    case 'type':
                        $uploadedFile->setMimeType($value);
                        break;
                    case 'tmp_name':
                        $uploadedFile->setTempFile($value);
                        break;
                    case 'error':
                        $uploadedFile->setError($value);
                        break;
                    case 'size':
                        $uploadedFile->setSize($value);
                        break;
                }
                $uploadedFiles[] = $uploadedFile;
                $i++;
            }
            */
        }
    }

    return $uploadedFiles;
}