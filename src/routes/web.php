<?php



Route::group(['namespace'=>'lct\Excel\Http\Controllers','middleware' => ['web']],function () {
    Route::get('/ExcelFile','ExcelImport@index')->name('ExcelFile');
    Route::post('/ImportExcelFile','ExcelImport@add')->name('ImportExcelFile');
});





?>