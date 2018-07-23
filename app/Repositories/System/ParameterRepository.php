<?php
namespace App\Repositories\System;

use App\Models\System\Parameter;
use App\Models\System\ParameterChangeRecord;

class ParameterRepository
{
    protected $parameter;
    protected $changeRecord;
    /**
     * ParameterRepository constructor.
     *
     * @param Parameter $parameter
     * @param ParameterChangeRecord $changeRecord
     */
    public function __construct(
        Parameter $parameter, 
        ParameterChangeRecord $changeRecord
    ) {
        $this->parameter = $parameter;
        $this->changeRecord = $changeRecord;
    }

    /**
     * 回傳參數
     * @param $name
     * @return Collection
     */
    public function find($name)
    {
        return $this->parameter->where('name',$name)
                         ->first();
    }

    /**
     * 回傳參數值
     * @param $name
     * @return Collection
     */
    public function findValueByName($name)
    {
        return $this->parameter->where('name',$name)
                         ->first()
                         ->value;
    }

    /**
     * 更新參數
     * @param  name,value
     * @return Collection
     */
    public function update($name, $value)
    {
        return $this->parameter->where('name',$name)->update([
            'value' => $value
        ]);
    }

    /**
     * 新增參數變動紀錄
     * @param  data
     * @return Collection
     */
    public function addChangeRecord($data)
    {
        return $this->changeRecord->create($data);
    }

    
}