<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\UploadFileChunkController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/upload', function(){
    return view('upload-file');
});

Route::post('/upload-file', [UploadFileController::class, 'UploadFile']);

Route::get('/upload-chunk', function(){
    return view('upload-file-chunk');
});


Route::post('/upload-file-chunk', [UploadFileChunkController::class, 'UploadFile']);
Route::get('/store-data', [UploadFileChunkController::class, 'storeData']);

Route::get('/job-store-data', [UploadFileChunkController::class, 'JobStoreData']);

Route::get('/job-store-dataV2', [UploadFileChunkController::class, 'storeDataV2']);


Route::get('/oneUpload', function(){
    return view('one-upload-file');
});

Route::post('/one-upload-file', [UploadFileChunkController::class, 'oneUploaData']); //50K

//no csv 

Route::get('/UploadFileData', function(){
    return view('upload-file-data');
});
Route::post('/upload-file-process', [UploadFileChunkController::class, 'uploadFileProcess']);

// bus service
Route::get('/BatchUploadFileData', function(){
    return view('upload-file-batch');
});
Route::post('/batch-upload-file-process', [UploadFileChunkController::class, 'BatchUploadFileProcess']);


// to get the progress details
Route::get('/get-batch-uploaded', [UploadFileChunkController::class, 'getBatchUploaded']);