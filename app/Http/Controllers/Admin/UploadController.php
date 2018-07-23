<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UploadsManager;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Image;
use Log;
use Exception;

class UploadController extends Controller
{
  protected $manager;

  public function __construct(UploadsManager $manager)
  {
    $this->manager = $manager;
  }

  /**
   * Show page of files / subfolders
   */
  public function index(Request $request,$field_name = 'N',$image_part = 'N')
  {
    $folder = $request->get('folder');
    $arr = $this->manager->folderInfo($folder);
    $arr['field_name'] = $field_name;
    $arr['image_part'] = $image_part;
    $data = $arr;
    return view('admin.upload.index', $data);
  }

  /**
   * Create a new folder
   */
  public function createFolder(UploadNewFolderRequest $request)
  {
    $new_folder = $request->get('new_folder');
    $folder = $request->get('folder').'/'.$new_folder;

    $result = $this->manager->createDirectory($folder);

    if ($result === true) {
      return redirect()
          ->back()
          ->withSuccess("Folder '$new_folder' created.");
    }

    $error = $result ? : "An error occurred creating directory.";
    return redirect()
        ->back()
        ->withErrors([$error]);
  }

  /**
   * Delete a file
   */
  public function deleteFile(Request $request)
  {
    $del_file = $request->get('del_file');
    $path = $request->get('folder').'/'.$del_file;

    $result = $this->manager->deleteFile($path);

    if ($result === true) {
      return redirect()
          ->back()
          ->withSuccess("File '$del_file' deleted.");
    }

    $error = $result ? : "An error occurred deleting file.";
    return redirect()
        ->back()
        ->withErrors([$error]);
  }

  /**
   * Delete a folder
   */
  public function deleteFolder(Request $request)
  {
    $del_folder = $request->get('del_folder');
    $folder = $request->get('folder').'/'.$del_folder;

    $result = $this->manager->deleteDirectory($folder);

    if ($result === true) {
      return redirect()
          ->back()
          ->withSuccess("Folder '$del_folder' deleted.");
    }

    $error = $result ? : "An error occurred deleting directory.";
    return redirect()
        ->back()
        ->withErrors([$error]);
  }

  /**
   * Upload new file
   */
  public function uploadFile(UploadFileRequest $request)
  {
    if (Input::hasFile('file')) {
        $files = Input::file('file');
        foreach ($files  as $file) {
            //取得純檔名（不含副檔名）
            $filename=$file->getClientOriginalName();
            $folder = $request->get('folder').'/';
            $this->manager->saveFile($folder, $filename,File::get($file));
        }
    }
    return redirect()
          ->back();
  }
}