<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        try{
            $validateImage = Validator::make($request->all(), [
                'upload' => 'required|mimes:jpg,png,webp,gif',
            ]);
            
            if(!$validateImage->fails())
            {
                $image = $this->image($request);
                return $image;
            }

            $validateAudio = Validator::make($request->all(), [
                'upload' => 'required|mimes:mp3,wav',
            ]);
            
            if(!$validateAudio->fails())
            {
                $audio = $this->audio($request);
                return $audio;
            }

        }catch (Exception $exception){
            return response()->json(['message'=> 'error', 'exception'=>$exception->getMessage()], 500);
        }

    }

    public function image(Request $request)
    {
        $path = 'image';
		$file = $request->file('upload');
        $fileName = $file->getClientOriginalName();
		$file->move($path,$fileName);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $url = asset('image/'.$fileName);
        $msg = 'Image successfully uploaded'; 

        return '<script>window.parent.CKEDITOR.tools.callFunction("'.$CKEditorFuncNum.'", "'.$url.'", "'.$msg.'")</script>';
    }

    public function audio(Request $request)
    {
        $path = 'audio';
		$file = $request->file('upload');
        $fileName = $file->getClientOriginalName();
		$file->move($path,$fileName);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $url = asset('audio/'.$fileName);
        $msg = 'Audio successfully uploaded'; 

        return '<script>window.parent.CKEDITOR.tools.callFunction("'.$CKEditorFuncNum.'", "'.$url.'", "'.$msg.'")</script>';
    }
}
