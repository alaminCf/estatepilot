<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\CommissionService;
use Tests\TestCase;

class CommissionServiceTest extends TestCase
{
    private CommissionService $service;

    /** @var array<string, User> keyed by commission type */
    private array $chain;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new CommissionService();
        $this->chain = $this->buildChain();
    }

    /**
     * Build an in-memory ED → GM → AGM → Manager → Ast. Manager chain
     * using the chart default percentages (no database needed).
     *
     * @return array<string, User>
     */
    private function buildChain(): array
    {
        $users = [];
        $parent = null;
        $id = 1;

        foreach (config('commission.types') as $type => $meta) {
            $user = new User();
            $user->id = $id++;
            $user->commission_type = $type;
            $user->booking_pct = $meta['defaults']['booking'];
            $user->down_pct = $meta['defaults']['down'];
            $user->instalment_pct = $meta['defaults']['instalment'];
            $user->parent_id = $parent?->id;
            $user->setRelation('parent', $parent);

            $users[$type] = $user;
            $parent = $user;
        }

        return $users;
    }

    /**
     * @param array<int, array{user_id:int, percentage:float, amount:float}> $rows
     * @param array<int, float> $expectedAmounts keyed by user id
     */
    private function assertDistribution(array $rows, array $expectedAmounts, float $poolTotal): void
    {
        $this->assertCount(count($expectedAmounts), $rows);

        $actual = collect($rows)->pluck('amount', 'user_id')->all();
        $this->assertEquals($expectedAmounts, $actual);

        $this->assertEqualsWithDelta($poolTotal, array_sum(array_column($rows, 'amount')), 0.001);
    }

    public function test_ed_sale_takes_full_booking_pool(): void
    {
        $rows = $this->service->computeDistribution($this->chain['ed'], 'booking', 100000);

        $this->assertDistribution($rows, [1 => 50000.0], 50000);
    }

    public function test_gm_sale_booking_pool(): void
    {
        $rows = $this->service->computeDistribution($this->chain['gm'], 'booking', 100000);

        $this->assertDistribution($rows, [2 => 47000.0, 1 => 3000.0], 50000);
    }

    public function test_agm_sale_booking_pool(): void
    {
        $rows = $this->service->computeDistribution($this->chain['agm'], 'booking', 100000);

        $this->assertDistribution($rows, [3 => 44000.0, 2 => 3000.0, 1 => 3000.0], 50000);
    }

    public function test_manager_sale_booking_pool(): void
    {
        $rows = $this->service->computeDistribution($this->chain['manager'], 'booking', 100000);

        $this->assertDistribution($rows, [4 => 40000.0, 3 => 4000.0, 2 => 3000.0, 1 => 3000.0], 50000);
    }

    public function test_ast_manager_sale_booking_pool(): void
    {
        $rows = $this->service->computeDistribution($this->chain['ast_manager'], 'booking', 100000);

        $this->assertDistribution(
            $rows,
            [5 => 35000.0, 4 => 5000.0, 3 => 4000.0, 2 => 3000.0, 1 => 3000.0],
            50000
        );
    }

    public function test_ast_manager_sale_down_pool(): void
    {
        $rows = $this->service->computeDistribution($this->chain['ast_manager'], 'down', 100000);

        $this->assertDistribution(
            $rows,
            [5 => 9000.0, 4 => 4000.0, 3 => 3000.0, 2 => 2000.0, 1 => 2000.0],
            20000
        );
    }

    public function test_ast_manager_sale_instalment_pool(): void
    {
        $rows = $this->service->computeDistribution($this->chain['ast_manager'], 'instalment', 100000);

        $this->assertDistribution(
            $rows,
            [5 => 6000.0, 4 => 3000.0, 3 => 2000.0, 2 => 2000.0, 1 => 2000.0],
            15000
        );
    }

    public function test_seller_share_is_residual_with_custom_overrides(): void
    {
        // Admin lowered the GM's booking override to 1% — ED keeps 3%, seller absorbs the difference.
        $this->chain['gm']->booking_pct = 1;

        $rows = $this->service->computeDistribution($this->chain['agm'], 'booking', 100000);

        $this->assertDistribution($rows, [3 => 46000.0, 2 => 1000.0, 1 => 3000.0], 50000);
    }

    public function test_seller_share_clamped_when_overrides_exceed_pool(): void
    {
        $this->chain['ed']->booking_pct = 60;

        $rows = $this->service->computeDistribution($this->chain['gm'], 'booking', 100000);

        $this->assertSame(0.0, $rows[0]['amount']);
        $this->assertSame(60000.0, $rows[1]['amount']);
    }

    public function test_override_falls_back_to_type_defaults_when_unset(): void
    {
        $this->chain['ed']->booking_pct = null;

        $this->assertSame(3.0, $this->service->overrideFor($this->chain['ed'], 'booking'));
    }

    public function test_payment_type_pool_mapping(): void
    {
        $this->assertSame('booking', $this->service->poolForPaymentType('Booking Payment'));
        $this->assertSame('down', $this->service->poolForPaymentType('Down Payment'));
        $this->assertSame('instalment', $this->service->poolForPaymentType('Installment Payment'));
        $this->assertSame('instalment', $this->service->poolForPaymentType('Part Of Installment'));
        $this->assertNull($this->service->poolForPaymentType('Unknown Type'));
    }
}
