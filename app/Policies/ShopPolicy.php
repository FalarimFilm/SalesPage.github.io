<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.  
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    function update(User $user,Shop $shop) {
        return $user->isAdministrator() && $shop->user_id == $user;
        }
    function delete(User $user, Shop $shop) {
        return $this->update($user) && $shop->user_id == $user;
        }
}
