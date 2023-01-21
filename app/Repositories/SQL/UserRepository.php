<?php


namespace App\Repositories\SQL;


use App\Models\Device;
use App\Repositories\Contracts\IUser;
use App\Models\User;

class UserRepository extends AbstractModelRepository implements IUser
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }


    public function storeDevice($request, $user_id): bool
    {

        $check_device = Device::query()->where('device_id', $request->device_id)->where('type', $request->type)->first();

        if ($check_device) {
            $check_device->update(['device' => $request->device, 'user_id' => $user_id]);
        } else {
            Device::query()->create([
                'user_id' => $user_id ?? null,
                'device' => $request->device,
                'type' => $request->type,
                'device_id' => $request->device_id,
            ]);
        }
        return true;
    }


}
