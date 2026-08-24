<?php

namespace Tests\Unit\Certificates;

use App\Shop\Products\Repositories\ProductRepository;
use Tests\TestCase;

class CertificateUnitTest extends TestCase
{
    /** @test */
    public function it_can_save_a_certificate_for_a_product()
    {
        $productRepo = new ProductRepository($this->product);

        $certificate = $productRepo->saveCertificate([
            'appraiser_name' => 'Jane Doe',
            'grade' => 'AAA',
            'serial_number' => 'SN-12345',
        ]);

        $this->assertEquals('Jane Doe', $certificate->appraiser_name);
        $this->assertEquals($this->product->id, $certificate->product_id);
        $this->assertEquals('Jane Doe', $this->product->fresh()->certificate->appraiser_name);
    }

    /** @test */
    public function saving_a_certificate_twice_updates_the_existing_one_instead_of_duplicating()
    {
        $productRepo = new ProductRepository($this->product);

        $productRepo->saveCertificate(['appraiser_name' => 'Jane Doe']);
        $productRepo->saveCertificate(['appraiser_name' => 'John Smith']);

        $this->assertEquals(1, $this->product->fresh()->certificate()->count());
        $this->assertEquals('John Smith', $this->product->fresh()->certificate->appraiser_name);
    }
}
