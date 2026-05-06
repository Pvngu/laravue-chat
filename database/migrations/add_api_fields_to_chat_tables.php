<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Musonza\Chat\ConfigurationManager;

class AddApiFieldsToChatTables extends Migration
{
    protected function schema()
    {
        $connection = config('musonza_chat.database_connection');
        return $connection ? Schema::connection($connection) : Schema::getFacadeRoot();
    }

    public function up()
    {
        $this->schema()->table(ConfigurationManager::MESSAGES_TABLE, function (Blueprint $table) {
            $table->boolean('is_edited')->default(false);
            $table->boolean('is_forwarded')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->unsignedBigInteger('reply_to_id')->nullable();
            $table->text('attachments')->nullable();
        });

        $this->schema()->table(ConfigurationManager::PARTICIPATION_TABLE, function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_favorited')->default(false);
            $table->boolean('is_archived')->default(false);
        });
    }

    public function down()
    {
        $this->schema()->table(ConfigurationManager::MESSAGES_TABLE, function (Blueprint $table) {
            $table->dropColumn(['is_edited', 'is_forwarded', 'is_pinned', 'reply_to_id', 'attachments']);
        });

        $this->schema()->table(ConfigurationManager::PARTICIPATION_TABLE, function (Blueprint $table) {
            $table->dropColumn(['is_pinned', 'is_favorited', 'is_archived']);
        });
    }
}
