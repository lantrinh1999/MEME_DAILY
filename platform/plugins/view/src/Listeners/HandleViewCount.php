<?php

namespace Botble\View\Listeners;

use Botble\View\Events\ViewCountProcessed;
use Botble\View\Repositories\Interfaces\ViewInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Jenssegers\Agent\Agent;

class HandleViewCount implements ShouldQueue
{
    use InteractsWithQueue;

    private $agent;
    private $request;
    private $viewRepository;

    public $tries = 50;

    public $backoff = [30, 60, 180, 720, 3600, 21600, 151200];

    public function retryUntil()
    {
        return now()->addDay(7);
    }
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Agent $agent, Request $request, ViewInterface $viewRepository)
    {
        if(!empty(\Auth::user()->id)) {
            return;
        }
        $this->agent = $agent;
        $this->request = $request;
        $this->viewRepository = $viewRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ViewCountProcessed  $event
     * @return void
     */
    public function handle(ViewCountProcessed $event)
    {
        try {
            $is_robot = $this->agent->isRobot();
            if(!$is_robot) {
                $visitor = $this->request->ip();
                $user_agent = $this->request->server('HTTP_USER_AGENT');
                $model = $event->model;
                $viewable_id = $model->id;
                $viewable_type = get_class($model);

                $string = '123';
                $key = md5(config('app.env') . $visitor . $user_agent . $viewable_id . $viewable_type . $string);

                $cookie = \Cookie::get($key);
                $cache = \Cache::get($key);

                if (empty($cookie) && empty($cache)) {
                    \Cookie::queue($key, $viewable_id, 3);
                    \Cache::put($key, $viewable_id, 3 * 60);

                    $this->viewRepository->getModel()->create(compact('visitor', 'user_agent', 'viewable_id', 'viewable_type'));

                    if(\Schema::hasColumn($model->getTable(), 'view')) {
                        $model->increment('view');
                    }
                }
            }

        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
        }

    }
}
