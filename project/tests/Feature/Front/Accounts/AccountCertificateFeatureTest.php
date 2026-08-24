<?php

namespace Tests\Feature\Front\Accounts;

use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Products\Repositories\ProductRepository;
use Tests\TestCase;

class AccountCertificateFeatureTest extends TestCase
{
    /** @test */
    public function the_purchaser_sees_the_certificate_link_for_a_purchased_product_with_a_certificate()
    {
        $productRepo = new ProductRepository($this->product);
        $productRepo->saveCertificate([
            'appraiser_name' => 'Jane Doe',
            'grade' => 'AAA',
        ]);

        $order = factory(Order::class)->create(['customer_id' => $this->customer->id]);
        $orderRepo = new OrderRepository($order);
        $orderRepo->associateProduct($this->product);

        $this
            ->actingAs($this->customer, 'web')
            ->get(route('accounts', ['tab' => 'orders']))
            ->assertStatus(200)
            ->assertSee('Certificate of Authenticity')
            ->assertSee('Jane Doe');
    }

    /** @test */
    public function no_certificate_link_is_shown_for_a_purchased_product_without_a_certificate()
    {
        $order = factory(Order::class)->create(['customer_id' => $this->customer->id]);
        $orderRepo = new OrderRepository($order);
        $orderRepo->associateProduct($this->product);

        $response = $this
            ->actingAs($this->customer, 'web')
            ->get(route('accounts', ['tab' => 'orders']))
            ->assertStatus(200);

        $response->assertDontSee('Certificate of Authenticity');
    }
}
