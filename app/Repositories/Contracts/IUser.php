<?php


namespace App\Repositories\Contracts;


interface IUser extends IModelRepository
{


    public function storeDevice($request, $user_id);

}
