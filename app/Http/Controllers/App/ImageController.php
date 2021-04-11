<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;
use App\Http\Requests\App\Image\UpdateImageRequest;
use App\Http\Requests\App\Image\UploadImageRequest;
use App\Models\App\Image;

class ImageController extends Controller
{
    public function upload(UploadImageRequest $request, $model)
    {
        foreach ($request->file('images') as $image) {
            $newImage = new Image();
            $newImage->name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $newImage->description = $request->input('description');
            $newImage->extension = '.jpg';
            $newImage->imageable()->associate($model);
            $newImage->save();

            Storage::makeDirectory('images\\' . $newImage->id);

            $this->uploadOriginal(InterventionImage::make($image), $newImage->id);
            $this->uploadLargeImage(InterventionImage::make($image), $newImage->id);
            $this->uploadMediumImage(InterventionImage::make($image), $newImage->id);
            $this->uploadSmallImage(InterventionImage::make($image), $newImage->id);

            $newImage->directory = 'images';
            $newImage->save();
        }
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Imagen subida',
                'detail' => 'La imagen fue subida correctamente',
                'code' => '201'
            ]], 201);
    }

    public function update(UpdateImageRequest $request, $imageId)
    {
        $image = Image::find($imageId);
        // Valida que exista la imagen, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$image) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Imagen no encontrada',
                    'detail' => 'La imagen no pudo ser modificada',
                    'code' => '404'
                ]], 404);
        }

        $image->name=$request->input('name');
        $image->description=$request->input('description');
        $image->save();

        $this->uploadOriginal($request->file('image'), $imageId);
        $this->uploadLargeImage($request->file('image'), $imageId);
        $this->uploadMediumImage($request->file('image'), $imageId);
        $this->uploadSmallImage($request->file('image'), $imageId);

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Imagen actulizada',
                'detail' => 'La imagen fue actualizada correctamente',
                'code' => '201'
            ]], 201);

    }

    public function delete($imageId)
    {
        $image = Image::find($imageId);
        // Valida que exista la imagen, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$image) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Imagen no encontrada',
                    'detail' => 'La imagen ya ha sido eliminada',
                    'code' => '404'
                ]], 404);
        }
        // Es una eliminación lógica
        $image->state = false;
        $image->save();

        // Elimina los archivos del servidoir
        Storage::deleteDirectory('images\\' . $imageId);

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Imagen eliminada',
                'detail' => 'La imagen fue eliminada correctamente',
                'code' => '201'
            ]], 201);
    }

    // Guarda imagenes con una resolución de 300px de ancho y el alto es ajustable para celulares
    private function uploadSmallImage($image, $name)
    {
        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '-sm.jpg';
        $image->widen(300, function ($constraint) {
            $constraint->upsize();
        })->save($path, 75);

        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '-sm.webp';
        $image->widen(300, function ($constraint) {
            $constraint->upsize();
        })->save($path, 75);
    }

    // Guarda imagenes con una resolución de 750px de ancho y el alto es ajustable para tablets
    private function uploadMediumImage($image, $name)
    {
        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '-md.jpg';
        $image->widen(750, function ($constraint) {
            $constraint->upsize();
        })->save($path, 75);

        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '-md.webp';
        $image->widen(750, function ($constraint) {
            $constraint->upsize();
        })->save($path, 75);
    }

    // Guarda imagenes con una resolución de 1250px de ancho y el alto es ajustable para pc
    private function uploadLargeImage($image, $name)
    {
        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '-lg.jpg';
        $image->widen(1250, function ($constraint) {
            $constraint->upsize();
        })->save($path, 75);

        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '-lg.webp';
        $image->widen(1250, function ($constraint) {
            $constraint->upsize();
        })->save($path, 75);
    }

    // Guarda imagenes con su tamaño original
    private function uploadOriginal($image, $name)
    {
        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '.jpg';
        $image->save($path, 75);

        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '.webp';
        $image->save($path, 75);

    }
}
