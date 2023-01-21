<?php


namespace App\Repositories\SQL;


use App\Models\Device;
use App\Repositories\Contracts\IDevice;

class DeviceRepository extends AbstractModelRepository implements IDevice
{

    public function __construct(Device $model)
    {
        parent::__construct($model);
    }





}
