<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class GoogleDriveController extends Controller
{
    private $drive;
    public function __construct(Google_Client $client){
        $this->middleware(function($request, $next) use ($client){
            $client->refreshToken(Auth::user()->refresh_token);
            $this->drive = new Google_Service_Drive($client);
            return $next($request);
        });
    }

    public function getFolders(){
        $this->ListFolders('root');
    }

    public function ListFolders($id){
        $query = "mimeType='application/vnd.google-apps.folder' and '".$id."' in parents and trashed=false";

        $optParams = [
            'fields'=>'files(id,name)',
            'q'=>$query
        ];

        $results = $this->drive->files->ListFiles($optParams);
        $list = $results->getFiles();
        // dd($list);
        print view('drive.index', compact('list'));
    }

    public function uploadFiles(Request $request){
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $mime_type = $file->getMimeType();
            $title = $file->getClientOriginalName();
            $description = $request->input('description');

            //Crear Carpeta en drive
            $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                'name' => 'Prueba Folder 2',
                'mimeType' => 'application/vnd.google-apps.folder'));
                    $file = $this->drive->files->create($fileMetadata, array(
                'fields' => 'id'));
                return ['file_name'=>'Prueba Folder 2','file_id'=>$file->id];

            // //Crear archivo en drive
            // $drive_file = new Google_Service_Drive_DriveFile;
            // $drive_file->setName($title);
            // $drive_file->setDescription($description);
            // $drive_file->setMimeType($mime_type);

            // // dd($file);

            // try {
            //     $createdFile = $this->drive->files->create($drive_file, [
            //         'data' => file_get_contents($file),
            //         'mimeType' => $mime_type,
            //         'uploadType' => 'multipart'
            //     ]);

            //     $file_id = $createdFile->getId();

            //     return redirect('/upload')
            //         ->with('message', [
            //             'type' => 'success',
            //             'text' => "File was uploaded with the following ID: {$file_id}"
            //     ]);

            // } catch (Exception $e) {
            //     return redirect('/upload')
            //         ->with('message', [
            //             'type' => 'error',
            //             'text' => 'An error occurred while trying to upload the file'
            //         ]);

            // }
        }
    }
}