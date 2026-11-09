<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventExplorerController extends Controller
{
    // NAIVE: lazy loading (sinadya, para mabilang ang N+1)
        public function naive()
    {
        Model::preventLazyLoading(false);
        DB::enableQueryLog();

        $events = Event::upcoming()->earliestFirst()->limit(50)->get();

        return $this->renderCounted('explorer.naive', ['events' => $events]);
    }

    // FIXED: eager loading + count
    public function index()
    {
        DB::enableQueryLog();

        $events = Event::upcoming()->earliestFirst()->forList()->limit(50)->get();

        return $this->renderCounted('explorer.index', ['events' => $events]);
    }

    // JSONB filter (dalawang paraan)
    public function filter(Request $request)
    {
        $code = $request->query('dress_code', 'costume');

        $arrow = Event::dressCode($code);
        $contains = Event::whereJsonContains('details', ['dress_code' => $code]);

        $arrowSql = $arrow->toSql();
        $arrowBindings = $arrow->getBindings();
        $containsSql = $contains->toSql();
        $containsBindings = $contains->getBindings();

        $events = (clone $arrow)->forList()->limit(50)->get();

        return view('explorer.filter', [
            'events' => $events,
            'code' => $code,
            'arrowSql' => $arrowSql,
            'arrowBindings' => $arrowBindings,
            'containsSql' => $containsSql,
            'containsBindings' => $containsBindings,
            'arrowCount' => $arrow->count(),
            'containsCount' => $contains->count(),
        ]);
    }

    // Full-text search
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $events = collect();
        $sql = null;
        $bindings = [];

        if ($q !== '') {
            $display = Event::search($q)->limit(50);
            $sql = $display->toSql();
            $bindings = $display->getBindings();

            $events = Event::search($q)->forList()->limit(50)->get();
        }

        return view('explorer.search', compact('events', 'q', 'sql', 'bindings'));
    }

    // Binibilang ang queries AFTER ma-render ang view
    private function renderCounted(string $view, array $data)
    {
        $html = view($view, $data + ['queryCount' => '__QUERY_COUNT__'])->render();

        return str_replace('__QUERY_COUNT__', count(DB::getQueryLog()), $html);
    }
}