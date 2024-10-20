<?php

namespace App\UseCases\Api\Screenshot;

use App\Models\ClientEventDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadAction
{
    public function __invoke(array $input)
    {
        $date = ClientEventDate::findOrFail($input['id']);

        $today = Carbon::today();
        $path = "image/screenshots/".$today->format("Y/m");
        $fname = $input['file']->getClientOriginalName();
        $extension = pathinfo($fname, PATHINFO_EXTENSION);

        $input['file']->storeAs($path, $fname, 'public');

        $screenshot = $date->screenshots()->create([
            "user_id" => Auth::id(),
            "path" => $path,
            "fname" => $fname,
        ]);

        $src = $path.'/'.$fname;
        $dest = $path.'/'.$screenshot->id.'.'.$extension;
        Storage::disk('public')->move($src, $dest);

        return [
            'id' => $screenshot->id,
            'name' => $date->client_event->name,
            'url' => $screenshot->url,
        ];
    }
}
