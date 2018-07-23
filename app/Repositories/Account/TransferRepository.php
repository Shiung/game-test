<?php
namespace App\Repositories\Account;

use Doctrine\Common\Collections\Collection;
use App\Models\Account\TransferAccountRecord;

class TransferRepository
{
    protected $transfer;
    /**
     * TransferRepository constructor.
     *
     * @param Transfer $transfer
     */
    public function __construct(TransferAccountRecord $transfer)
    {
        $this->transfer = $transfer;
    }

    /**
     * 依照日期區間回傳列表（給後台）
     * @param $types,start,$end
     * @return Collection
     */
    public function all($types,$start,$end)
    {
        return $this->transfer
                ->whereIn('type',$types)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->transfer->find($id);
    }



}