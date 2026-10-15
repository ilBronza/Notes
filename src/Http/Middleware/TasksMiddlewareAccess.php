<?php

namespace IlBronza\Notes\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TasksMiddlewareAccess extends NotesMiddlewareRolesPermissions
{
	public function handle(Request $request, Closure $next) : Response
	{
		$user = $request->user();
		abort_unless($user, 403);
		if ($this->userHasAnyConfiguredRole($user, $this->getRolesForCurrentRoute($request)))
			return $next($request);
		abort_if(config('notes.models.task.class')::isTaskStaff($user), 403);

		$prefix = config('notes.routePrefixTasks');
		$participantRoutes = array_map(fn ($name) => $prefix . $name, [
			'index', 'closed', 'conversation.index', 'conversation.store', 'conversation.attachment',
		]);
		abort_unless(in_array($request->route()?->getName(), $participantRoutes, true), 403);

		// The controller checks access to the requested task. Lists are filtered per user.
		return $next($request);
	}
}
