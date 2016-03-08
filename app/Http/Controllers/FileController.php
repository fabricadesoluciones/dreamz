<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Storage;
use Session; 

class FileController extends Controller
{
    public function downloadFile($id){

    	$file = File::find($id);
        $filename = $file->name;
        if (!$file) {
			return HomeController::returnError(404);
        }
        $path = $file->path;

        $exists = Storage::disk('s3')->exists($path);

        if (!$exists) {
			return HomeController::returnError(404);
        }

        $file = Storage::disk('s3')->get($path);
        if (!$file) {
            return HomeController::returnError(404);
        }

        header("Content-type:application/octet-stream");
        header("Content-Disposition:attachment;filename=".$filename);

        return $file;
    }

    public function deleteFile($id){

    	$file = File::find($id);

        if (!$file) {
			return HomeController::returnError(404);
        }
        $filename = $file->filename;
        $path = $file->type.'/'.$filename;

        $exists = Storage::disk('s3')->exists($path);

        if (!$exists) {
			return HomeController::returnError(404);
        }

        $file = Storage::disk('s3')->delete($path);
        
        if (!$file) {
			return HomeController::returnError(404);
        }

        Session::flash('update', ['code' => 200, 'message' => 'File was deleted']);
        return redirect(route('assessments'));
    }

    public function savetFile($filename, $type){

        $filename = 'DB-Dreamz.pdf';
        // $contents = Storage::disk('local')->read($path);
        // $disk = Storage::disk('s3')->put('DB-Dreamz.pdf', $contents);

        $file = Storage::disk('s3')->get($filename);
        header("Content-type:application/octet-stream");
        header("Content-Disposition:attachment;filename=".$filename);

        /** GET PUBLIC URL

        Storage::disk('s3')->setVisibility( $path , 'public');
        $bucket = Config::get('filesystems.disks.s3.bucket');
        $s3 = Storage::disk('s3');
        $url = $s3->getDriver()->getAdapter()->getClient()->getObjectUrl($bucket, $path);
        die(json_encode($url));

        **/

        return $file;
    }
}
