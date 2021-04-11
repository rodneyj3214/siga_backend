<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Image\DeleteImageRequest;
use App\Http\Requests\App\Image\UpdateImageRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\App\Image\UploadImageRequest;

use App\Models\Authentication\User;
use App\Models\App\Image;

use Intervention\Image\Facades\Image as InterventionImage;

class ImageController extends Controller
{
    public function upload(UploadImageRequest $request, $model)
    {
        $image = $request->file('image');
        $newImage = new Image([
            'code' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
            'name' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
            'description' => $request->input('description'),
            'extension' => $image->getClientOriginalExtension(),
            'uri' => 'asd'
        ]);

        $newImage->imageable()->associate($model);
        $newImage->save();

        Storage::makeDirectory('images\\' . $newImage->id);

        $this->uploadOriginal(InterventionImage::make($image), $newImage->id);
        $this->uploadLargeImage(InterventionImage::make($image), $newImage->id);
        $this->uploadMediumImage(InterventionImage::make($image), $newImage->id);
        $this->uploadSmallImage(InterventionImage::make($image), $newImage->id);

        $newImage->uri = 'images/' . $newImage->id . '.jpg';
        $newImage->save();

        return response()->json([
            'data' => $newImage->uri,
            'msg' => [
                'summary' => 'Imagen subida',
                'detail' => 'La imagen fue subida correctamente',
                'code' => '201'
            ]], 201);
    }

    public function update(UpdateImageRequest $request, $imageId)
    {
        // Valida que exista la imagen, si no encuentra el registro en la base devuelve un mensaje de error
        if (!Image::find($imageId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Imagen no encontrada',
                    'detail' => 'La imagen no pudo ser modificada',
                    'code' => '404'
                ]], 404);
        }

        $this->uploadLargeImage($request->file('image'), $imageId);
        $this->uploadMediumImage($request->file('image'), $imageId);
        $this->uploadSmallImage($request->file('image'), $imageId);
        $this->uploadOriginal($request->file('image'), $imageId);

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

    private function uploadOriginal($image, $name)
    {
        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '.jpg';
        $image->save($path, 75);

        $path = storage_path() . '\app\public\images\\' . $name . '\\' . $name . '.webp';
        $image->save($path, 75);

    }
}
