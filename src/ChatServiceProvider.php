<?php

namespace Musonza\Chat;

use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishMigrations();
        $this->publishConfig();

        if (config('musonza_chat.should_load_routes')) {
            require __DIR__ . '/Http/routes.php';
        }
    }

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/musonza_chat.php', 'musonza_chat');
        $this->registerChat();
    }

    /**
     * Registers Chat.
     *
     * @return void
     */
    private function registerChat()
    {
        $this->app->bind('\Musonza\Chat\Chat', function () {
            return $this->app->make(Chat::class);
        });
    }

    /**
     * Publish package's migrations.
     *
     * @return void
     */
    public function publishMigrations()
    {
        // $timestamp = date('Y_m_d_His', time());
        $stub = __DIR__ . '/../database/migrations/create_chat_tables.php';
        $target = $this->app->databasePath() . '/migrations/' . date('Y_m_d_His', time()) . '_create_chat_tables.php';

        $encryptionStub = __DIR__ . '/../database/migrations/add_is_encrypted_to_messages_table.php';
        $encryptionTarget = $this->app->databasePath() . '/migrations/' . date('Y_m_d_His', time() + 100) . '_add_is_encrypted_to_messages_table.php';

        $reactionsStub = __DIR__ . '/../database/migrations/add_reactions_to_messages.php';
        $reactionsTarget = $this->app->databasePath() . '/migrations/' . date('Y_m_d_His', time() + 200) . '_add_reactions_to_messages.php';

        $reactionStub = __DIR__ . '/../database/migrations/add_name_to_conversations_table.php';
        $reactionTarget = $this->app->databasePath() . '/migrations/' . date('Y_m_d_His', time() + 300) . '_add_name_to_conversations_table.php';

        $apiFieldsStub = __DIR__ . '/../database/migrations/add_api_fields_to_chat_tables.php';
        $apiFieldsTarget = $this->app->databasePath() . '/migrations/' . date('Y_m_d_His', time() + 400) . '_add_api_fields_to_chat_tables.php';

        $this->publishes([
            $stub => $target,
            $encryptionStub => $encryptionTarget,
            $reactionsStub => $reactionsTarget,
            $reactionStub => $reactionTarget,
            $apiFieldsStub => $apiFieldsTarget,
        ], 'chat.migrations');
    }

    /**
     * Publish package's config file.
     *
     * @return void
     */
    public function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config' => config_path(),
        ], 'chat.config');
    }
}
