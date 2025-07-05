<?php

namespace App\Library;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Exceptions\InvalidConfiguration;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class SwitchTDatabaseTask implements SwitchTenantTask
{
    use UsesMultitenancyConfig;

    public function makeCurrent(IsTenant $tenant): void
    {
        $this->setTenantConnectionDatabaseName($tenant->getDatabaseName());
    }

    public function forgetCurrent(): void
    {
        $this->setTenantConnectionDatabaseName(null);
    }

    protected function setTenantConnectionDatabaseName(?string $databaseName): void
    {
        $tenantConnectionName = $this->tenantDatabaseConnectionName();

        if ($tenantConnectionName === $this->landlordDatabaseConnectionName()) {
            throw InvalidConfiguration::tenantConnectionIsEmptyOrEqualsToLandlordConnection();
        }

        if (is_null(config("database.connections.{$tenantConnectionName}"))) {
            throw InvalidConfiguration::tenantConnectionDoesNotExist($tenantConnectionName);
        }
        ////////////////////////////////////////
        ////////////////////////////////////////
        // before switch database we can do tasks here

        ////////////////////////////////////////
        ////////////////////////////////////////

        config([
            "database.connections.{$tenantConnectionName}.database" => $databaseName,
            // 'database.default' =>  $tenantConnectionName ?? 'pgsqlt',
        ]);


        app('db')->extend($tenantConnectionName, function ($config, $name) use ($databaseName) {
            $config['database'] = $databaseName;

            return app('db.factory')->make($config, $name);
        });

        DB::purge($tenantConnectionName);


        Model::setConnectionResolver(app('db'));

        ////////////////////////////////////////
        ////////////////////////////////////////
        // after switch database we can do tasks here
        Log::info("SwitchTDatabaseTask: " . $databaseName);
        ////////////////////////////////////////
        ////////////////////////////////////////
    }
}
