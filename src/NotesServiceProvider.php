<?php

namespace IlBronza\Notes;

use IlBronza\Notes\Models\Note;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class NotesServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot() : void
	{
		Relation::morphMap([
			'Note' => Note::getProjectClassName()
		]);

		$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'notes');
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'notes');
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
		$this->loadRoutesFrom(__DIR__ . '/../routes/notes.php');

		// Publishing is only necessary when using the CLI.
		if ($this->app->runningInConsole())
		{
			$this->bootForConsole();
		}
	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register() : void
	{
		$this->mergeConfigFrom(__DIR__ . '/../config/notes.php', 'notes');

		// Register the service the package provides.
		$this->app->singleton('notes', function ($app)
		{
			return new Notes;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['notes'];
	}

	/**
	 * Console-specific booting.
	 *
	 * @return void
	 */
	protected function bootForConsole() : void
	{
		// Publishing the configuration file.
		$this->publishes([
			__DIR__ . '/../config/notes.php' => config_path('notes.php'),
		], 'notes.config');

		// Publishing the views.
		/*$this->publishes([
			__DIR__.'/../resources/views' => base_path('resources/views/vendor/ilbronza'),
		], 'notes.views');*/

		// Publishing assets.
		/*$this->publishes([
			__DIR__.'/../resources/assets' => public_path('vendor/ilbronza'),
		], 'notes.views');*/

		// Publishing the translation files.
		/*$this->publishes([
			__DIR__.'/../resources/lang' => resource_path('lang/vendor/ilbronza'),
		], 'notes.views');*/

		// Registering package commands.
		// $this->commands([]);
	}
}
