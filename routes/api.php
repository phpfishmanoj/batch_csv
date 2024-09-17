<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadFileChunkController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// bus service
Route::get('/BatchUploadFileData', function(){
    return view('upload-file-batch');
});
Route::post('/batch-upload-file-process', [UploadFileChunkController::class, 'BatchUploadFileProcess']);


// to get the progress details
Route::get('/get-uploaded-batch-details', [UploadFileChunkController::class, 'getBatchUploaded']);

// to get the in-progress batch
Route::get('/get-in-progress-job', [UploadFileChunkController::class, 'getInProgressJob']);