<?php

namespace App\Console\Commands\Customers;

use App\Models\Customer;
use Illuminate\Console\Command;

class PruneUnverifiedCustomers extends Command
{
    protected $signature = 'customers:prune-unverified';

    protected $description = 'Delete customers who have not verified their email within 24 hours of registration';

    public function handle(): int
    {
        $deleted = Customer::query()
            ->whereNull('email_verified_at')
            ->where('created_at', '<', now()->subHours(24))
            ->delete();

        $this->info("Deleted {$deleted} unverified customer(s).");

        return self::SUCCESS;
    }
}
