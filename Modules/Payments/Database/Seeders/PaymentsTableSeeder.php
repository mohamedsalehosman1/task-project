<?php

namespace Modules\Payments\Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bar = $this->command->getOutput()->createProgressBar(
            count($this->payments())
        );

        $bar->start();

        foreach ($this->payments() as $payment) {
            \Modules\Payments\Entities\Payment::create($payment);

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\n Payments seeded successfully");
    }

    private function payments()
    {
        return [
            [
                'name:ar' => 'الدفع من المحفظة',
                'name:en' => 'Pay from wallet',
                'active' => true,
            ],
            [
                'name:ar' => 'الدفع عند الاستلام',
                'name:en' => 'Pay on Delivery',
                'active' => true,
            ],
            [
                'name:ar' => 'الدفع الالكتروني',
                'name:en' => 'ُElectronic Payment',
                'active' => true,
            ]
        ];
    }
}
