<?php namespace App\Contracts;

/**
 * 檔案上傳
 * 
 */

interface FileStorageInterface
{
    
    /**
     * 上傳
     * @param $file
     */
    public function upload($file);
	
	/**
     * 刪除檔案
     * @param $file
     */
	public function delete($file);
}
