<?php namespace App\Contracts;

/**
 * 檔案上傳
 * 
 */

interface UploadInterface
{
    
    /**
     * 上傳
     * @param $file
     */
    public function upload();
	
	/**
     * 刪除檔案
     * @param $file
     */
	public function delete();
}
