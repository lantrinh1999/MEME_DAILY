<?php

namespace Botble\Base\Repositories\Eloquent;

use Botble\Base\Repositories\Interfaces\MetaBoxInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class MetaBoxRepository extends RepositoriesAbstract implements MetaBoxInterface
{
    public function getFirst(array $arr = [], array $select = [])
    {
        return $this->getFirstBy($arr, $select);
    }
}
