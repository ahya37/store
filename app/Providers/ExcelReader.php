<?php
	
	include base_path('vendorcustom/excel_reader.php');

    // $baris = $data->rowcount($sheet_index=1);

	// var_dump($data);
	$file   		 = $request->file('file');
    $destinationPath = public_path('contoh');
    // upload file xls

	$target = basename($file);
	// move_uploaded_file($destinationPath, $target);
	 
	// beri permisi agar file xls dapat di baca
	chmod($file,0777);
	 
	// mengambil isi file xls
	$data = new Spreadsheet_Excel_Reader($file,false);
	// menghitung jumlah baris data yang ada
	$jumlah_baris = $data->rowcount($sheet_index=0);
	 
	// jumlah default data yang berhasil di import
	$berhasil = 0;
	