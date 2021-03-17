<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\File;
use App\Models\Authentication\User;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }

    public function upload(Request $request)
    {
        return $request->person;
        $user = User::findOrFail(1);
        foreach ($request->file('files') as $file) {
            $newFile = $user->files()->firstWhere('name', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            if (!$newFile) {
                $newFile = new File([
                    'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'description' => '',
                    'extension' => $file->getClientOriginalExtension()
                ]);
                $newFile->fileable()->associate($user);
                $newFile->save();
                $filePath = $file->storeAs('files', $newFile->id . '.' . $newFile->extension, 'public');
                $newFile->uri = $filePath;
                $newFile->save();
            }else{
                $file->storeAs('files', $newFile->id . '.' . $newFile->extension, 'public');
            }
        }
    }

}
