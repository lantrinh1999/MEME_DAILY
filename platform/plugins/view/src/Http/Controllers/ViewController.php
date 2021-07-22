<?php

namespace Botble\View\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\View\Http\Requests\ViewRequest;
use Botble\View\Repositories\Interfaces\ViewInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\View\Tables\ViewTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\View\Forms\ViewForm;
use Botble\Base\Forms\FormBuilder;

class ViewController extends BaseController
{
    /**
     * @var ViewInterface
     */
    protected $viewRepository;

    /**
     * @param ViewInterface $viewRepository
     */
    public function __construct(ViewInterface $viewRepository)
    {
        $this->viewRepository = $viewRepository;
    }

    /**
     * @param ViewTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(ViewTable $table)
    {
        page_title()->setTitle(trans('plugins/view::view.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/view::view.create'));

        return $formBuilder->create(ViewForm::class)->renderForm();
    }

    /**
     * @param ViewRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ViewRequest $request, BaseHttpResponse $response)
    {
        $view = $this->viewRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(VIEW_MODULE_SCREEN_NAME, $request, $view));

        return $response
            ->setPreviousUrl(route('view.index'))
            ->setNextUrl(route('view.edit', $view->id))
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
        $view = $this->viewRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $view));

        page_title()->setTitle(trans('plugins/view::view.edit') . ' "' . $view->name . '"');

        return $formBuilder->create(ViewForm::class, ['model' => $view])->renderForm();
    }

    /**
     * @param int $id
     * @param ViewRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, ViewRequest $request, BaseHttpResponse $response)
    {
        $view = $this->viewRepository->findOrFail($id);

        $view->fill($request->input());

        $this->viewRepository->createOrUpdate($view);

        event(new UpdatedContentEvent(VIEW_MODULE_SCREEN_NAME, $request, $view));

        return $response
            ->setPreviousUrl(route('view.index'))
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
            $view = $this->viewRepository->findOrFail($id);

            $this->viewRepository->delete($view);

            event(new DeletedContentEvent(VIEW_MODULE_SCREEN_NAME, $request, $view));

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
            $view = $this->viewRepository->findOrFail($id);
            $this->viewRepository->delete($view);
            event(new DeletedContentEvent(VIEW_MODULE_SCREEN_NAME, $request, $view));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
