<?php

use Spatie\Multitenancy\Jobs\TenantAware;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Mail\SendQueuedMailable;
use Spatie\Multitenancy\Jobs\NotTenantAware;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Queue\CallQueuedClosure;
use Spatie\Multitenancy\Actions\ForgetCurrentTenantAction;
use Spatie\Multitenancy\Actions\MakeQueueTenantAwareAction;
use Spatie\Multitenancy\Actions\MakeTenantCurrentAction;
use Spatie\Multitenancy\Actions\MigrateTenantAction;
use Spatie\Multitenancy\Models\Tenant;

return [

    /*
     * This class is responsible for determining which tenant should be current
     * for the given request.
     */
    'tenant_finder' => Spatie\Multitenancy\TenantFinder\DomainTenantFinder::class,

    /*
     * These tasks will be performed when switching tenants.
     */
    'switch_tenant_tasks' => [],

    /*
     * This class is the model used for storing configuration on tenants.
     */
    'tenant_model' => \App\Models\Tenant::class,

    /*
     * If there is a current tenant when dispatching a job, the id of the current tenant
     * will be automatically set on the job.
     */
    'queues_are_tenant_aware_by_default' => false,

    /*
     * The connection name to reach the tenant database.
     */
    'tenant_database_connection_name' => null, //  PONER null

    /*
     * The connection name to reach the landlord database.
     */
    'landlord_database_connection_name' => null, // PONER null

    /*
     * This key will be used to bind the current tenant in the container.
     */
    'current_tenant_container_key' => 'currentTenant',

];