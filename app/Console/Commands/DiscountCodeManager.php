<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DiscountCode;
use Stripe\Stripe;
use Stripe\Coupon;

class DiscountCodeManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount-code:manage {action} {--code= : The discount code} {--discount_percentage= : The discount percentage} {--active= : The active status (true/false)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or delete discount codes from the database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $action = $this->argument('action');
        $code = $this->option('code');
        $discountPercentage = $this->option('discount_percentage');
        $active = $this->option('active');

        if ($action === 'add') {
            $this->addDiscountCode($code, $discountPercentage, $active);
        } elseif ($action === 'delete') {
            $this->deleteDiscountCode($code);
        } else {
            $this->error('Invalid action. Use "add" or "delete".');
        }
    }

    /**
     * Add a new discount code to the database and Stripe.
     *
     * @param string $code
     * @param float $discountPercentage
     * @param bool|null $active
     * @return void
     */
    protected function addDiscountCode($code, $discountPercentage, $active)
    {
        if (!$code || !$discountPercentage) {
            $this->error('Discount code and discount percentage are required.');
            return;
        }

        // Set Stripe API key
        Stripe::setApiKey(config('stripe.secret_key'));

        try {
            // Create Stripe coupon
            $coupon = Coupon::create([
                'percent_off' => $discountPercentage,
                'duration' => 'once',
            ]);

            $discountCode = DiscountCode::create([
                'code' => $code,
                'discount_percentage' => $discountPercentage,
                'active' => $active !== null ? filter_var($active, FILTER_VALIDATE_BOOLEAN) : true,
                'stripe_coupon_id' => $coupon->id,
            ]);

            $this->info("Discount code '{$code}' has been added successfully with Stripe coupon ID: {$coupon->id}.");
        } catch (\Exception $e) {
            $this->error("Error creating discount code: " . $e->getMessage());
        }
    }

    /**
     * Delete a discount code from the database.
     *
     * @param string $code
     * @return void
     */
    protected function deleteDiscountCode($code)
    {
        if (!$code) {
            $this->error('Discount code is required to delete.');
            return;
        }

        $discountCode = DiscountCode::where('code', $code)->first();

        if ($discountCode) {
            $discountCode->delete();
            $this->info("Discount code '{$code}' has been deleted successfully.");
        } else {
            $this->error("Discount code '{$code}' not found.");
        }
    }
}

