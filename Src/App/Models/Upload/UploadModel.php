<?php
namespace Src\App\Models\Upload;
use Src\App\Modle;

class UploadModel extends Modle
{
          public function validateVideoUploadInputs($title, $description, $category, $tags): array
          {

                    $errors = [];

                    if (empty($title)) {
                              $errors['upload_title_error'] = 'Title is required';
                    }

                    if (empty($description)) {
                              $errors['upload_description_error'] = 'Description is required';
                    }

                    if (empty($tags)) {
                              $errors['upload_tags_error'] = 'Tags is required';
                    }

                    return $errors;
          }
}