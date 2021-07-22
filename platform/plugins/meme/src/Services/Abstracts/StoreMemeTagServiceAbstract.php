<?php

namespace Botble\Meme\Services\Abstracts;

use Botble\Meme\Models\Meme;
use Botble\Meme\Repositories\Interfaces\MemeTagInterface;
use Illuminate\Http\Request;

abstract class StoreMemeTagServiceAbstract
{
    /**
     * @var MemeTagInterface
     */
    protected $memeTagRepository;

    /**
     * StoreTagService constructor.
     * @param MemeTagInterface $memeTagRepository
     */
    public function __construct(MemeTagInterface $memeTagRepository)
    {
        $this->memeTagRepository = $memeTagRepository;
    }

    /**
     * @param Request $request
     * @param Meme $meme
     * @return mixed
     */
    abstract public function execute(Request $request, Meme $meme);
}
