<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
    function update(User $user, Product $product) {
        return $user->isAdministrator() && $product->shop_id == $shop ;
        }
    function delete(User $user, Product $product) {
        return $this->update($user) && ($product->price < 500) && $product->shop_id == $shop;
        }
}
