<?php

namespace Botble\Base\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface MetaBoxInterface extends RepositoryInterface
{
    public function getFirst(array $arr = [], array $select = []);
}
