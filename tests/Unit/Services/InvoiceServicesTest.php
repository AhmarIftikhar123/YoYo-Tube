<?php
namespace Tests\Unit\Services;
use PHPUnit\Framework\Attributes\Test;
use \PHPUnit\Framework\TestCase;
use src\app\Services\InvoiceService;
use src\app\Services\Dependicies\{
          SalesTaxService,
          PaymentGatewayService,
          emailService
};

class InvoiceServicesTest extends TestCase
{
          #[Test]
          public function it_process_invoice()
          {
                    $salesTaxService = $this->createMock(SalesTaxService::class);
                    $PaymentGatewayService = $this->createMock(PaymentGatewayService::class);
                    $emailServie = $this->createMock(emailService::class);

                    // Mocking Dependencies
                    $PaymentGatewayService->method('charge')->willReturn(true);

                    $amount = 125;
                    $customer = ["Ahmar" => "Ahmar49@gmail.com"];
                    $emailServie
                              ->expects($this->once()) // Make sure called once
                              ->method('send') // Method name which called
                              ->with($customer, "recipient"); // Specified argumets.
                    // Given Invoice Service
                    $invoiceService = new InvoiceService($salesTaxService, $PaymentGatewayService, $emailServie);
                    $result = $invoiceService->process($amount, $customer);

                    $this->assertTrue($result);
          }
}