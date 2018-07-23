<?php
namespace App\Presenters;

class AdminPresenter
{
    /**
     * 判斷會員有哪些權限需要被checked
     *
     * @param  $role_id,$user_role
     * @return string
     */
    public function checkOptionChecked($role_id,$user_role)
    {
        foreach ($user_role as $role) {
          if ($role_id == $role['id']) {
              return 'checked'; 
          }
        }
       
    }


}