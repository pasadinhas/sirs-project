<?php

namespace Shuttle\Providers;

use Carbon\Carbon;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Shuttle\Events\SomeEvent' => [
            'Shuttle\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        Event::listen('illuminate.query', function($query, $bindings, $time, $connectionName) {
            if ( ! starts_with($query, 'select'))
            {
                if (starts_with($query, 'select'))
                {
                    return;
                }

                $data = [];

                $user = Auth::user();

                if ($user == null)
                {
                    $data['user'] = null;
                }
                else
                {
                    $data['user'] = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username
                    ];
                }

                $data['query'] = $query;
                $data['bindings'] = $bindings;
                $data['time'] = new Carbon();
                $data['connection'] = $connectionName;

                $data['ip'] = [
                    'REMOTE_ADDR' => isset($_SERVER['REMOTE_ADDR']) ?: null,
                    'HTTP_X_FORWARDED_FOR' => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?: null,
                ];

                Log::info('Query: ' . json_encode($data));
            }
        });
    }
}
