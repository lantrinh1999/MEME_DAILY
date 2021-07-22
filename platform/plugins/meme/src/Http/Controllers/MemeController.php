<?php

namespace Botble\Meme\Http\Controllers;

use Botble\ACL\Models\User;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Meme\Forms\MemeForm;
use Botble\Meme\Http\Requests\MemeRequest;
use Botble\Meme\Repositories\Interfaces\MemeInterface;
use Botble\Meme\Repositories\Interfaces\MemeTagInterface;
use Botble\Meme\Services\StoreMemeTagService;
use Botble\Meme\Tables\MemeTable;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;

class MemeController extends BaseController
{
    /**
     * @var MemeInterface
     */
    protected $memeRepository;
    protected $memeTagRepository;

    /**
     * @param MemeInterface $memeRepository
     */
    public function __construct(MemeInterface $memeRepository, MemeTagInterface $memeTagRepository)
    {
        $this->memeRepository = $memeRepository;
        $this->memeTagRepository = $memeTagRepository;
    }

    /**
     * @param MemeTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(MemeTable $table)
    {
        page_title()->setTitle(trans('plugins/meme::meme.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/meme::meme.create'));

        return $formBuilder->create(MemeForm::class)->renderForm();
    }

    /**
     * @param MemeRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(MemeRequest $request, StoreMemeTagService $memeTagService, BaseHttpResponse $response)
    {
        $meme = $this->memeRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::id() ?? 0,
            'author_type' => User::class ?? null,
        ]));

        event(new CreatedContentEvent(MEME_MODULE_SCREEN_NAME, $request, $meme));

        $memeTagService->execute($request, $meme);

        return $response
            ->setPreviousUrl(route('meme.index'))
            ->setNextUrl(route('meme.edit', $meme->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $meme = $this->memeRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $meme));

        page_title()->setTitle(trans('plugins/meme::meme.edit') . ' "' . $meme->name . '"');

        return $formBuilder->create(MemeForm::class, ['model' => $meme])->renderForm();
    }

    /**
     * @param int $id
     * @param MemeRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, MemeRequest $request, StoreMemeTagService $memeTagService, BaseHttpResponse $response)
    {
        $meme = $this->memeRepository->findOrFail($id);

        $meme->fill($request->input());

        $this->memeRepository->createOrUpdate($meme);

        event(new UpdatedContentEvent(MEME_MODULE_SCREEN_NAME, $request, $meme));

        $memeTagService->execute($request, $meme);

        return $response
            ->setPreviousUrl(route('meme.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $meme = $this->memeRepository->findOrFail($id);

            $this->memeRepository->delete($meme);

            event(new DeletedContentEvent(MEME_MODULE_SCREEN_NAME, $request, $meme));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $meme = $this->memeRepository->findOrFail($id);
            $this->memeRepository->delete($meme);
            event(new DeletedContentEvent(MEME_MODULE_SCREEN_NAME, $request, $meme));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
