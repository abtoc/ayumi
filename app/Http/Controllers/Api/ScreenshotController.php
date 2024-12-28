<?php

namespace App\Http\Controllers\Api;

use App\Models\Screenshot;
use App\UseCases\Api\Screenshot\IndexAction;
use App\UseCases\Api\Screenshot\ShowAction;
use App\UseCases\Api\Screenshot\UploadAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScreenshotController extends BaseController
{
    public function index(Request $request, IndexAction $action)
    {
        $result = $action();

        return $this->sendResponse(
            'Scrennshot',
            $result,
        );
    }

    public function show(Request $request, ShowAction $action)
    {
        $input = $request->validate([
            'date' => ['required', 'date'],
        ]);

        $result = $action($input);

        return $this->sendResponse(
            'Screenshot',
            $result,
        );
    }

    public function upload(Request $request, UploadAction $action)
    {
        $input = $request->validate([
            'id' => ['required', 'exists:client_event_dates,id'],
            'file' => ['required', 'file',' mimes:jpeg,jpg,png,mp4'],
        ]);

        $result = $action($input);

        return $this->sendResponse(
            'Screenshot',
            $result,
        );
    }

    public function delete(Screenshot $screenshot)
    {
        Storage::disk('public')->delete($screenshot->path.'/'.$screenshot->fname);
        $screenshot->delete();
        return $this->sendResponse(
            'Screenshot',
            [],
        );
    }
}
