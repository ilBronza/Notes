@extends('uikittemplate::app')

@section('content')
@include('notes::tasks._styles')

<section class="nt-workspace" data-task-workspace aria-label="{{ __('notes::tasks.manage') }}">
    <header class="nt-header">
        <div class="nt-heading">
            <span class="nt-app-icon" data-icon="tasks" aria-hidden="true"></span>
            <div>
                <p class="nt-eyebrow">{{ __('notes::tasks.eyebrow') }}</p>
                <h1>{{ $showClosed ? __('notes::tasks.closed') : __('notes::tasks.workspace') }}</h1>
                <p class="nt-intro">{{ __('notes::tasks.' . ($showClosed ? 'closedIntro' : 'intro')) }}</p>
            </div>
        </div>
        @if($canCreate)
            <a class="nt-button nt-button-primary" href="{{ $createUrl }}">
                <span data-icon="plus" aria-hidden="true"></span>{{ __('notes::tasks.new') }}
            </a>
        @endif
    </header>

    <nav class="nt-navigation" aria-label="{{ __('notes::tasks.manage') }}">
        <div class="nt-view-tabs" role="group" aria-label="{{ __('notes::tasks.listView') }} / {{ __('notes::tasks.boardView') }}">
            <button type="button" class="nt-tab is-active" data-view="list" aria-pressed="true"><span data-icon="list" aria-hidden="true"></span>{{ __('notes::tasks.listView') }}</button>
            <button type="button" class="nt-tab" data-view="board" aria-pressed="false"><span data-icon="board" aria-hidden="true"></span>{{ __('notes::tasks.boardView') }}</button>
        </div>
        <div class="nt-scope-links">
            <a href="{{ $indexUrl }}" @if(!$showClosed) aria-current="page" @endif>{{ __('notes::tasks.active') }}</a>
            <a href="{{ $closedUrl }}" @if($showClosed) aria-current="page" @endif><span data-icon="check" aria-hidden="true"></span>{{ __('notes::tasks.closed') }}</a>
        </div>
    </nav>

    <div class="nt-stats" data-stats></div>

    <div class="nt-toolbar">
        <div class="nt-filter-chips" role="group" aria-label="{{ __('notes::tasks.all') }}">
            <button class="nt-chip is-active" type="button" data-filter="all" aria-pressed="true">{{ __('notes::tasks.all') }} <span data-count="all">0</span></button>
            @if($isStaff)<button class="nt-chip" type="button" data-filter="mine" aria-pressed="false">{{ __('notes::tasks.mine') }} <span data-count="mine">0</span></button>@endif
            @if(!$showClosed)
                <button class="nt-chip" type="button" data-filter="overdue" aria-pressed="false"><span class="nt-dot nt-dot-red"></span>{{ __('notes::tasks.overdue') }} <span data-count="overdue">0</span></button>
            @endif
        </div>
        <div class="nt-search-controls">
            <label class="nt-search"><span data-icon="search" aria-hidden="true"></span><input type="search" data-search placeholder="{{ __('notes::tasks.search') }}" aria-label="{{ __('notes::tasks.search') }}" autocomplete="off"></label>
            <select data-assignee aria-label="{{ __('notes::tasks.assignee') }}"><option value="all">{{ __('notes::tasks.allAssignees') }}</option><option value="unassigned">{{ __('notes::tasks.unassigned') }}</option></select>
        </div>
    </div>

    <div class="nt-content-meta"><span data-result-count aria-live="polite"></span><span class="nt-board-hint" data-board-hint hidden>{{ __('notes::tasks.boardHint') }}</span>@if($isStaff)<a href="{{ $tableUrl }}">{{ __('notes::tasks.tableView') }} <span aria-hidden="true">↗</span></a>@endif</div>
    <div data-task-content aria-busy="false"></div>
    <noscript><p class="nt-empty">{{ __('notes::tasks.javascriptRequired') }} <a href="{{ $tableUrl }}">{{ __('notes::tasks.tableView') }}</a></p></noscript>

    <div class="nt-toast" data-toast role="status" aria-live="polite" hidden></div>
    <dialog class="nt-drawer" data-detail aria-labelledby="nt-detail-title">
        <div class="nt-drawer-top"><span class="nt-eyebrow">{{ __('notes::tasks.details') }}</span><button type="button" class="nt-icon-button" data-close-detail aria-label="{{ __('notes::tasks.closePanel') }}"><span data-icon="close" aria-hidden="true"></span></button></div>
        <div data-detail-content></div>
    </dialog>

    <script type="application/json" data-task-config>{!! json_encode([
        'tasks' => $tasks,
        'statuses' => $statuses,
        'showClosed' => $showClosed,
        'currentUserId' => $currentUserId,
        'today' => $today,
        'canCreate' => $canCreate,
        'isStaff' => $isStaff,
        'createUrl' => $createUrl,
        'initialView' => in_array(request()->query('view'), ['list', 'board']) ? request()->query('view') : null,
        'csrfToken' => csrf_token(),
        'text' => __('notes::tasks'),
    ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}</script>
</section>

@include('notes::tasks._scripts')
@endsection
