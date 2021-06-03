<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        try{
            // Upload Image
            $validateImage = Validator::make($request->all(), [
                'upload' => 'required|mimes:jpg,png,webp,gif',
            ]);
            if(!$validateImage->fails())
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

            // Upload Audio
            $validateAudio = Validator::make($request->all(), [
                'upload' => 'required|mimes:mp3,wav',
            ]);
            if(!$validateAudio->fails())
            {
                $path = 'audio';
                $file = $request->file('upload');
                $fileName = 'audio'.date('dmYHis').'.'.$file->extension();
                $file->move($path,$fileName);

                $url = asset('audio/'.$fileName);
                $msg = 'Audio successfully uploaded'; 
                $CKEditorFuncNum = $request->input('CKEditorFuncNum');

                if(!$CKEditorFuncNum)
                {
                    return $url;
                }

                return '<script>window.parent.CKEDITOR.tools.callFunction("'.$CKEditorFuncNum.'", "'.$url.'", "'.$msg.'")</script>';
            }

            // Upload Audio
            $validateVideo = Validator::make($request->all(), [
                'upload' => 'required|mimes:mkv,mp4',
            ]);
            if(!$validateVideo->fails())
            {
                $path = 'video';
                $file = $request->file('upload');
                $fileName = 'video'.date('dmYHis').'.'.$file->extension();
                $file->move($path,$fileName);

                $url = asset('video/'.$fileName);
                $msg = 'Video successfully uploaded'; 
                $CKEditorFuncNum = $request->input('CKEditorFuncNum');

                if(!$CKEditorFuncNum)
                {
                    return $url;
                }

                return '<script>window.parent.CKEDITOR.tools.callFunction("'.$CKEditorFuncNum.'", "'.$url.'", "'.$msg.'")</script>';
            }

            // Upload Document
            $validateDocument = Validator::make($request->all(), [
                'upload' => 'required|mimes:doc,docx,xls,xlsx,pdf',
            ]);
            if(!$validateDocument->fails())
            {
                $path = 'document';
                $file = $request->file('upload');
                $fileName = $file->getClientOriginalName();
                $file->move($path,$fileName);

                $url = asset('document/'.$fileName);
                $msg = 'Document successfully uploaded'; 
                $CKEditorFuncNum = $request->input('CKEditorFuncNum');

                if(!$CKEditorFuncNum)
                {
                    return $url;
                }
                
                return '<script>window.parent.CKEDITOR.tools.callFunction("'.$CKEditorFuncNum.'", "'.$url.'", "'.$msg.'")</script>';
            }

        }catch (Exception $exception){
            return response()->json(['message'=> 'error', 'exception'=>$exception->getMessage()], 500);
        }

    }
}