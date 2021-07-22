<?php

namespace Botble\Meme\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Meme\Forms\MemeTagForm;
use Botble\Meme\Http\Requests\MemeTagRequest;
use Botble\Meme\Repositories\Interfaces\MemeTagInterface;
use Botble\Meme\Tables\MemeTagTable;
use Exception;
use Illuminate\Http\Request;

class MemeTagController extends BaseController
{
    /**
     * @var MemeTagInterface
     */
    protected $memeTagRepository;

    /**
     * @param MemeTagInterface $memeTagRepository
     */
    public function __construct(MemeTagInterface $memeTagRepository)
    {
        $this->memeTagRepository = $memeTagRepository;
    }

    /**
     * @param MemeTagTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(MemeTagTable $table)
    {
        page_title()->setTitle(trans('plugins/meme::meme-tag.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/meme::meme-tag.create'));

        return $formBuilder->create(MemeTagForm::class)->renderForm();
    }

    /**
     * @param MemeTagRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(MemeTagRequest $request, BaseHttpResponse $response)
    {
        $memeTag = $this->memeTagRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(MEME_TAG_MODULE_SCREEN_NAME, $request, $memeTag));

        return $response
            ->setPreviousUrl(route('meme-tag.index'))
            ->setNextUrl(route('meme-tag.edit', $memeTag->id))
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
        $memeTag = $this->memeTagRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $memeTag));

        page_title()->setTitle(trans('plugins/meme::meme-tag.edit') . ' "' . $memeTag->name . '"');

        return $formBuilder->create(MemeTagForm::class, ['model' => $memeTag])->renderForm();
    }

    /**
     * @param int $id
     * @param MemeTagRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, MemeTagRequest $request, BaseHttpResponse $response)
    {
        $memeTag = $this->memeTagRepository->findOrFail($id);

        $memeTag->fill($request->input());

        $this->memeTagRepository->createOrUpdate($memeTag);

        event(new UpdatedContentEvent(MEME_TAG_MODULE_SCREEN_NAME, $request, $memeTag));

        return $response
            ->setPreviousUrl(route('meme-tag.index'))
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
            $memeTag = $this->memeTagRepository->findOrFail($id);

            $this->memeTagRepository->delete($memeTag);

            event(new DeletedContentEvent(MEME_TAG_MODULE_SCREEN_NAME, $request, $memeTag));

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
            $memeTag = $this->memeTagRepository->findOrFail($id);
            $this->memeTagRepository->delete($memeTag);
            event(new DeletedContentEvent(MEME_TAG_MODULE_SCREEN_NAME, $request, $memeTag));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function getAllTags()
    {
        return $this->memeTagRepository->pluck('name');
    }
}
